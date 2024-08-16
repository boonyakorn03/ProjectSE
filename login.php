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
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $sqlCheckUser = "SELECT * FROM Member WHERE Mem_Username = :username";
            $stmtCheckUser = $conn->prepare($sqlCheckUser);
            $stmtCheckUser->bindParam(':username', $username);
            $stmtCheckUser->execute();

            if ($stmtCheckUser->rowCount() > 0) {
                $user = $stmtCheckUser->fetch(PDO::FETCH_ASSOC);

                // Check if the entered password matches the password in the database
                if ($password == $user['Mem_Password']) {
                    $_SESSION['user_id'] = $user['Mem_ID'];
                    $_SESSION['user_name'] = $user['Mem_Username']; // Use Mem_Username as the username

                    // Redirect to homepage
                    header('Location: homepage.php');
                    exit();
                } else {
                    $_SESSION['error'] = "รหัสผ่านไม่ถูกต้อง";
                    header('Location: login.php');
                    exit();
                }
            } else {
                $_SESSION['error'] = "ไม่พบชื่อผู้ใช้ในระบบ";
                header('Location: login.php');
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
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        .title {
            color: #5a4c94; /* เปลี่ยนสีตัวอักษรเป็นสีขาว */
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 10px;
            background: linear-gradient(135deg, #6f639e, #675a9b);
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
        <div class="title">LOGIN</div>
        <div class="content">
            <form method="POST" action="#">
                <div class="user-details">
                    <div class="input-box">
                        <span for="username" class="details">Username</span>
                        <i class="fas fa-user icon"></i> <!-- Icon for username -->
                        <input type="text" class="form-control" name="username" placeholder="Enter username" required>
                    </div>
                    <div class="input-box">
                        <span for="password" class="details">Password</span>
                        <i class="fas fa-key icon"></i> <!-- Icon for password -->
                        <input type="password" class="form-control" name="password" placeholder="Enter password" required>
                    </div>
                </div>
                <div class="button">
                    <input type="submit" name="login" class="btn btn-primary" value="Login"></input>
                </div>
                <br><br>
                <div class="gender-details">Forgot your password? <br><label for="flip" id="forgotPassword">Press here to edit your password.</label></div>
                <div> <a href="employlogin.php">employlogin</a></div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            // ให้ link กับ id forgotPassword
            $("#forgotPassword").click(function(e) {
                e.preventDefault(); // ป้องกันการโหลดหน้าใหม่
                window.location.href = "editpass.php";
            });
        });
    </script>
</body>

</html>
