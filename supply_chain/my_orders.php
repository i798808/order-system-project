<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// 找出目前登入者的 user_id
$username = $_SESSION['username'];
$userRes = $conn->query("SELECT ID FROM users WHERE username='$username'");
$userRow = $userRes->fetch_assoc();
$user_id = $userRow['ID'];

// 查詢這個用戶的所有訂單
$orderRes = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>零件訂購系統</title>
    <style>
        body {
            background: #fff;
            font-family: 'Montserrat';
            margin: 0;
        }
        .header-title {
            text-align: center;
            margin-top: 24px;
        }
        .header-title .main-title {
            font-size: 2.8em;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 0.1em;
        }
        .header-title .sub-title {
            font-size: 2.1em;
            font-weight: 500;
            letter-spacing: 1.5px;
            margin-top: 0.2em;
        }
        .navbar {
            width: 92%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.12em;
            font-weight: bold;
            letter-spacing: 1px;
            padding-top: 18px;
        }
        .navbar-left {
            display: flex;
            gap: 36px;
        }
        .navbar-right {
            display: flex;
            gap: 24px;
        }
        .navbar a {
            color: #111;
            text-decoration: none;
            padding: 3px 10px;
            border-radius: 4px;
            transition: background 0.17s;
        }
        .navbar a:hover {
            background: #e2ebff;
        }
        table {
            border-collapse: collapse;
            background: #fff;
            color: #222;
            width: 92%;
            margin: 30px auto 0 auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 24px rgba(0,0,0,0.10);
        }
        th, td {
            padding: 16px 18px;
            text-align: center;
            border-bottom: 1px solid #cfdff0;
            font-size: 1.13em;
        }
        th {
            background: #306093;
            color: #fff;
            font-weight: 700;
            letter-spacing: 1px;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .detail-link {
            color: #265baa;
            font-weight: bold;
            text-decoration: none;
        }
        .detail-link:hover {
            text-decoration: underline;
        }
        @media (max-width: 900px) {
            .header-title .main-title { font-size: 2em; }
            .header-title .sub-title { font-size: 1.4em; }
            table, .navbar { width: 99%; }
        }
    </style>
</head>
<body>
    <!-- Navbar 手動調整（你可以保留 include 'navbar.php'; 改內容） -->
    <div class="navbar">
        <div class="navbar-left">
            <a href="welcome.php">Home</a>
            <a href="shop.php">Shop products</a>
            <a href="my_orders.php">My Orders</a>
        </div>
        <div class="navbar-right">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <!-- 標題區（分兩行） -->
    <div class="header-title">
        <div class="main-title">Parts ordering</div>
        <div class="sub-title">My Orders</div>
    </div>

    <table>
        <tr>
            <th>Order Number</th>
            <th>Order Date</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Details</th>
        </tr>
        <?php while ($order = $orderRes->fetch_assoc()): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['order_date'] ?></td>
            <td><?= $order['total'] ?></td>
            <td><?= $order['status'] ?></td>
            <td>
                <a href="order_detail.php?order_id=<?= $order['id'] ?>" class="detail-link">View</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
