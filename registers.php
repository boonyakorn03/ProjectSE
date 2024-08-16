<?php
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: loginemploying.php");
    exit(); 
}

$host = 'localhost';
$dbname = 'Junsuriya';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT Room_ID, Room_Number FROM Room WHERE Availability = 'Vacant room'";
$result = $conn->query($sql);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $roomID = $_POST['room'];


    if (!empty($roomID)) {

        $sql = "INSERT INTO Member (Mem_Username, Mem_Password, Mem_Name, Mem_Contect, Room_ID) VALUES ('$username', '$password', '$name', '$phone', '$roomID')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New record created successfully');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Please select a room.";
    }
}

$conn->close();
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
            z-index: 1000; 
             }
        .container {
            margin-top: 100px;
        }

        .title {
                    color: #887BB0;
                    padding: 10px;

                }


        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background-color: #e0fffb; 
        }

        .container {
            max-width: 500px;
            width: 80%;
            background-color: #ffffff;
            padding: 10px 35px; 
            border-radius: 15px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        }

        .container .title {
            font-size: 25px;
            font-weight: 500;
            text-align: center; 
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
            color: #555555; 
        }

        .input-box input[type="text"],
        .input-box input[type="password"],
        .input-box input[type="tel"],
        .input-box select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #cccccc; 
            border-radius: 10px;
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
            border-color: #887BB0; 
        }

        .input-box span {
            font-size: 14px;
            color: #cc0000; 
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
            border-color: #887BB0;
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
            background: linear-gradient(135deg, #887BB0, #4f4990);
        }

        .button input:hover {
            background: linear-gradient(-135deg, #978ff4, #887BB0);
        }

        .gender-details {
            text-align: center;
            font-size: 14px;
            color: #4f4990;
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

        <style>
        /* กำหนดสีพื้นหลังของเว็บไซต์ */
        body {
            background-color: #e0fffb;
            /* เปลี่ยนสีพื้นหลังของเว็บไซต์เป็น #e0fffb */
        }

        /* กำหนดสีพื้นหลังของ Navbar */
        .navbar-custom {
            background-color: #85D2D0;
        }

        /* กำหนดสีตัวอักษรของ Navbar เป็นสีขาว */
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #6E6295;
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


        /* กำหนดสีหัวตารางและตัวอักษร */
        .bg-success {
            background-color: #008000;
            /* สีพื้นหลัง */
            color: #ffffff;
            /* สีตัวอักษร */
        }

        /* กำหนดสีข้อความในตาราง */
        .table th {
            color: #887BB0;
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
        <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Junsuriya</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="problem.php">ปัญหาของลูกหอ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="repair.php">ลูกหอแจ้งซ่อม</a>
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
                            <a class="nav-link" href="summary.php">รายงานสรุปผล</a>
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

    <div class="container form-container">
        <div class="title">บันทึกข้อมูลผู้เช่า</div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="input-box">
                <label for="username">ชื่อผู้ใช้:</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-box">
                <label for="password">รหัสผ่าน:</label>
                <input type="password" id="password" name="password" maxlength="10" required>
            </div>

            <div class="input-box">
                <label for="name">ชื่อ-นามสกุล:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="input-box">
                <label for="phone">เบอร์โทรศัพท์:</label>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required>
            </div>

            <div class="input-box">
                <label for="room">หมายเลขห้อง:</label>
                <select id="room" name="room" required>
                    <option value="">เลือกหมายเลขห้อง</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["Room_ID"] . "'>" . $row["Room_Number"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No available rooms</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="button">
                    <input type="submit"  class="btn btn-primary"  value="Register"></input>
                </div>
        </form>
    </div>
</body>


</html>