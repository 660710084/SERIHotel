<?php
session_start();
session_unset(); // ล้างค่าใน $_SESSION ทั้งหมด
session_destroy(); // จบ session
header("Location: index.php"); // กลับหน้าแรก
exit();