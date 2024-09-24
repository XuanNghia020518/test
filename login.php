<!DOCTYPE HTML>
<html>

<head>
    <title>Test Login</title>
    <script src="js/jquery.min.js"></script>
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
</head>

<body>
    <div class="header">
        <div class="header-main">
            <h1>Login Form</h1>

            <?php
            if (isset($_GET['error'])) {
                echo "<p style='color:red;'>Tên đăng nhập hoặc mật khẩu không đúng.</p>";
            }
            if (isset($_GET['success'])) {
                echo "<p style='color:green;'>Đăng nhập thành công!</p>";
            }
            ?>

            <div class="header-bottom">
                <div class="header-right w3agile">
                    <div class="header-left-bottom agileinfo">
                        <form action="login_process.php" method="post">
                            <input type="text" placeholder="User name" name="username" required />
                            <input type="password" placeholder="Password" name="password" required />
                            <div class="remember">
                                <span class="checkbox1">
                                    <label class="checkbox"><input type="checkbox" name="remember"><i></i>Remember me</label>
                                </span>
                                <div class="forgot">
                                    <h6><a href="#">Forgot Password?</a></h6>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <input type="submit" value="Login">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
