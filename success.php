<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['success_booking']) && isset($_GET['done'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['email'])) {
    header("Location: Login.php");
    exit();
}

if (isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}

$lang_code = $_SESSION['lang'] ?? 'en';
include "lang/$lang_code.php";

if (!isset($_GET['done']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $room = $_POST['room'];
    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $guests = $_POST['guests'];
    $breakfast = $_POST['breakfast'];
    $price = $_POST['price'];

    // insert จอง
    $stmt = $conn->prepare("INSERT INTO bookings (user_email, room, check_in, check_out, guests, breakfast, total_price)
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $email, $room, $checkIn, $checkOut, $guests, $breakfast, $price);
    $stmt->execute();

    $_SESSION['success_booking'] = [
        'room' => $room,
        'checkIn' => $checkIn,
        'checkOut' => $checkOut,
        'guests' => $guests,
        'breakfast' => $breakfast,
        'price' => $price,
        'shown' => false  // ยังไม่แสดง
    ];

    header("Location: success.php?done=1");
    exit();
}

$data = $_SESSION['success_booking'] ?? null;
$showFullDetail = $data && isset($_GET['done']) && !$data['shown'];

if ($data && !$data['shown']) {
    $_SESSION['success_booking']['shown'] = true;
}

$room = $data['room'] ?? '';
$checkIn = $data['checkIn'] ?? '';
$checkOut = $data['checkOut'] ?? '';
$guests = (int)($data['guests'] ?? 1);
$breakfast = $data['breakfast'] ?? 'no';
$price = (float)($data['price'] ?? 0);

$room_key = strtolower($room); 
$room_label = $lang['room_' . $room_key] ?? htmlspecialchars($room);

?>

<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
  <meta charset="UTF-8">
  <title><?php echo $lang['payment_title']; ?></title>
  <link rel="icon" type="image/jpg" href="image/SeriLogo.png">
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Helvetica Neue', Arial, sans-serif;
      background: url("image/BangkokView_blur2_5px.jpg") no-repeat center center fixed;
      background-size: cover;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }

    .success-box {
      background: rgba(0, 0, 0, 0.6);
      backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      max-width: 500px;
      width: 90%;
    }

    .success-box h1 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #d4af37;
    }

    .success-box p {
      font-size: 1.1rem;
      margin-bottom: 10px;
    }

    .success-box strong {
      color: #fdd76e;
    }

    .back-btn {
      margin-top: 30px;
      display: inline-block;
      padding: 14px 32px;
      background: linear-gradient(to right, #d4af37, #b8860b, #8b7500);
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: background 0.3s ease;
    }

    .back-btn:hover {
      background: #d4af37;
    }
  </style>
</head>
<body>
  <div class="success-box">
    <h1><?php echo $lang['payment_success']; ?></h1>
    <?php if ($showFullDetail): ?>
        <p><?php echo $lang['thank_you'] . ' <strong>' . $room_label . '</strong>'; ?></p>
        <p><?php echo sprintf($lang['from_to'], $data['checkIn'], $data['checkOut']); ?></p>
        <p><?php echo sprintf($lang['guest_count'], $data['guests']); ?></p>
        <p><strong><?php echo sprintf($lang['total_paid1'], number_format($data['price']), 2); ?></strong></p>
    <?php endif; ?>

    <a href="index.php?lang=<?php echo $lang_code; ?>" class="back-btn">← <?php echo $lang['back_to_home'] ?? 'Back to Home'; ?></a>
  </div>

</body>
</html>

<?php
// ล้างถ้าแสดงครบแล้ว
if (isset($_SESSION['success_booking']['shown']) && $_SESSION['success_booking']['shown']) {
    unset($_SESSION['success_booking']);
}
?>