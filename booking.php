<?php
session_start();

if (isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}

$lang_code = $_SESSION['lang'] ?? 'en';
include "lang/$lang_code.php";

if (!isset($_SESSION['email'])) {
  header("Location: Login.php");
  exit();
}

?>

<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/jpg" href="image/SeriLogo.png">
  <title><?php echo $lang['booking_title']; ?></title>
  <style>
    /* Reset พื้นฐาน */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    /* ตั้งค่าพื้นฐานของ body */
    body {
      font-family: 'Helvetica Neue', Arial, sans-serif;
      background-color: #fff;
      color: #333;
      line-height: 1.6;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      background: url("image/BangkokView_blur2_5px.jpg");
      background-size: cover;
    }
    /* Header */
    header {
      padding: 20px 40px;
      text-align: center;
      background-color: #fff;
      border-bottom: 1px solid #eee;
    }
    header h1 {
      font-size: 2rem;
      font-weight: 600;
      letter-spacing: 1px;
    }
    nav ul {
      list-style: none;
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 10px;
    }
    nav ul li a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
      transition: color 0.3s;
    }
    nav ul li a:hover {
      color: #007BFF;
    }
    /* Section สำหรับฟอร์ม Booking */
    section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
    }
    /* กล่องฟอร์มที่มีความรู้สึกมินิมอลและโปรเฟสชันแนล */
    .booking-form-container {
      background-color: #f9f9f9;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
      max-width: 500px;
      width: 100%;
    }
    .booking-form-container h2 {
      font-size: 1.8rem;
      text-align: center;
      margin-bottom: 30px;
      font-weight: 500;
    }
    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    form label {
      font-size: 1rem;
      font-weight: 500;
      margin-bottom: 5px;
    }
    form select,
    form input[type="date"],
    form input[type="number"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
      background-color: #fff;
      font-size: 1rem;
    }
    form button[type="submit"] {
      padding: 14px;
      font-size: 1.1rem;
      background: linear-gradient(to right, #d4af37, #b8860b, #8b7500);
      border: none;
      border-radius: 4px;
      color: #fff;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    form button[type="submit"]:hover {
      background-color: #0056b3;
    }

    /*-----------------------อาหารเช้า--------------------------*/
    .input-group {
      margin: 20px 0;
    }

    .label-title {
      font-size: 18px;
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 10px;
      display: block;
    }

    .radio-group {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .radio-group label {
      font-size: 16px;
      color: #444;
      position: relative;
      padding-left: 30px;
      cursor: pointer;
      display: flex;
      align-items: center;
    }

    .radio-group input[type="radio"] {
      position: absolute;
      opacity: 0;
    }

    .radio-group span::before {
      content: "";
      position: absolute;
      left: 0;
      top: 3px;
      width: 18px;
      height: 18px;
      border: 2px solid #b8860b;
      border-radius: 50%;
      background: #fff;
    }

    .radio-group input[type="radio"]:checked + span::before {
      background: radial-gradient(circle, #d4af37 45%, #fff 46%);
    }

    /* Footer */
    footer {
      text-align: center;
      padding: 20px;
      background-color: #fff;
      border-top: 1px solid #eee;
      font-size: 0.9rem;
      color: #666;
    }
    /* Responsive สำหรับอุปกรณ์หน้าจอเล็ก */
    @media (max-width: 600px) {
      header {
        padding: 20px;
      }
      section {
        padding: 20px;
      }
      .booking-form-container {
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1><?php echo $lang['booking_header']; ?></h1>
    <nav>
      <ul>
        <li><a href="index.php?lang=<?php echo $lang_code; ?>"><?php echo $lang['nav_home']; ?></a></li>
        <li><a href="booking.php"><?php echo $lang['nav_booking']; ?></a></li>
        <li><a href="Login.php"><?php echo $lang['nav_login']; ?></a></li>
        <li><a href="#"><?php echo $lang['nav_contact']; ?></a></li>
      </ul>
    </nav>
  </header>

  <section>
    <div class="booking-form-container">
      <h2><?php echo $lang['book_room']; ?></h2>
      <form action="confirmation.php" method="post">
        <label for="roomType"><?php echo $lang['room_type']; ?></label>
        <select id="roomType" name="roomType">
          <option value="Standard"><?php echo $lang['standard']; ?></option>
          <option value="Deluxe"><?php echo $lang['deluxe']; ?></option>
          <option value="Suite"><?php echo $lang['suite']; ?></option>
        </select>

        <label for="checkIn"><?php echo $lang['checkin']; ?></label>
        <input type="date" id="checkIn" name="checkIn" required>

        <label for="checkOut"><?php echo $lang['checkout']; ?></label>
        <input type="date" id="checkOut" name="checkOut" required>

        <label for="guests"><?php echo $lang['guests']; ?></label>
        <input type="number" id="guests" name="guests" min="1" required>

        <!-- Breakfast Option -->
        <div class="input-group">
          <label class="label-title"><?php echo $lang['breakfast_question']; ?></label>
          <div class="radio-group">
            <label>
              <input type="radio" name="breakfast" value="yes" required> 
              <span><?php echo $lang['breakfast_yes']; ?></span>
            </label>
            <label>
              <input type="radio" name="breakfast" value="no"> 
              <span><?php echo $lang['breakfast_no']; ?></span>
            </label>
          </div>
        </div>

        <button type="submit"><?php echo $lang['book_now']; ?></button>
      </form>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 SERI HOTEL. <?php echo $lang['footer']; ?></p>
  </footer>
</body>
</html>