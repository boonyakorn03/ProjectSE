<?php
session_start();

// ลบ session ทั้งหมด
session_destroy();

// ส่งกลับไปยังหน้าหลักหรือหน้า login
header("Location: employlogin.php"); // เปลี่ยนเส้นทางตามที่ต้องการ
exit();
?>
