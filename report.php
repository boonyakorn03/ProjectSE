<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // หากไม่ได้เข้าสู่ระบบ ให้ redirect ไปยังหน้า login
    header("Location: login.php");
    exit(); // จบการทำงานของ script
}


$host = 'localhost';
$dbname = 'Junsuriya';
$username = 'root';
$password = '';
// Include database connection
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get current month
$currentMonth = date('m');

// Get Mem_ID from session
$memID = $_SESSION['user_id'];

// Prepare SQL statement to fetch payment details for the current month
// Prepare SQL statement to fetch payment details for the current month
$sqlroom = "SELECT m.*, r.Room_Number FROM member m
JOIN room r ON m.Room_ID = r.Room_ID
WHERE m.Mem_ID = {$_SESSION['user_id']}";
$resultroom = $conn->query($sqlroom);
$row_room = mysqli_fetch_array($resultroom);

$sqlRoomID = "SELECT Room_ID FROM member WHERE Mem_ID = ?";
$stmtRoomID = $conn->prepare($sqlRoomID);
$stmtRoomID->bind_param('i', $_SESSION['user_id']);
$stmtRoomID->execute();
$resultRoomID = $stmtRoomID->get_result();
$rowRoomID = $resultRoomID->fetch_assoc();
$roomID = $rowRoomID['Room_ID'];


//



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['btn2'])) {
        // Receive data from the form
       
        $problem = $_POST['problem'];

        // Check if 'Mem_ID' is set in session

        // Prepare SQL statement to insert data into 'problem' table
        $sql = "INSERT INTO problem (Mem_ID, Room_ID, Detail_Problem) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters and execute SQL statement
        $stmt->bind_param('iis', $_SESSION['user_id'], $roomID , $problem);
        $stmt->execute();

        // Check if the data insertion was successful and display appropriate message
        if ($stmt->affected_rows > 0) {
            echo '<script>alert("บันทึกข้อมูลปัญหาสำเร็จ");</script>';
        } else {
            echo '<script>alert("เกิดข้อผิดพลาดในการบันทึกข้อมูล");</script>';
        }

        // Close SQL statement and database connection
        $stmt->close();
        $conn->close();
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เเจ้งปัญหา</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        /* กำหนดสีพื้นหลังของ Navbar */
        .container {
            margin-top: 50px; /* ปรับตามความเหมาะสม */
        }
        body {
            
            background: #dddaeb; 
        }
        header {
            background-color: #ffffff;
        }
        .navbar .nav-link {
        color: #ffffff;
        /* สีขาว */
        }

        .navbar-brand {
        color: #ffffff;
        }

        .custom {
        background-color: #887BB0;
        color: #ffffff;
        /* สีขาว */
        }
    
        .alert-custom {
            background-color: #887BB0;
            color: #ffffff;
            /* สีขาว */
        }
        
    </style>
</head>

<body>
<header>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand text-purple" href="#">Junsuriya</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="homepage.php">หน้าหลัก</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inn.php">ชำระเงิน</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="report.php">แจ้งปัญหา</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="report_repair.php">แจ้งซ่อม</a>
                        </li>
                    </ul>
                </div>              
                <div class="dropdown" style="margin-right: 20px;">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #5a4c94;">
                        <?php
                        if (isset($_SESSION['user_name'])) {
                            echo '<i class="fas fa-user icon" style="margin-right: 10px;"></i>' . $_SESSION['user_name'];
                        } else {
                            echo 'Login';
                        }
                        ?>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="background-color: #5a4c94;">
                        <?php
                        if (isset($_SESSION['user_name'])) {
                            echo '<li><a class="dropdown-item text-danger" href="logout.php" style="color: #ffffff;">Logout !</a></li>';
                        } else {
                            echo '<li><a class="dropdown-item" href="login.php" style="color: #ffffff;">Login</a></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <br><br>

        <div class="container ">
            <div class="row justify-content-center ">
                <div class="col-12 col-md-6">
                    <div class="alert alert-info text-center alert-custom" role="alert">
                        แจ้งปัญหา
                    </div>
                </div>
            </div>
        </div>
        <br>

<!-- เริ่มตารางการแจ้งปัญหา -->
<style>
    /* Override default table border styles */
    .table {
        border-collapse: collapse;
        border: none;
    }
    /* Override default table cell border styles */
    .table td,
    .table th {
        border: none;
    }
</style>

<div class="container">
    <form method="POST" action="" enctype="multipart/form-data">
        <table class="table">
            <tbody>
                <tr>
                    <th class="col-form-label col-1" scope="row">ห้อง :</th>
                    <td class="col-8 col-sm-9">
                        <p name="room"><?= $row_room['Room_Number'] ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="col-form-label col-1" scope="row">รายละเอียด :</th>
                    <td class="col-8 col-sm-9">
                        <textarea class="form-control" name="problem" required></textarea>
                    </td>
                </tr>
            
                <tr>
                    <td colspan="2" class="text-left">
                        <button type="submit" name="btn2" class="btn btn-primary custom">แจ้งปัญหา</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
        
    </main>

</body>

</html>