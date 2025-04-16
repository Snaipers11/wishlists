<?php
session_start();
if(isset($_SESSION["user"])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Wishlists</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src="main.js"></script>
    <link rel="icon" type="image/png" sizes="32x32" href="img/wishlists_favicon.png">
</head>
<body>
    <header>
        <div></div>
        <span onclick="location.href='index.php'">Wishlists</span>
        <div></div>
    </header>
    <form class="login_box" action='cfg.php' method='POST'>
        <div>
            <label for="email">E-mail</label>
            <input type="text" name="email" placeholder="john.doe@marupe.edu.lv" required>
        </div>
        <div>
            <div style="flex-direction: row; justify-content: space-between;">
                <label for="password">Password</label>
                <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
            </div>
            <input type="password" name="password" id="password" placeholder="••••••••••" required>
        </div>
        <button style="width: 100%;">Login</button>
        <button type="button" class="button_light" onclick="location.href='register.php'" style="width: 100%;">Register</button>
        <input type="hidden" name="page" value="login">
    </form>
</body>
</html>