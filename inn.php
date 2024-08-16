<?php
session_start();

$host = 'localhost';
$dbname = 'junsuriya';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$currentMonth = date('m');


$memID = $_SESSION['user_id'];


$sql = "SELECT pd.Mem_ID,pd.PayDetail_ID, m.Mem_Name, r.Room_Number, rd.Water_Bill, pd.Elec_Bill, pd.Total, rd.Room_Price, DATE_FORMAT(pd.Date, '%Y-%m-%d') AS Date, pd.Status 
        FROM PaymentDetail pd
        INNER JOIN Member m ON pd.Mem_ID = m.Mem_ID
        INNER JOIN Room r ON m.Room_ID = r.Room_ID
        INNER JOIN RoomDetail rd ON r.RoomDetail_ID = rd.RoomDetail_ID
        WHERE pd.Mem_ID = $memID
        ORDER BY pd.Date DESC";


$result = $conn->query($sql);


?>


<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ชำระเงิน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        /* เพิ่มระยะห่างด้านบน */
        .container {
            margin-top: 50px; /* ปรับตามความเหมาะสม */
        }
        body {
            
            background: #dddaeb; 
        }
      
        /* กำหนดสีพื้นหลังของ Navbar */
        .navbar {
        background-color: #887BB0;
        }

        /* กำหนดสีของตัวหนังสือใน Navbar */
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
        
   
    </style>
 </head>
<body>
<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Junsuriya</a>
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


<div class="container">
    <div class="row">
        <div class="col">
        <?php
        if ($result->num_rows > 0) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($rows as $row) {
                $thaiDate = date('d F Y', strtotime($row["Date"]));
                $paymentStatus = ($row["Status"] == 'T') ? '<span style="color: green;">ชำระแล้ว</span>' : '<span style="color: red;">ค้างชำระ</span>';

                echo '<div class="accordion" id="accordionExample' . $row["Mem_ID"] . '">';
                echo '<div class="accordion-item">';
                echo '<h2 class="accordion-header">';
                echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $row["Mem_ID"] . '" aria-expanded="true" aria-controls="collapse' . $row["Mem_ID"] . '">';
                echo $thaiDate;
                echo '</button>';
                echo '</h2>';
                echo '<div id="collapse' . $row["Mem_ID"] . '" class="accordion-collapse collapse" aria-labelledby="heading' . $row["Mem_ID"] . '" data-bs-parent="#accordionExample' . $row["Mem_ID"] . '">';
                echo '<div class="accordion-body">';
                echo '<div class="payment-list">';
                echo '<p><strong>วันที่ :</strong> ' . $thaiDate . '</p>';
                echo '<p><strong>ชื่อ-นามสกุล :</strong> ' . $row["Mem_Name"] . '</p>';
                echo '<p><strong>ห้อง :</strong> ' . $row["Room_Number"] . '</p>';
                echo '<p><strong>ค่าน้ำ :</strong> ' . $row["Water_Bill"] . '</p>';
                echo '<p><strong>ค่าไฟ :</strong> ' . $row["Elec_Bill"] . '</p>';
                echo '<p><strong>ค่าห้อง :</strong> ' . $row["Room_Price"] . '</p>';
                echo '<p><strong>รวมที่ต้องจ่าย :</strong> ' . $row["Total"] . '</p>';
                echo '<p><strong>สถานะ :</strong> ' . $paymentStatus . '</p>';
                
                // Check if payment is pending and display pay button
                if ($row["Status"] != 'T') {
                    // Get the class of the user name button
                    $userButtonClass = "btn btn-secondary"; // Example class
                            
                    // Extract the class of the user name button
                    preg_match('/class="(.*?)"/', $_SESSION['user_name'], $matches);
                    if(isset($matches[1])){
                        $userButtonClass = $matches[1];
                    }
                    echo '<form action="QR.php" method="post">';
                    echo '<button type="submit" class="' . $userButtonClass . '">ชำระเงิน</button>';
                    echo '<input type="hidden" name="payment_id" value="' . $row["PayDetail_ID"] . '">';
                    echo '</form>';
                }
                
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "<p>ไม่พบข้อมูลการชำระเงินในเดือนนี้</p>";
        }
        ?>
        </div>
    </div>
</div>
</body>

</html>

