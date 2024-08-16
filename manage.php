<?php
session_start();

$host = 'localhost';
$dbname = 'Junsuriya';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Delete record from database
    $sql_delete = "DELETE FROM Member WHERE Mem_ID = $id";
    if ($conn->query($sql_delete) === TRUE) {
        // Update Availability to 'Vacant room' after deleting a member
        $sql_update = "UPDATE Room SET Availability = 'Vacant room' WHERE Room_ID = (SELECT Room_ID FROM Member WHERE Mem_ID = $id)";
        $conn->query($sql_update);
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    // Redirect back to member management page
    header("Location: manage.php");
    exit();
}

// Fetch data from database
$sql = "SELECT Member.*, Room.Room_Number FROM Member LEFT JOIN Room ON Member.Room_ID = Room.Room_ID";
$result = $conn->query($sql);
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
            margin: 0;
            padding: 0;
            background-color: #e0fffb;
        }

        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #e0fffb;
            font-size: 18px;
        }

        td {
            font-size: 16px;
        }

        td:last-child {
            text-align: center;
        }

        a {
            text-decoration: none;
            color: #000000;
        }

        a:hover {
            color: #887BB0;
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
    <div class="container">
        <h1>Member Management</h1>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Room Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display data in table rows
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["Mem_Username"] . "</td>";
                        echo "<td>" . $row["Mem_Name"] . "</td>";
                        echo "<td>" . $row["Mem_Contect"] . "</td>";
                        echo "<td>" . $row["Room_Number"] . "</td>";
                        echo "<td><a href='?id=" . $row["Mem_ID"] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No members found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
