<?php
session_start();
include 'connect.php';

if (isset($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];
}

$lang_code = $_SESSION['lang'] ?? 'en';
include "lang/$lang_code.php";

if (!isset($_SESSION['email']) || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$booking_id = $_GET['id'];
$email = $_SESSION['email'];

$stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_email = ?");
$stmt->bind_param("is", $booking_id, $email);
$stmt->execute();

$_SESSION['cancel_success'] = true;
header("Location: myBooking.php");
exit();
?>