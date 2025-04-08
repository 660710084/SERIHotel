<?php
session_start();
include 'connect.php';

if (isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}

$lang_code = $_SESSION['lang'] ?? 'en';
include "lang/$lang_code.php";

function calculateNights($checkIn, $checkOut) {
  $start = new DateTime($checkIn);
  $end = new DateTime($checkOut);
  return $start->diff($end)->days;
}

// รับค่าจากฟอร์ม
$room = $_POST['roomType'] ?? '';
$checkIn = $_POST['checkIn'] ?? '';
$checkOut = $_POST['checkOut'] ?? '';
$guests = $_POST['guests'] ?? 1;
$breakfast = $_POST['breakfast'] ?? 'no';
$breakfastPrice = 0;
$nights = calculateNights($checkIn, $checkOut);
$room_key = strtolower($room);
$room_lang_key = "room_".$room_key;

// ราคาต่อคน/คืน
$priceTable = [
  "Standard" => 1200,
  "Deluxe" => 2000,
  "Suite" => 3500
];

$pricePerPersonPerNight = $priceTable[$room] ?? 0;
$totalPrice = $pricePerPersonPerNight * $nights * $guests;
if ($breakfast === 'yes'){
    $breakfastPrice = 200 * $nights * $guests;
}
$totalPrice += $breakfastPrice;
?>

<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/jpg" href="image/SeriLogo.png">
  <title><?php echo $lang['confirm_title']; ?></title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-image: url("image/midNight_blur2_5px.jpg");
      background-size: cover;
      color: #333;
    }

    .confirmation-box {
      max-width: 600px;
      margin: 50px auto;
      background: white;
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      font-size: 32px;
      margin-bottom: 30px;
      color: #2c3e50;
    }

    .summary p {
      font-size: 18px;
      margin: 10px 0;
    }

    .price {
      font-size: 22px;
      font-weight: bold;
      color: #b8860b;
      margin-top: 20px;
    }

    .confirm-btn {
      margin-top: 30px;
      background: linear-gradient(to right, #d4af37, #8b7500);
      color: white;
      border: none;
      padding: 15px 30px;
      border-radius: 10px;
      font-size: 18px;
      cursor: pointer;
      transition: 0.3s;
    }

    .confirm-btn:hover {
      transform: scale(1.05);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>
  <div class="confirmation-box">
    <h1><?php echo $lang['confirm_book']; ?></h1>
    <div class="summary">
      <p><strong><?php echo $lang['room_type']; ?></strong> <?php echo $lang[$room_lang_key]; ?></p>
      <p><strong><?php echo $lang['checkin']; ?></strong> <?php echo htmlspecialchars($checkIn); ?></p>
      <p><strong><?php echo $lang['checkout']; ?></strong> <?php echo htmlspecialchars($checkOut); ?></p>
      <p><strong><?php echo $lang['guests']; ?></strong> <?php echo htmlspecialchars($guests); ?></p>
      <p><strong><?php echo $lang['night']; ?></strong> <?php echo $nights; ?></p>
      <p><strong><?php echo $lang['breakfast']; ?></strong>
      <?php echo ($breakfast === 'yes') ? $lang['breakfast_yes'] : $lang['breakfast_no']; ?>
      </p>
        <?php if($breakfast === 'yes'): ?>
        <p><strong><?php echo $lang['breakfast_cost']; ?></strong> ฿<?php echo number_format($breakfastPrice); ?></p>
        <?php endif; ?>
      <p><strong><?php echo $lang['price_per_person']; ?></strong> ฿<?php echo number_format($pricePerPersonPerNight); ?></p>
      <p class="price"><?php echo $lang['total']; ?><?php echo number_format($totalPrice); ?></p>
    </div>

    <form action="success.php" method="post">
      <input type="hidden" name="room" value="<?php echo $room; ?>">
      <input type="hidden" name="checkIn" value="<?php echo $checkIn; ?>">
      <input type="hidden" name="checkOut" value="<?php echo $checkOut; ?>">
      <input type="hidden" name="guests" value="<?php echo $guests; ?>">
      <input type="hidden" name="breakfast" value="<?php echo $breakfast; ?>">
      <input type="hidden" name="price" value="<?php echo $totalPrice; ?>">
      <button class="confirm-btn" type="submit"><?php echo $lang['pay_now']; ?></button>
    </form>

  </div>
</body>
</html>