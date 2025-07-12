<?php
session_start();
include 'db.php';

$success_message = "";

// 處理下單（僅限一般使用者）
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy']) && $_SESSION['role'] !== 'admin') {
    if (!isset($_SESSION['username'])) {
        $success_message = "請先登入！";
    } else {
        $user = $_SESSION['username'];
        $userIdRes = $conn->query("SELECT ID FROM users WHERE username='$user'");
        $userRow = $userIdRes->fetch_assoc();
        $user_id = $userRow['ID'];

        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];

        $productRes = $conn->query("SELECT price, stock FROM products WHERE id=$product_id");
        $productRow = $productRes->fetch_assoc();
        $price = $productRow['price'];
        $stock = $productRow['stock'];

        if ($quantity > $stock) {
            $success_message = "庫存不足，下單失敗！";
        } else {
            $total = $price * $quantity;
            $conn->query("INSERT INTO orders (user_id, total) VALUES ($user_id, $total)");
            $order_id = $conn->insert_id;

            $conn->query("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES ($order_id, $product_id, $quantity, $price)");
            $conn->query("UPDATE products SET stock = stock - $quantity WHERE id = $product_id");

            $success_message = "訂單已建立！";
        }
    }
}

$result = $conn->query("SELECT * FROM products");
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
        .navbar {
            width: 100%;
            background: #fff;
            padding: 12px 0 6px 0;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            font-weight: bold;
        }
        .navbar a {
            color: #222;
            margin: 0 24px;
            text-decoration: none;
            font-size: 1em;
            letter-spacing: 0.5px;
        }
        .navbar .nav-right {
            margin-left: auto;
            margin-right: 40px;
        }
        .container {
            max-width: 1500px;
            margin: 0 auto;
        }
        .main-title {
            text-align: center;
            font-size: 2.8em;
            font-weight: bold;
            margin: 32px 0 0 0;
            letter-spacing: 2px;
        }
        .sub-title {
            text-align: center;
            font-size: 2.1em;
            margin: 10px 0 25px 0;
            letter-spacing: 1px;
            color: rgb(0, 0, 0);
            font-weight: 500;
        }
        .table-container {
            width: 92%;
            max-width: 1450px;
            margin: 0 auto;
            background: #f7fbff;
            border-radius: 12px;
            box-shadow: 0 4px 24px #e0e8f7;
            padding: 22px 22px 30px 22px;
        }
        .table-actions {
            width: 92%;
            max-width: 1450px;
            margin: 0 auto 8px auto;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            color: #222;
        }
        th, td {
            padding: 15px 18px;
            text-align: center;
            border-bottom: 1px solid #b7cef3;
            font-size: 1.12em;
        }
        th {
            background: #3567a8;
            color: #fff;
            font-weight: 700;
            letter-spacing: 1px;
        }
        tr:last-child td { border-bottom: none; }
        input[type="number"] {
            width: 48px;
            padding: 4px 6px;
            border: 1px solid #9eb8db;
            border-radius: 6px;
            font-size: 1.1em;
        }
        button[type="submit"], .btn-add {
            padding: 8px 20px;
            border-radius: 18px;
            border: none;
            background: #5a7dc8;
            color: #fff;
            font-weight: bold;
            font-size: 1em;
            margin-left: 8px;
            cursor: pointer;
            transition: background 0.18s;
        }
        button[type="submit"]:hover, .btn-add:hover {
            background: #274778;
        }
        .btn-delete {
            background: #c43c15;
            margin-left: 0;
        }
        .btn-delete:hover {
            background: #a42a09;
        }
        .success-message, .fail-message {
            border-radius: 8px;
            text-align: center;
            padding: 12px 0;
            width: 90%;
            margin: 0 auto 16px auto;
            font-size: 1.1em;
        }
        .success-message {
            background: #e0fbe0;
            color: #188f2e;
        }
        .fail-message {
            background: #fff0e0;
            color: #c43c15;
        }
        @media (max-width: 950px) {
            .table-container, .container { width: 98%; }
            .main-title { font-size: 2em; }
            th, td { font-size: 1em; }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="welcome.php">Home</a>
        <a href="shop.php">Shop products</a>
        <a href="my_orders.php">My Orders</a>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="admin_dashboard.php">Management Backend</a>
        <?php endif; ?>
        <div class="nav-right">
            <?php if (isset($_SESSION['username'])): ?>
                Welcome <?= htmlspecialchars($_SESSION['username']) ?>!
                &nbsp; <a href="logout.php">Logout</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="container">
        <div class="main-title">Parts ordering</div>
        <div class="sub-title">Shop products</div>

        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <div class="table-actions">
            <a href="add_product.php" class="btn-add" style="text-decoration:none;">Add Product</a>
        </div>
        <?php endif; ?>

        <div class="table-container">
            <?php
            if ($success_message) {
                echo "<div class='" . ($success_message === "訂單已建立！" ? "success-message" : "fail-message") . "'>{$success_message}</div>";
            }
            ?>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock Left</th>
                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
                        <th>Order</th>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <th>Delete</th>
                    <?php endif; ?>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= number_format($row['price'], 2) ?></td>
                    <td><?= $row['stock'] ?></td>

                    <?php if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'): ?>
                    <td>
                        <?php if ($row['stock'] > 0): ?>
                        <form method="post">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <input type="number" name="quantity" min="1" max="<?= $row['stock'] ?>" value="1" required>
                            <button type="submit" name="buy">Add</button>
                        </form>
                        <?php else: ?>
                            <span style="color:#c43c15;">Sold out</span>
                        <?php endif; ?>
                    </td>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <td>
                        <form method="post" action="delete_product.php">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn-delete" onclick="return confirm('確定要刪除這個商品？')">Delete</button>
                        </form>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>
</body>
</html>
