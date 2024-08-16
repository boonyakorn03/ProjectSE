<?php
// เชื่อมต่อกับฐานข้อมูล
$host = 'localhost';
$dbname = 'junsuriya';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");

    // ตรวจสอบการกดปุ่ม Submit
    if (isset($_POST['submit'])) {
        // รับค่าจากฟอร์ม
        $phone = $_POST['phone'];
        $room_number = $_POST['room_number'];
        $new_password = substr($_POST['new_password'], 0, 10); // ตัดรหัสผ่านให้เหลือเพียง 10 ตัวอักษร
        $confirm_password = $_POST['confirm_password'];

        // ตรวจสอบว่ารหัสผ่านใหม่ตรงกันหรือไม่
        if ($new_password !== $confirm_password) {
            echo "<script>alert('รหัสผ่านใหม่ไม่ตรงกัน');</script>";
        } else {
            // ตรวจสอบเบอร์โทรและหมายเลขห้องในฐานข้อมูล
            $sql = "SELECT * FROM Member WHERE Mem_Contect = :phone AND Room_ID = (SELECT Room_ID FROM Room WHERE Room_Number = :room_number)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':room_number', $room_number);
            $stmt->execute();
            $count = $stmt->rowCount();

            if ($count > 0) {
                // อัปเดตรหัสผ่านใหม่ในฐานข้อมูล
                $update_sql = "UPDATE Member SET Mem_Password = :password WHERE Mem_Contect = :phone AND Room_ID = (SELECT Room_ID FROM Room WHERE Room_Number = :room_number)";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bindParam(':password', $new_password);
                $update_stmt->bindParam(':phone', $phone);
                $update_stmt->bindParam(':room_number', $room_number);
                
                if ($update_stmt->execute()) {
                    echo "<script>alert('อัปเดตรหัสผ่านสำเร็จ'); window.location='login.php';</script>";
                } else {
                    echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตรหัสผ่าน');</script>";
                }                
            } else {
                echo "<script>alert('เบอร์โทรหรือหมายเลขห้องไม่ถูกต้อง');</script>";
            }
        }
    }
} catch (PDOException $e) {
    echo "เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>
