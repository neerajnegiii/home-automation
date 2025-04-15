<?php
$conn = new mysqli("sql.freedb.tech", "freedb_neeraj", "uNx3qPqs7#Ezy3!", "freedb_MyWebsite");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email    = $_POST["email"];
    $mobile   = $_POST["mobile"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $check = "SELECT * FROM users WHERE username='$username'";
    $check_result = $conn->query($check);
    if ($check_result->num_rows > 0) {
        echo "<script>alert('Username already exists');</script>";
    } else {
        $sql = "INSERT INTO users (username, email, mobile, password) VALUES ('$username', '$email', '$mobile', '$password')";
        if ($conn->query($sql)) {
            echo "<script>alert('Registration successful'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-image: url('https://images.unsplash.com/photo-1658825922490-b02b5947ac6c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NzZ8fGd5bSUyMHRvb2xzJTIwYmxhY2slMjBwaWN8ZW58MHx8MHx8fDA%3D');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 60%;
        }

        .login-box {
            position: relative;
            background: white;
            padding: 30px 30px 40px;
            border-radius: 12px;
            width: 450px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        .login-header {
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #dc143c;
            padding: 15px 40px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            width: 90%;
            height: 15%;
        }

        .login-header p {
            color: white;
            margin: 0;
            font-size: 20px;
            text-align: center;
        }

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .login-button {
            background-color: #dc143c;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .login-button:hover {
            background-color: #c51234;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: -10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <p>AKN Register Page</p>
            </div>
            <form action="" method="post">
                <div class="input-group">
                    <input type="text" name="username" placeholder="Your Name" required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="input-group">
                    <input type="tel" name="mobile" placeholder="Your Mobile Number" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Create Password" required>
                </div>
                <button type="submit" class="login-button">Enroll Now</button>
                <button type="button" class="login-button" onclick="window.location.href='index.php'">Back to Login</button>
            </form>
        </div>
    </div>
</body>
</html>
