<?php
session_start();

$host = 'localhost';
$dbname = 'Junsuriya';
$username = 'root';
$password = '';


$conn = new mysqli($host, $username, $password, $dbname);

// Query ข้อมูลการแจ้งปัญหาจากฐานข้อมูล
$query = "SELECT reparidetail.*, member.Mem_Name, room.Room_Number 
          FROM reparidetail
          INNER JOIN member ON reparidetail.Mem_ID = member.Mem_ID
          INNER JOIN room ON reparidetail.Room_Number = room.Room_Number";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>การแจ้งซ่อม</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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

    <div class="flex-container">
        <div class="container mt-5">
            <div class="container ">
                <div class="row justify-content-center ">
                    <div class="col-12 col-md-6">
                        <div class="alert alert-info text-center alert-custom" role="alert">
                            การแจ้งซ่อม
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <div class="col-lg-10 container ">
            <div class="table-responsive">
                <?php if (mysqli_num_rows($result) > 0) : ?>
                    <table class="table table-bordered">
                        <thead class="bg-success">
                            <tr bgcolor="#85D2D0">
                                <th width="10%">ห้อง</th>
                                <th width="30%">รายละเอียด</th>
                                <th width="20%">รูป</th>
                                <th width="15%">จัดการ</th>
                                <th width="15%">สถานะ</th>
                            </tr>
                        </thead>

                        <tbody style="background-color: #FFFFFF; ">
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <tr class="text-center ">
                                    <td><?php echo htmlspecialchars($row['Room_Number']) ?></td>
                                    <td><?php echo htmlspecialchars($row['Detail_Problem']) ?></td>
                                    <td>
                                        <?php

                                        if (isset($row["Picture"])) {
                                            // กำหนด path ของไฟล์ภาพ
                                            $imagePath = $row["Picture"];

                                            // ตรวจสอบว่าไฟล์ภาพมีอยู่หรือไม่
                                            if (file_exists($imagePath)) {
                                                // แสดงรูปภาพ
                                                echo "<a href='$imagePath' target='_blank'><img src='$imagePath' alt='Picture'height='250' ></a>";
                                            } else {
                                                // แสดงข้อความถ้าไม่พบไฟล์ภาพ
                                                echo "ไม่พบไฟล์ภาพ";
                                            }
                                        }
                                        ?>


                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#my-modal<?php echo $row['RepariDetail_ID'] ?>" style="width: 105px;"> รายละเอียด </button>

                                        </div>

                                    </td>
                                    <td id="status_<?php echo $row['RepariDetail_ID']; ?>">
                                        <?php if ($row['Status'] == 'T') : ?>
                                            <span class="badge bg-success">สำเร็จ</span>
                                        <?php else : ?>
                                            <button id="button_<?php echo $row['RepariDetail_ID']; ?>" class="btn btn-success" onclick="markAsComplete(<?php echo $row['RepariDetail_ID'] ?>)">สำเร็จ</button>
                                        <?php endif; ?>
                                    </td>

                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="my-modal<?php echo $row['RepariDetail_ID'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">รายละเอียดการแจ้งซ่อม</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                            </div>
                                            <div class="modal-body">
                                                <p>ห้อง: <?php echo htmlspecialchars($row['Room_Number']) ?></p>
                                                <p>รายละเอียด: <?php echo htmlspecialchars($row['Detail_Problem']) ?></p>
                                                <?php
                                                if (isset($row["Picture"])) {
                                                    // กำหนด path ของไฟล์ภาพ
                                                    $imagePath = $row["Picture"];

                                                    // ตรวจสอบว่าไฟล์ภาพมีอยู่หรือไม่
                                                    if (file_exists($imagePath)) {
                                                        // แสดงรูปภาพ
                                                        echo "<div class='text-center'><a href='$imagePath' target='_blank'><img src='$imagePath' alt='Picture' style='max-height: 250px; max-width: 100%;' ></a></div>";
                                                    } else {
                                                        // แสดงข้อความถ้าไม่พบไฟล์ภาพ
                                                        echo "ไม่พบไฟล์ภาพ";
                                                    }
                                                }
                                                ?>
                                                <hr>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p class="mt-5">ไม่มีข้อมูลในฐานข้อมูล</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    <!-- Bootstrap5 แบบ bundle คือการนำ Popper มารวมไว้ในไฟล์เดียว -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <script>
    function markAsComplete(id) {
        // ส่วนนี้คือการส่งคำขอ HTTP หรืออัพเดทฐานข้อมูลเมื่อปุ่ม "สำเร็จ" ถูกคลิก
        // เช่น การใช้ AJAX เพื่อส่งคำขอ POST ไปยังเซิร์ฟเวอร์

        // ตัวอย่างการใช้งาน AJAX โดยใช้ jQuery
        $.ajax({
            url: 'mark_as_complete.php', // ตัวอย่าง URL ที่ใช้ส่งคำขอ POST
            method: 'POST',
            data: {
                id: id
            }, // ข้อมูลที่จะส่งไปยังเซิร์ฟเวอร์ เช่น ID ของการแจ้งซ่อม

            success: function(response) {
                // เมื่อคำขอสำเร็จ
                if (response.trim() === 'success') {
                    alert('แจ้งซ่อมเสร็จสิ้น');
                    // ซ่อนปุ่มที่ถูกคลิก
                    $('#button_' + id).hide();
                    // หรืออัพเดท HTML ของ <td> เป็นสถานะสำเร็จ
                    $('#status_' + id).html('<span class="badge bg-success">สำเร็จ</span>');
                } else {
                    // ถ้าไม่สำเร็จ
                    alert('เกิดข้อผิดพลาดในการอัพเดทสถานะ');
                }
            },
        });
    }
</script>
    <?php mysqli_close($conn) ?>
</body>

</html>