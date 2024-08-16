<?php
session_start();

$host = 'localhost';
$dbname = 'junsuriya';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
        if (isset($_POST['Man_Name']) && isset($_POST['Man_Password'])) {
            $input_username = $_POST['Man_Name'];
            $input_password = $_POST['Man_Password'];

            $sqlCheckUser = "SELECT * FROM Manager WHERE Man_Name = :username";
            $stmtCheckUser = $conn->prepare($sqlCheckUser);
            $stmtCheckUser->bindParam(':username', $input_username);
            $stmtCheckUser->execute();

            if ($stmtCheckUser->rowCount() > 0) {
                $user = $stmtCheckUser->fetch(PDO::FETCH_ASSOC);

                if ($input_password == $user['Man_Password']) {
                    $_SESSION['user_id'] = $user['Man_ID'];
                    $_SESSION['user_name'] = $user['Man_Name'];

                    switch ($user['User_Type']) {
                        case 'Administrator':
                            header('Location: registers.php');   #อันนี้เปลี่ยนเป็นที่ไปหน้าแอดมิน
                            exit();
                            break;
                        case 'Repairman':
                            header('Location: repair.php');   #อันนี้เปลี่ยนเป็นที่ไปหน้าพี่เดช
                            exit();
                            break;
                        case 'Owner':
                            header('Location: summary.php');   #อันนี้เปลี่ยนเป็นที่ไปหน้าเจ้าของหอ
                            exit();
                            break;
                        default:
                            $_SESSION['error'] = "ไม่พบประเภทผู้ใช้";
                            header('Location: employlogin.php');
                            exit();
                    }
                } else {
                    $_SESSION['error'] = "รหัสผ่านไม่ถูกต้อง";
                    header('Location: employlogin.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = "ไม่พบชื่อผู้ใช้ในระบบ";
                header('Location: employlogin.php');
                exit();
            }
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Employee</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        .title {
            color: #5a4c94;  
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background: #dddaeb; 
        }

        .container {
            max-width: 500px;
            width: 100%;
            background-color: #ffffff;
            padding: 25px 30px;
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

        .icon {
            position: absolute;
            top: 65%;
            transform: translateY(-50%);
            z-index: 1;
            left: 8px;
            font-size: 23px;
            color: #857f9f;
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
        }

        .button input:hover {
            background: linear-gradient(-135deg, #978ff4, #4f4990);
        }

        .gender-details {
            text-align: center;
            font-size: 14px;
            color: #4f4990;
        }

        #forgotPassword {
            cursor: pointer;
            color: #978ff4;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">EMPLOYEE LOGIN</div>
        <div class="content">
            <form method="POST" action="#">
                <div class="user-details">
                    <div class="input-box">
                        <span for="Man_Name" class="details">Username</span> 
                        <i class="fas fa-user icon"></i> 
                        <input type="text" class="form-control" name="Man_Name" placeholder="Enter username" required>
                    </div>
                    <div class="input-box">
                        <span for="Man_Password" class="details">Password</span> 
                        <i class="fas fa-key icon"></i> 
                        <input type="password" class="form-control" name="Man_Password" placeholder="Enter password" required> 
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="login" class="btn btn-primary" value="Login"></input>
                </div>
                <br><br>
                <div class="gender-details">Want to go to the home page? <br>
                    <label for="flip" id="forgotPassword">Press here to home page.</label>
                </div>

                <script>
                    document.getElementById("forgotPassword").addEventListener("click", function() {
                        window.location.href = "homepage.php";
                    });
                </script>
            </form>
        </div>
    </div>
</body>

</html>

