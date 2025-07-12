<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// 商品列表
$productRes = $conn->query("SELECT * FROM products ORDER BY id");

// 訂單列表
$orderRes = $conn->query(
    "SELECT o.*, u.username FROM orders o
     LEFT JOIN users u ON o.user_id = u.ID
     ORDER BY o.order_date DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>零件訂購系統</title>
    <style>
        body { background:rgb(255, 255, 255); color: #222; font-family: 'Montserrat'; }
        .top-links {
            margin: 28px 0 10px 36px;
        }
        .top-links a {
            color: #222;
            margin-right: 34px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.07em;
        }
        h2 { text-align:center; margin-top:25px; }
        .subtitle {
            text-align: center;
            font-size: 1.32em;
            font-weight: 500;
            margin: 28px 0 8px 0;
            letter-spacing: 1.2px;
            color:rgb(0, 0, 0);
        }
        table { 
            border-collapse: collapse;
            background: #fff;
            color: #222;
            width: 90%;
            margin: 0 auto 32px auto;
            border-radius: 12px;
            overflow: hidden;
        }
        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid #d3e1ef;
            text-align: center;
        }
        th {
            background:  #5a7dc8;
            color: #fff;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .action {
            color: #1c3669;
            font-weight: bold;
            text-decoration: none;
        }
        .action:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="top-links">
        <a href="logout.php">Logout</a>
        <a href="welcome.php">Home</a>
        <a href="shop.php">Shop Products</a>
    </div>
    <h2>Management Backend</h2>

    <!-- 商品表格 -->
    <div class="subtitle">Product list</div>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Stock Left</th>
        </tr>
        <?php while ($row = $productRes->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['stock'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- 訂單表格 -->
    <div class="subtitle">Order list</div>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Buyer</th>
            <th>Order Date</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Details</th>
        </tr>
        <?php while ($row = $orderRes->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= $row['order_date'] ?></td>
            <td><?= $row['total'] ?></td>
            <td><?= $row['status'] ?></td>
            <td>
                <a href="order_detail.php?order_id=<?= $row['id'] ?>" class="action">明細</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
