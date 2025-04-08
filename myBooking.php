<?php
session_start();
include 'connect.php';

if (isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}

$lang_code = $_SESSION['lang'] ?? 'en';
include "lang/$lang_code.php";

if (!isset($_SESSION['email'])) {
    header("Location: Login.php");
    exit();
}

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_email = ? ORDER BY booked_at DESC");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
  <meta charset="UTF-8">
  <title><?php echo $lang['my_book']; ?> | <?php echo $lang['name_hotel']; ?></title>
  <link rel="icon" type="image/jpg" href="image/SeriLogo.png">
  <style>
    body {
      font-family: 'Helvetica Neue', sans-serif;
      background: url("image/BangkokView_blur2_5px.jpg") no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      color: #fff;
    }

    .container {
      max-width: 900px;
      margin: 60px auto;
      background: rgba(0, 0, 0, 0.6);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    h1 {
      text-align: center;
      color: #fdd76e;
      margin-bottom: 40px;
    }

    .booking-item {
      background: rgba(255,255,255,0.1);
      padding: 20px 30px;
      border-radius: 15px;
      margin-bottom: 25px;
      border-left: 5px solid #d4af37;
    }

    .booking-item p {
      margin: 5px 0;
      font-size: 16px;
    }

    .highlight {
      color: #ffd700;
      font-weight: bold;
    }

    .no-booking {
      text-align: center;
      font-size: 18px;
      padding: 40px;
      color: #eee;
    }

    a.back-btn {
      display: inline-block;
      margin-top: 30px;
      background: linear-gradient(to right, #d4af37, #8b7500);
      color: #fff;
      padding: 12px 28px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: 0.3s;
    }

    a.back-btn:hover {
      background: #d4af37;
    }

    .center {
      text-align: center;
    }

    .cancel-btn a {
      color: #e74c3c;
      font-weight: bold;
      font-size: 16px;
      text-decoration: none;
      transition: 0.3s;
    }

    .cancel-btn a:hover {
      color: #ff0000;
      text-shadow: 0 0 8px rgba(255, 0, 0, 0.8);
    }

  /* Popup overlay */
  .overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    backdrop-filter: blur(3px);
    z-index: 1000;
    display: none;
    justify-content: center;
    align-items: center;
  }

  .popup {
    background: #fff;
    color: #2c3e50;
    padding: 30px 40px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    text-align: center;
    max-width: 400px;
    animation: fadeIn 0.3s ease;
  }

  .popup h3 {
    margin-bottom: 20px;
    font-size: 20px;
  }

  .popup button {
    padding: 10px 20px;
    margin: 0 10px;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
  }

  .popup .confirm {
    background: #e74c3c;
    color: #fff;
    border: none;
  }

  .popup .cancel {
    background: #bdc3c7;
    border: none;
  }

  @keyframes fadeIn {
    from {opacity: 0; transform: scale(0.95);}
    to {opacity: 1; transform: scale(1);}
  }

  .cancel-alert {
    background: rgba(255, 255, 255, 0.1);
    color: #fdd76e;
    padding: 20px 30px;
    margin-bottom: 25px;
    border-radius: 15px;
    border-left: 5px solid #e74c3c;
    font-weight: bold;
    font-size: 17px;
  }

  </style>
</head>
<body>
  <div class="container">
    <h1><?php echo $lang['my_book']; ?></h1>

    <?php if (isset($_SESSION['cancel_success'])): ?>
      <div class="booking-item cancel-alert">
        <?php echo $lang['cancel_success'] ?? 'Booking cancelled successfully.'; ?>
      </div>
      <?php unset($_SESSION['cancel_success']); ?>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()): ?>
        <div class="booking-item">
          <p><?php echo $lang['room_type']; ?> <span class="highlight"><?php echo htmlspecialchars($lang['room_' . strtolower($row['room'])] ?? $row['room']); ?></span></p>
          <p><?php echo $lang['checkin']; ?> <?php echo $row['check_in']; ?></p>
          <p><?php echo $lang['checkout']; ?> <?php echo $row['check_out']; ?></p>
          <p><?php echo $lang['guests']; ?> <?php echo $row['guests']; ?></p>
          <p><?php echo $lang['breakfast']; ?> <?php echo ($row['breakfast'] === 'yes') ? $lang['breakfast_yes'] : $lang['breakfast_no']; ?></p>
          <p><?php echo $lang['total_paid2']; ?> <span class="highlight">฿<?php echo number_format($row['total_price']); ?></span></p>
          <p class="cancel-btn">
            <a href="#" onclick="openPopup(<?php echo $row['id']; ?>)">
              <?php echo $lang['cancel_booking']; ?>
            </a>
          </p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="no-booking"><?php echo $lang['no_booking'] ?? 'No bookings found.'; ?></div>
    <?php endif; ?>

    <div class="center">
      <a href="index.php?lang=<?php echo $lang_code; ?>" class="back-btn">← <?php echo $lang['back_to_home'] ?? 'Back to Home'; ?></a>
    </div>
  </div>

  <!-- Popup overlay -->
  <div id="popup-overlay" class="overlay">
    <div class="popup">
      <h3><?php echo $lang['confirm_cancel']; ?></h3>
      <form id="cancel-form" method="get" action="cancel_booking.php">
        <input type="hidden" name="id" id="cancel-id">
        <button type="submit" class="confirm"><?php echo $lang['confirm']; ?></button>
        <button type="button" class="cancel" onclick="closePopup()"><?php echo $lang['close']; ?></button>
      </form>
    </div>
  </div>

  <script>
    function openPopup(id) {
      document.getElementById('popup-overlay').style.display = 'flex';
      document.getElementById('cancel-id').value = id;
    }

    function closePopup() {
      document.getElementById('popup-overlay').style.display = 'none';
    }
  </script>
</body>
</html>