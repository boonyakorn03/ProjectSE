<?php
// เรียกใช้ session
session_start();

// ลบข้อมูล session ทั้งหมด
session_unset();

// ทำลาย session
session_destroy();

// ส่งกลับไปยัง homepage.php
header("Location: homepage.php");
exit;
?>
