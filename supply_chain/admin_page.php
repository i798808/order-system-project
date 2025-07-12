<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
$username = $_SESSION['username'];
$res = $conn->query("SELECT role FROM users WHERE username='$username'");
$row = $res->fetch_assoc();
$role = $row['role'];

// 只給 admin 看的頁面
if ($role !== 'admin') {
    header("Location: welcome.php");
    exit();
}
?>