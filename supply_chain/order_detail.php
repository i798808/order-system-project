<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username']) || !isset($_GET['order_id'])) {
    header("Location: my_orders.php");
    exit();
}
$order_id = intval($_GET['order_id']);

// 查詢訂單明細
$res = $conn->query(
    "SELECT oi.*, p.name 
     FROM order_items oi
     JOIN products p ON oi.product_id = p.id
     WHERE oi.order_id = $order_id"
);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>訂單明細</title>
    <style>
        body {
            background:rgb(255, 255, 255);
            color: #fff;
            font-family: 'Montserrat';
            margin: 0;
        }
        h2 {
            text-align: center;
            margin-top: 38px;
            letter-spacing: 1.5px;
            font-size: 2.2em;
        }
        table {
            border-collapse: collapse;
            background: #fff;
            color: #222;
            width: 60%;
            margin: 38px auto 0 auto;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 24px rgba(0,0,0,0.14);
        }
        th, td {
            padding: 14px 22px;
            border-bottom: 1px solid #d3e1ef;
            font-size: 1.1em;
            text-align: center;   /* 讓內容置中 */
        }
        th {
            background:  #306093;
            color: #fff;
            font-weight: 700;
            letter-spacing: 1px;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .back-link {
            color: #72a2ff;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 30px;
            font-size: 1.1em;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h2>訂單明細 #<?= $order_id ?></h2>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
        <?php while ($row = $res->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['price'] ?></td>
            <td><?= $row['quantity'] ?></td>
            <td><?= $row['price'] * $row['quantity'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="my_orders.php" class="back-link">Back to Order List</a>
</body>
</html>
