<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Password</title>
    <!-- Link to Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
            margin-bottom: 20px; /* Add margin bottom for spacing */
        }

        .user-details {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px; /* Add margin bottom for spacing */
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
            left: 9px;
            font-size: 20px; /* Decrease icon size for consistency */
            color: #857f9f;
        }

        .button {
            height: 45px;
            margin-top: 20px; /* Adjust margin top for spacing */
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
        <form action="edit_password.php" method="post">
            <div class="title">Edit Password</div>
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Phone</span>
                    <i class="fas fa-phone-alt icon"></i> <!-- Icon for phone -->
                    <input type="tel" name="phone" pattern="[0-9]{10}" placeholder="XXX-XXX-XXXX" required>
                </div>
                <div class="input-box">
                    <span class="details">Room Number</span>
                    <i class="fas fa-door-open icon"></i> <!-- Icon for room number -->
                    <input type="text" name="room_number" placeholder="XXX" required>
                </div>
                <div class="input-box">
                    <span class="details">New Password</span>
                    <i class="fas fa-key icon"></i> <!-- Icon for new password -->
                    <input type="password" name="new_password" placeholder="Enter a new password." required>
                </div>
                <div class="input-box">
                    <span class="details">Confirm New Password</span>
                    <i class="fas fa-key icon"></i> <!-- Icon for confirm password -->
                    <input type="password" name="confirm_password" placeholder="Enter a new password again." required>
                </div>
            </div>
            <div class="button">
                <input type="submit" name="submit" value="Confirm">
            </div>
        </form>
    </div>
</body>
</html>
