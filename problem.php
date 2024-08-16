<?php 
session_start();

/*if (!isset($_SESSION['user_name'])) {
    header("Location: loginemploying.php");
    exit(); 
}*/

$host = 'localhost';
$dbname = 'Junsuriya';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);

    // Query ข้อมูลการแจ้งปัญหาจากฐานข้อมูล
    $query = "SELECT problem.*, member.Mem_Name, room.Room_Number 
              FROM problem 
              INNER JOIN member ON problem.Mem_ID = member.Mem_ID
              INNER JOIN room ON problem.Room_ID = room.Room_ID";

    $result = mysqli_query($conn, $query);
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

</head>
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

    <div class="container mt-5">
        <h2 class="text-center mb-4">การแจ้งปัญหา</h2>
        <p class="text-end">มีข้อมูลการแจ้งปัญหาทั้งหมด <?php echo mysqli_num_rows($result) ?> รายการ</p>     
        <div class="table-responsive">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <table class="table table-bordered">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th>ชื่อ</th>
                            <th>ห้อง</th>
                            <th>ปัญหา</th>
                            <th>การจัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['Mem_Name']; ?></td>
                                <td><?php echo $row['Room_Number']; ?></td>
                                <td><?php echo $row['Detail_Problem']; ?></td>
                                <td>
                                    <!-- เพิ่มปุ่มรายละเอียดและแก้ไข -->
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#problemModal<?php echo $row['Problem_ID']; ?>">รายละเอียด</a>
                                        
                                    </div>
                                </td>
                            </tr>
                            <!-- สำหรับแสดงรายละเอียดของปัญหา -->
                            <div class="modal fade" id="problemModal<?php echo $row['Problem_ID']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">รายละเอียดปัญหา</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><strong>ชื่อ:</strong> <?php echo $row['Mem_Name']; ?></p>
                                            <p><strong>ห้อง:</strong> <?php echo $row['Room_Number']; ?></p>
                                            <p><strong>ปัญหา:</strong> <?php echo $row['Detail_Problem']; ?></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-center">ไม่มีข้อมูลในฐานข้อมูล</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- Bootstrap JS และ Popper JS (ถ้าต้องการใช้งาน Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>