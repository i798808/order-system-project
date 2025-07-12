<?php
include 'db.php';
$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $conn->real_escape_string($_POST['email']);

    $sql = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', 'user')";

    if ($conn->query($sql) === TRUE) {
        $msg = "<span class='success'>註冊成功，請<a href='login.php'>登入</a></span>";
    } else {
        $msg = "<span class='error'>註冊失敗: " . htmlspecialchars($conn->error) . "</span>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>零件訂購系統</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .center-box {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .login-box {
            background: rgba(255, 255, 255, 0.06);
            box-shadow: 0 8px 32px 0 rgba(31,38,135,0.37);
            border-radius: 20px;
            padding: 40px 50px 30px 50px;
            min-width: 340px;
            text-align: center;
        }
        .login-box h2 {
            color: #fff;
            margin-bottom: 25px;
            font-size: 2em;
        }
        .login-box form {
            width: 100%;
        }
        .login-box input[type="text"], 
        .login-box input[type="password"], 
        .login-box input[type="email"] {
            width: 92%;
            padding: 15px 10px;
            margin: 12px 0;
            border-radius: 8px;
            border: none;
            font-size: 1.2em;
            text-align: center;
            background: #fff;
        }
        .login-box button {
            padding: 12px 30px;
            font-size: 1.2em;
            border-radius: 10px;
            border: none;
            background: #306093;
            color: #fff;
            cursor: pointer;
            margin-top: 20px;
        }
        .login-box a {
            color: #72a2ff;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            font-size: 1.1em;
        }
        .msg, .error, .success {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 1.13em;
        }
        .error { color: #ff7979; }
        .success { color: #7de27d; }
    </style>
</head>
<body>
<div class="center-box">
    <div class="login-box">
        <h2>註冊帳號</h2>
        <form method="post">
            <input type="text" name="username" placeholder="帳號" required><br>
            <input type="email" name="email" placeholder="信箱"><br>
            <input type="password" name="password" placeholder="密碼" required><br>
            <button type="submit">註冊</button>
        </form>
        <div class="msg"><?= $msg ?></div>
        <a href="login.php">已有帳號？登入</a>
    </div>
</div>
</body>
</html>
