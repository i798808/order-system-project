<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // 或導回首頁
    exit();
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // 防注入建議用預備語句
    $stmt = $conn->prepare("INSERT INTO products (name, price, stock) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $price, $stock);
    $stmt->execute();
    $stmt->close();
    header("Location: shop.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>零件訂購系統</title>
    <style>
        body { background: #102040; color: #fff; font-family: 'Segoe UI', Arial, sans-serif; }
        .add-form { background: #fff; color: #222; width: 380px; margin: 60px auto; padding: 32px; border-radius: 14px; box-shadow: 0 8px 24px rgba(0,0,0,0.14); }
        h2 { text-align: center; margin-bottom: 24px; color: #1c3669; }
        label { font-weight: bold; }
        input[type="text"], input[type="number"] { width: 100%; padding: 8px; margin-bottom: 18px; border: 1px solid #bdd6ff; border-radius: 6px; font-size: 1em; }
        button { width: 100%; padding: 10px 0; border: none; border-radius: 8px; background: #24489a; color: #fff; font-weight: bold; font-size: 1.1em; cursor: pointer; }
        button:hover { background: #5473b6; }
        .back-link { display: block; margin: 18px auto 0 auto; color: #347deb; text-align: center; }
    </style>
</head>
<body>
    <div class="add-form">
        <h2>新增商品</h2>
        <form method="post">
            <label>名稱：</label>
            <input type="text" name="name" required>
            <label>價格：</label>
            <input type="number" name="price" step="0.01" required>
            <label>剩餘庫存：</label>
            <input type="number" name="stock" min="0" required>
            <button type="submit">新增</button>
        </form>
        <a href="shop.php" class="back-link">返回商品列表</a>
    </div>
</body>
</html>
