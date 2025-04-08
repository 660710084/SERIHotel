<?php
session_start();

if (isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}

$lang_code = $_SESSION['lang'] ?? 'en';
include "lang/$lang_code.php";
?>

<!DOCTYPE html>
<html lang="<?php echo $lang_code; ?>">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title><?php echo $lang['page_title']; ?></title>
  <link rel="icon" type="image/jpg" href="image/SeriLogo.png">
  <link rel="stylesheet" href="style.css" />
</head>
<body class="b2">

  <!-- Navbar -->
  <header>
    <nav class="navbar">
      <div class="logo"><?php echo $lang['name_hotel']; ?></div>
      <ul class="nav-links">
        <li><a href="index.php?lang=<?php echo $lang_code; ?>"><?php echo $lang['nav_home']; ?></a></li>
        <!-- หากต้องการให้ไปหน้า Booking เดิมของคุณ ให้ลิงก์ไปยัง Booking.html -->
        <li><a href="booking.php?lang=<?php echo $lang_code; ?>"><?php echo $lang['nav_booking']; ?></a></li>
        <li><a href="myBooking.php?lang=<?php echo $lang_code; ?>"><?php echo $lang['my_book']; ?></a></li>
        <?php if (isset($_SESSION['email'])): ?>
          <li><span class="user-name"><?php echo $_SESSION['fName'] . ' ' . $_SESSION['lName']; ?></span></li>
          <li><a href="Logout.php?lang=<?php echo $lang_code; ?>"><?php echo $lang['nav_logout']; ?></a></li>
        <?php else: ?>
          <li><a href="Login.php?lang=<?php echo $lang_code; ?>"><?php echo $lang['nav_login']; ?></a></li>
        <?php endif; ?>
        <li class="language-switch">
          <a href="?lang=en">EN</a> | <a href="?lang=th">TH</a>
        </li>
      </ul>
    </nav>
  </header>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1><?php echo $lang['welcome']; ?></h1>
      <p><?php echo $lang['description']; ?></p>
      <a href="booking.php?lang=<?php echo $lang_code; ?>" class="hero-btn"><?php echo $lang['book_now']; ?></a>
    </div>
  </section>

  <!-- Intro Text Section -->
<section class="room-intro">
  <h2><?php echo $lang['room_heading']; ?></h2>
  <p><?php echo $lang['room_subtext']; ?></p>
</section>

<section class="room-full-slider">
  <div class="slider-wrapper">
    <div class="slide active" style="background-image: url('image/standardRoom.jpg')">
      <div class="slide-caption"><?php echo $lang['room_standard']; ?></div>
    </div>
    <div class="slide" style="background-image: url('image/deluxeRoom.jpg')">
      <div class="slide-caption"><?php echo $lang['room_deluxe']; ?></div>
    </div>
    <div class="slide" style="background-image: url('image/suiteRoom.jpg')">
      <div class="slide-caption"><?php echo $lang['room_suite']; ?></div>
    </div>

    <!-- Arrows -->
    <button class="nav-arrow left" onclick="prevSlide()">&#10094;</button>
    <button class="nav-arrow right" onclick="nextSlide()">&#10095;</button>
    <script>
      let currentSlide = 0;
      const slides = document.querySelectorAll('.slide');

      function showSlide(index) {
        slides.forEach((slide, i) => {
          slide.classList.remove('active');
          if (i === index) slide.classList.add('active');
        });
      }

      function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
      }

      function prevSlide() {
        currentSlide = (currentSlide - 1 + slides.length) % slides.length;
        showSlide(currentSlide);
      }

      setInterval(nextSlide, 5000);

    </script>
  </div>
</section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 SERI HOTEL. <?php echo $lang['footer']; ?></p>
  </footer>
</body>
</html>