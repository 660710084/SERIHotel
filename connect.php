<?php

$servername = "sql101.infinityfree.com";  // แทน XXX ด้วยตัวเลขที่ InfinityFree ให้มา
$username = "if0_38698439";              // ใส่ชื่อผู้ใช้ฐานข้อมูลของคุณ
$password = "IVDIAhttntlz";           // ใส่รหัสผ่านฐานข้อมูลของคุณ
$dbname = "if0_38698439_seri_db";   // ใส่ชื่อฐานข้อมูลของคุณ

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8");

?>