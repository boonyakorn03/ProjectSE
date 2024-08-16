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

// Check if PayDetail_ID is set and if the pay_button is clicked
if (isset($_POST['payment_id']) && isset($_POST['pay_button'])) {
    // Get PayDetail_ID from the form
    $payment_id = $_POST['payment_id'];

    // Update payment status to 'T' for the specified PayDetail_ID
    $update_sql = "UPDATE PaymentDetail SET Status = 'T', Date_Pay = NOW() WHERE PayDetail_ID = $payment_id";

    if ($conn->query($update_sql) === TRUE) {
        // Show alert message and redirect to homepage
        echo '<script>alert("ชำระเงินเสร็จสิ้น"); window.location.href = "homepage.php";</script>';
    } else {
        echo "Error updating payment status: " . $conn->error;
    }
}

// Prepare SQL statement to fetch payment details based on PayDetail_ID
if (isset($_POST['payment_id'])) {
    $payment_id = $_POST['payment_id'];
    $sql = "SELECT pd.Mem_ID, m.Mem_Name, r.Room_Number, rd.Water_Bill, pd.Elec_Bill, pd.Total, rd.Room_Price, DATE_FORMAT(pd.Date, '%Y-%m-%d') AS Date
        FROM PaymentDetail pd
        INNER JOIN Member m ON pd.Mem_ID = m.Mem_ID
        INNER JOIN Room r ON m.Room_ID = r.Room_ID
        INNER JOIN RoomDetail rd ON r.RoomDetail_ID = rd.RoomDetail_ID
        WHERE pd.PayDetail_ID = $payment_id";

    $result_payment = $conn->query($sql);
}

// Fetch QR code data
$sql_qr = "SELECT QR FROM qrpay";
$result_qr = $conn->query($sql_qr);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เเสกนจ่ายเงิน</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        header {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000; /* ให้ header อยู่หน้าสุด */
}
.container {
    margin-top: 100px; /* ปรับตามความเหมาะสม */
}

        .title {
            color: #5a4c94; 
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: #dddaeb; 
        }

        .container {
            max-width: 500px;
            width: 80%;
            background-color: #ffffff;
            padding: 10px 35px; /* ลดความสูงของกล่องโดยลดค่า padding-top และ padding-bottom */
            border-radius: 50px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        }

        .container .title {
            font-size: 25px;
            font-weight: 500;
            text-align: center; /* Center the title */
        }

        .user-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin: 20px 0 12px 0;
        }

        .input-box {
            position: relative;
            margin-bottom: 15px;
            width: 100%;
        }

        .input-box span.details {
            display: block;
            font-weight: 500;
            margin-bottom: 5px;
            text-align: left;
        }

        .input-box label {
            font-size: 16px;
            font-weight: bold;
            color: #555555; /* เปลี่ยนสีข้อความ label */
        }

        .input-box input[type="text"],
        .input-box input[type="password"],
        .input-box input[type="tel"],
        .input-box select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #cccccc; /* เปลี่ยนสีเส้นขอบ input */
            border-radius: 5px;
            box-sizing: border-box;
        }

        .input-box select {
            appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg fill='rgba(0,0,0,0.5)' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='24' height='24'><path d='M7.41 8.58L12 13.17l4.59-4.59L18 10l-6 6-6-6z'/></svg>");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 30px;
            cursor: pointer;
        }

        .input-box input:focus,
        .input-box select:focus {
            outline: none;
            border-color: #4f4990; /* เปลี่ยนสีเส้นขอบเมื่อ focus */
        }

        .input-box span {
            font-size: 14px;
            color: #cc0000; /* เปลี่ยนสีข้อความเมื่อมี error */
        }

        .input-box input {
            height: 45px;
            width: 100%;
            outline: none;
            font-size: 16px;
            border-radius: 15px;
            padding-left: 40px;
            border: 1px solid #4f4990;
            border-bottom-width: 2px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        .input-box input:focus,
        .input-box input:valid {
            border-color: #4f4990;
        }
        .button {
            height: 45px;
            margin: 35px 0;
            
        }

        .button input {
            height: 100%;
            width: 100%;
            border-radius: 15px;
            border: none;
            color: #ffffff;
            font-size: 18px;
            font-weight: 500;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #978ff4, #4f4990);
            margin: 0 auto;
        }

        .button input:hover {
            background: linear-gradient(-135deg, #978ff4, #4f4990);
        }

        .gender-details {
            text-align: center;
            font-size: 14px;
            color: #4f4990;
        }
        img {
            max-width:80%; /* ขนาดสูงสุดที่เท่ากับขอบเขตของ element ที่ครอบรอบ */
            height: auto; /* ทำให้รูปภาพปรับขนาดตามอัตราส่วน */
            display: block; /* ทำให้รูปภาพเป็นพื้นที่แยกจากเนื้อหารอบ ๆ */
            margin: 20px auto;
        }
        .separator {
    width: 100%;
    height: 1px;
    background-color: #ccc; /* เปลี่ยนสีของเส้นกั้นตามที่ต้องการ */
    margin-bottom: 20px; /* เพิ่มระยะห่างด้านล่าง */
}
.user-details {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.user-data {
    width: 48%; /* ปรับความกว้างของข้อมูล */
}

.qr-code {
    width: 48%; /* ปรับความกว้างของ QR code */
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

    <div class="container form-container" style="margin-top: 100px;">
    <div class="title" style="margin-bottom: 20px;">Save user information</div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <?php
        if ($result_payment->num_rows > 0) {
            $row = $result_payment->fetch_assoc();
            $thaiDate = date('d F Y', strtotime($row["Date"]));

            // Display payment details
            echo '<div class="user-details">';
            echo '<div class="user-data">';
            echo '<p><strong>วันที่ :</strong> ' . $thaiDate . '</p>';
            echo '<p><strong>ชื่อ-นามสกุล :</strong> ' . $row["Mem_Name"] . '</p>';
            echo '<p><strong>ห้อง :</strong> ' . $row["Room_Number"] . '</p>';
            echo '<p><strong>ค่าน้ำ :</strong> ' . $row["Water_Bill"] . '</p>';
            echo '<p><strong>ค่าไฟ :</strong> ' . $row["Elec_Bill"] . '</p>';
            echo '<p><strong>ค่าห้อง :</strong> ' . $row["Room_Price"] . '</p>';
            echo '<p><strong>รวมที่ต้องจ่าย :</strong> ' . $row["Total"] . '</p>';
            echo '</div>';

            // Display QR code
            echo '<div class="qr-code">';
            if ($result_qr->num_rows > 0) {
                while ($row_qr = $result_qr->fetch_assoc()) {
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row_qr['QR']) . '" /><br>';
                }
            } else {
                echo "ไม่พบข้อมูล QR code";
            }
            echo '</div>';
            echo '</div>';

            // Add payment button
            echo '<input type="hidden" name="payment_id" value="' . $payment_id . '">';
            echo '<div class="button">';
            echo '<button type="submit" name="pay_button" class="btn btn-primary" style="background-color: #978ff4; border-color: #978ff4;">ยืนยันชำระเงิน</button>';
            echo '</div>';

        } else {
            echo "<p>ไม่พบข้อมูลการชำระเงิน</p>";
        }
        ?>
    </form>
</div>


</body>


</html>