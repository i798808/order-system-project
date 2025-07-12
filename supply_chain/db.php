<?php
// db.php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "supply_chain";

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("資料庫連線失敗: " . $conn->connect_error);
}
?>
