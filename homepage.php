<?php
// ติดต่อฐานข้อมูล
session_start();
$host = 'localhost';
$dbname = 'junsuriya';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
    /* เพิ่ม CSS เพื่อกำหนดขนาดรูปภาพในสไลด์ภาพ */
        body {
          background: #dddaeb; 
        }

        header {
            background-color: #ffffff;
        }
        .carousel-item img {
            width: 100px;
            height: 350px; /* ปรับค่าความสูงตามที่ต้องการ */
            object-fit: cover; /* เพื่อให้รูปภาพขนาดเท่ากันและไม่เกินพื้นที่ */
        }
        .details h1 {
          color: #333;
            font-size: 24px;
            border: 5px ;
            padding: 20px;
            margin: 20px auto;
            max-width: 250px;
            text-align: center;
        }
        .card-container {
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .card {
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            margin: 20px;
            display: inline-block;
            justify-content: center;
          }

          .card img {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
          }
          .card h2 {
            margin: 2px;
            font-size: 20px;
            color: #333;
            text-align: center;
          }
          .card p {
            margin: 0;
            font-size: 20px;
            color: #333;
            text-align: center;
          }
          /* เพิ่ม CSS เพื่อกำหนดสีของปุ่ม Dropdown เป็นสีม่วง */
          .btn-purple {
              background-color: #6f639e; /* สีม่วง */
              border-color: #6f639e; /* สีเส้นขอบ */
          }

          .text-light {
              color: #ffffff; /* สีของตัวอักษร */
          }
          .text-purple {
              color: #6f639e; /* สีของตัวอักษร */
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
                            <a class="nav-link active" aria-current="page" href="homepage.php">Home</a>
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
                            echo '<li><a class="dropdown-item text-light" href="logout.php" style="color: #ffffff;">Logout !</a></li>';
                        } else {
                            echo '<li><a class="dropdown-item" href="login.php" style="color: #ffffff;">Login</a></li>';
                        }
                        ?>
                    </ul>
                </div>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <?php
        if (isset($_SESSION['user_name'])) {
            echo '<li><a class="dropdown-item text-purple" href="logout.php">Logout !</a></li>';
            echo '<li><a class="dropdown-item text-purple" href="profile.php">Profile</a></li>';
        } else {
            echo '<li><a class="dropdown-item text-purple" href="login.php">Login</a></li>';
        }
        ?>
</ul>

                </div>
            </div>
        </nav>
    </header>

<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
  <!-- สไลด์ภาพ -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="2.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="3.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="4.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
  <!-- ปุ่มเลื่อน -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

        <div class="details">
            <h1 class="mb-0">รายละเอียดห้องพัก</h1>
        </div>

      <div class="card-container">
        <div class="card">
          <img src="room2.jpg" alt="Image">
          <h2>ห้องพัดลม</h2>
          <p>ราคา 2800</p>
        </div>
        <div class="card">
          <img src="room1.jpg" alt="Image">
          <h2>ห้องแอร์</h2>
          <p>ราคา3000</p>
        </div>
        </div>

</body>
</html>