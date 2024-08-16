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
    <title>Save user information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e0fffb;
            margin: 0;
            padding: 0;
        }

        h2 {
            color: #333;
        }

        form {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            max-width: 400px;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        select,
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #887BB0;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        #tenantNameContainer,
        #numberOfUnitsContainer,
        .newContainer {
            margin-top: 20px;
        }

        .newContainer label {
            color: #333;
            font-weight: bold;
        }
    
        .bar{
            background:#85D2D0;
        }
        .nav-link{
            color: #4f4990;
        }
        .nav-link:hover{
            color: #5d5f5f;
        }
        .button{
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
<?php


    // Prepare SQL statement to retrieve Room_Number, Room_ID, and RoomDetail_ID where Availability is 'Unavailable'
    $sql = "SELECT r.Room_ID, r.Room_Number, rd.RoomDetail_ID FROM Room r INNER JOIN RoomDetail rd ON r.RoomDetail_ID = rd.RoomDetail_ID WHERE r.Availability = 'Unavailable'";
    $result = $conn->query($sql);

    // Check if there are rooms available for payment
    if ($result->num_rows > 0) {
        // Display the form for selecting a room
        echo '<form action="#" method="POST">';
        echo '<label for="room">Select the room in which you want to save data</label><br>';
        echo '<select id="room" name="room" required onchange="getTenantName(this.value)">';
        echo '<option value="">Select Room</option>';
        // Loop through each row to display Room_Number, Room_ID, and Room_Price as options
        while ($row = $result->fetch_assoc()) {
            // Retrieve RoomDetail_ID
            $roomDetailID = $row["RoomDetail_ID"];

            // Query to get Room_Price from RoomDetail using RoomDetail_ID
            $priceQuery = "SELECT Room_Price FROM RoomDetail WHERE RoomDetail_ID = '$roomDetailID'";
            $priceResult = $conn->query($priceQuery);

            // Check if query successful and fetch Room_Price
            if ($priceResult && $priceResult->num_rows > 0) {
                $priceRow = $priceResult->fetch_assoc();
                $roomPrice = $priceRow["Room_Price"];

                // Display option with Room_Number, Room_Price, and Room_ID
                echo "<option value='" . $row["Room_ID"] . "' data-price='" . $roomPrice . "'>" . $row["Room_Number"] . " (Price: $" . $roomPrice . ")</option>";
            } else {
                // If unable to fetch Room_Price, display option with Room_Number and Room_ID only
                echo "<option value='" . $row["Room_ID"] . "'>" . $row["Room_Number"] . "</option>";
            }
        }
    echo '</select><br><br>';
    // Add a container to display tenant name
    echo '<div id="tenantNameContainer"></div>';
    // Add a container for entering number of units
    echo '<div id="numberOfUnitsContainer"></div>';

    echo '<div class="newContainer">';
    echo '<label for="waterBill">ค่าน้ำ </label>';
    echo '<input type="text" id="waterBill" name="waterBill" value="100" readonly>';
    echo '</div>';
    
    echo '<div class="newContainer">';
    echo '<label for="electricityUnit">หน่วยค่าไฟปัจจุบัน </label>';
    echo '<input type="text" id="electricityUnit" name="electricityUnit">';
    echo '</div>';

    echo '<div class="newContainer">';
    echo '<label for="units">จำนวนหน่วยไฟที่ใช้</label>';
    echo '<input type="text" id="units" name="units">';
    echo '</div>';

    echo '<div class="newContainer">';
    echo '<label for="elecBill">ค่าไฟ</label>';
    echo '<input type="text" id="elecBill" name="elecBill">';
    echo '</div>';

    echo '<div class="newContainer">';
    echo '<label for="totalBill">จำนวนที่ต้องจ่ายทั้งหมด </label>';
    echo '<input type="text" id="totalBill" name="totalBill">';
    echo '</div>';

    // Add submit button
    echo '<input type="submit" class="button"  id="insertButton" value="Insert">';
    echo '</form>';
} else {
    // If no rooms available for payment
    echo "No rooms available for payment.";
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $roomID = $_POST["room"]; // แก้จาก $_POST["Room_ID"] เป็น $_POST["room"]
    $waterBill = $_POST['waterBill'];
    $electricityUnit = $_POST['electricityUnit'];
    $units = $_POST['units'];
    $elecBill = $_POST['elecBill'];
    $totalBill = $_POST['totalBill'];

    // Prepare SQL statement to insert data into PaymentDetail table
    $sql = "INSERT INTO PaymentDetail (Room_ID, Water_Bill, Electricity_Unit, Units, Elec_Bill, Total) 
        VALUES ('$roomID', '$waterBill', '$electricityUnit', '$units', '$elecBill', '$totalBill')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
</body>

</html>