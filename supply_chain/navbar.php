<?php
if (session_status() == PHP_SESSION_NONE) session_start();
$username = $_SESSION['username'] ?? '';
$role = $_SESSION['role'] ?? '';
?>
<style>
.navbar {
    width: 100%;
    background:rgb(255, 255, 255);
    color: #1c1b1b;
    padding: 0 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 58px;
    box-sizing: border-box;
    font-family: 'Montserrat';
}
.navbar .nav-left {
    display: flex;
    align-items: center;
    gap: 22px;
}
.navbar .nav-left a {
    color:  #1c1b1b;
    text-decoration: none;
    padding: 0 16px;
    font-size: 1.14em;
    line-height: 58px;
    border-radius: 8px;
    transition: background 0.14s;
    font-weight: bold;
    letter-spacing: 1px;
}
.navbar .nav-left a:hover {
    background:rgb(198, 206, 223);
}
.navbar .welcome {
    font-size: 1.08em;
    font-weight: bold;
    margin-right: 18px;
    letter-spacing: 1px;
}
.navbar .logout-link {
    color:  #1c1b1b;
    text-decoration: none;
    padding: 0 16px;
    font-size: 1.14em;
    line-height: 58px;
    border-radius: 8px;
    transition: background 0.14s;
    font-weight: bold;
    letter-spacing: 1px;
}
.navbar .logout-link:hover {
    background: rgb(198, 206, 223);
    
}
</style>
<div class="navbar">
    <div class="nav-left">
        <a href="welcome.php">Home</a>
        <?php if ($role === "admin"): ?>
            <a href="admin_dashboard.php">Management Backend</a>
        <?php else: ?>
            <a href="shop.php">Shop products</a>
            <a href="my_orders.php">My Orders</a>
        <?php endif; ?>
    </div>
    <div>
        <span class="welcome">
            <?php if ($username) echo "Welcome " . htmlspecialchars($username).'!'; ?>
        </span>
        <?php if ($username): ?>
            <a href="logout.php" class="logout-link">Logout</a>
        <?php endif; ?>
    </div>
</div>
