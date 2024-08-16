<?php
include 'db.php'; // เชื่อมต่อกับไฟล์ config.php เพื่อใช้งานตัวแปรเชื่อมต่อฐานข้อมูล

// ตรวจสอบว่ามีการส่งค่า ID ของการแจ้งซ่อมมาหรือไม่
if (isset($_POST['id'])) {
    // รับค่า ID ของการแจ้งซ่อมจากการส่งคำขอ POST
    $id = $_POST['id'];

    // สร้างคำสั่ง SQL เพื่ออัพเดทสถานะของงานแจ้งซ่อมเป็น "สำเร็จ"
    $updateQuery = "UPDATE reparidetail SET Status = 'T' WHERE RepariDetail_ID = $id";

    // ทำการอัพเดทฐานข้อมูล
    if (mysqli_query($conn, $updateQuery)) {
        // ส่งคำตอบกลับไปยังเว็บเพจว่าการอัพเดทสถานะสำเร็จ
        echo 'success';
    } else {
        // กรณีเกิดข้อผิดพลาดในการอัพเดทฐานข้อมูล
        echo 'error';
    }
} else {
    // กรณีที่ไม่มีการส่งค่า ID ของการแจ้งซ่อมมากับคำขอ POST
    echo 'invalid request';
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
mysqli_close($conn);
?>