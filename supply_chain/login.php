<?php
include 'db.php';
session_start();
$msg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role']; // 新增：把角色存進 session
            header("Location: welcome.php");
            exit();
        } else {
            $msg = "<span class='error'>密碼錯誤</span>";
        }
    } else {
        $msg = "<span class='error'>查無此帳號</span>";
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
            background: rgba(255,255,255,0.06);
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
        .login-box input[type="password"] {
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
            background: #1c3669;
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
        .msg, .error {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 1.13em;
        }
        .error { color: #ff7979; }
    </style>
</head>
<body>
<div class="center-box">
    <div class="login-box">
        <h2>登入</h2>
        <form method="post">
            <input type="text" name="username" placeholder="帳號" required><br>
            <input type="password" name="password" placeholder="密碼" required><br>
            <button type="submit">登入</button>
        </form>
        <div class="msg"><?= $msg ?></div>
        <a href="register.php">還沒帳號？註冊</a>
    </div>
</div>
</body>
</html>
