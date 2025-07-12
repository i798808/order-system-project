<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>零件訂購系統</title>
    <style>
        body {
            background: #fff;
            margin: 0;
            padding: 0;
            font-family:'Montserrat';
        }
        .container {
            display: flex;
            min-height: 70vh;
            align-items: center;    /* 垂直置中，內容不會黏頂或黏底 */
            justify-content: center;
            padding: 0;             /* 兩側不要太多空白 */
        }
        .left-panel {  
            flex: 1;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 30px 0 0 0;
        }
        /* Parts ordering */
        .left-panel h1 {
            font-size: 5em;
            margin: 0 0 20px 0;
            font-weight: bold;
            letter-spacing: 2px;
        }
        /* Welcome to the Parts Ordering System. If you have any questions, please feel free to contact customer service. */
        .left-panel .subtitle {
            margin-bottom: 100px;
            color: #444;
            font-size: 1.2em;
        }
        /* Connecting every part with technology. */
        .left-panel .welcome-text {
            margin-top: 80px;
            color: #222;
            font-size: 1.08em;
            width: 70%;
            text-align: center;
        }
        .right-panel {
            flex: 2.2;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px  0 0 0;
            background: #f4f7fa;
        }
        .right-panel img {
            width: 150%;
            max-width: 900px;
            border-radius: 10px;
            margin-bottom: 24px;
            box-shadow: 0 3px 20px 3px #f4f7fa;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .info-boxes {
            width: 150%;
            max-width: 900px;
            margin: 0 auto;
            display: flex;
            gap: 20px;
        }
        .about-box, .howto-box {
            flex: 1;
            background: #d3e4f9;
            border-radius: 7px;
            padding: 18px 18px 10px 18px;
            margin-bottom: 10px;
        }
        .about-box {
            margin-right: 10px;
            background: #d3e4f9;
        }
        .howto-box {
            background: #557dbf;
            color: #fff;
        }
        .about-box h2, .howto-box h2 {
            margin-top: 0;
            font-size: 1.25em;
            font-weight: bold;
        }
        .howto-box ol {
            padding-left: 22px;
            margin: 10px 0 0 0;
        }
        .howto-box li {
            margin-bottom: 7px;
            font-size: 1.07em;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <!-- 左側 -->
        <div class="left-panel">
            <h1>Parts<br>Ordering</h1>
            <div class="subtitle">
                Connecting every part with technology.
            </div>
            <div class="welcome-text">
                Welcome to the Parts Ordering System. If you have any questions, please feel free to contact customer service.
            </div>
        </div>
        <!-- 右側 -->
        <div class="right-panel">
            <img src="images/mainboard.jpg" alt="Mainboard">
            <div class="info-boxes">
                <div class="about-box">
                    <h2>About</h2>
                    <div style="font-size:1em;">
                        A simple and user-friendly online platform that allows users to easily browse and purchase products. You can also check your order history in the "My Orders" section. The system is intuitive to use, making it easy to manage and track all your purchases for a smooth ordering experience.
                    </div>
                </div>
                <div class="howto-box">
                    <h2>How to Order</h2>
                    <ol>
                        <li>Browse and select the parts you need.</li>
                        <li>Add them to your cart.</li>
                        <li>Complete your order and track it under "My Orders".</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
