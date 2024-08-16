<?php
session_start();

$host = 'localhost';
$dbname = 'Junsuriya';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานสรุป</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    .bar{
            background:#85D2D0;
        }
        .nav-link{
            color: #4f4990;
        }
        .nav-link:hover{
            color: #5d5f5f;
        }

    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Junsuriya</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="problem.php">ปัญหาของลูกหอ</a>   <!-- เปลี่ยนเป็นลิ้งหน้าแจ้งปัญหา (หน้าที่คุณรุ้งเห็น) -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="repair.php">ลูกหอแจ้งซ่อม</a>    <!-- เปลี่ยนเป็นลิ้งหน้าแจ้งซ่อม (หน้าที่พี่เดชเห็น) -->
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registers.php">บันทึกข้อมูลผู้เช่า</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="savebill.php">กรอกข้อมูลรายเดือน</a>    
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="manage.php">จัดการรายชื่อ</a>    
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="summary.php">รายงานสรุปผล</a>    <!-- เปลี่ยนเป็นลิ้งของรายงานสรุปหน้าสุดท้าย -->
                        </li>
                    </ul>
                </div>
                <div class="dropdown" style="margin-right: 20px;">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php
                        if (isset($_SESSION['user_name'])) {
                            echo '<i class="fas fa-user icon" style="margin-right: 10px;"></i>' . $_SESSION['user_name'];
                        } else {
                            echo 'Login';
                        }
                        ?>
                    </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php
                            if (isset($_SESSION['user_name'])) {
                                echo '<li><a class="dropdown-item" href="logout_employee.php">Logout</a></li>';
                            }
                            ?>
                        </ul>
                </div>
            </div>
        </nav>
    </header>
<body>
<main class="container mt-5">
    <h1 class="text-center mb-4">รายงานสรุป</h1>

    <!-- Form เลือกเดือนและปี -->
    <div class="row justify-content-center">
        <div class="col-md-4">
            <form id="monthForm" class="mb-3">
                <label for="monthSelect" class="form-label">เลือกเดือนและปี:</label>
                <select class="form-select" id="monthSelect" name="month">
                    <option value="1">มกราคม</option>
                    <option value="2">กุมภาพันธ์</option>
                    <option value="3">มีนาคม</option>
                    <option value="4">เมษายน</option>
                    <option value="5">พฤษภาคม</option>
                    <option value="6">มิถุนายน</option>
                    <option value="7">กรกฎาคม</option>
                    <option value="8">สิงหาคม</option>
                    <option value="9">กันยายน</option>
                    <option value="10">ตุลาคม</option>
                    <option value="11">พฤศจิกายน</option>
                    <option value="12">ธันวาคม</option>
                </select>
                <select class="form-select" id="yearSelect" name="year">
                    <?php
                    $start_year = date("Y") - 10;
                    $end_year = date("Y") + 10;
                    for ($year = $start_year; $year <= $end_year; $year++) {
                        echo "<option value='$year'>$year</option>";
                    }

                    ?>
                </select>
                <button type="submit" class="btn btn-primary mt-3" style="background: linear-gradient(135deg, #887BB0, #4f4990);">แสดงข้อมูล</button>
                
            </form>
            <?php
            if(isset($_GET['year'])) {
            $selectedYear = $_GET['year'];

            // Query ข้อมูลจากตาราง PaymentDetail โดยเชื่อมตาราง Room เพื่อดึง Room_Number
            $sql = "SELECT Room.Room_Number, RoomDetail.Room_Price, PaymentDetail.Total, PaymentDetail.Date
                    FROM PaymentDetail
                    INNER JOIN RoomDetail ON PaymentDetail.Room_ID = RoomDetail.RoomDetail_ID
                    INNER JOIN Room ON PaymentDetail.Room_ID = Room.Room_ID
                    WHERE YEAR(PaymentDetail.Date) = $selectedYear";

            // ตรวจสอบว่ามีการเลือกเดือนหรือไม่
            if(isset($_GET['month'])) {
                $selectedMonth = $_GET['month'];
                $sql .= " AND MONTH(PaymentDetail.Date) = $selectedMonth";
            }

            $result = $conn->query($sql);

            if ($result === false) {
                die("Error: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                echo "<table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>ห้อง</th>
                                <th scope='col'>ราคาห้อง</th>
                                <th scope='col'>Total</th>
                                <th scope='col'>วันที่จ่าย</th>
                            </tr>
                        </thead>
                        <tbody>";

                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row["Room_Number"]."</td>
                            <td>".$row["Room_Price"]."</td>
                            <td>".$row["Total"]."</td>
                            <td>".$row["Date"]."</td>
                        </tr>";
                }

                echo "</tbody>
                    </table>";

                // คำนวณราคารวมของทุกห้อง
                $sql_total = "SELECT SUM(PaymentDetail.Total) AS TotalAmount FROM PaymentDetail WHERE YEAR(Date) = $selectedYear";
                if(isset($_GET['month'])) {
                    $selectedMonth = $_GET['month'];
                    $sql_total .= " AND MONTH(Date) = $selectedMonth";
                }
                $result_total = $conn->query($sql_total);

                if ($result_total === false) {
                    die("Error: " . $conn->error);
                }

                $row_total = $result_total->fetch_assoc();
                $total_amount = $row_total['TotalAmount'];

                echo "<p>Total ทั้งหมด: $total_amount</p>";
            } else {
                echo "0 results";
            }

            $conn->close();
        } else {
            echo "Please select a year.";
        }?>
        </div>
    </div>
</main>
</body>
</html>
