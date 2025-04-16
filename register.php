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
            <label for="name">Full name</label>
            <input type="text" name="name" placeholder="John Doe" required>
        </div>
        <div>
            <label for="class">Full class</label>
            <input type="text" name="class" placeholder="11.C" required>
        </div>
        <div>
            <label for="email1">E-mail</label>
            <input type="text" name="email1" placeholder="john.doe@marupe.edu.lv" required>
        </div>
        <div>
            <label for="email2">Repeat E-mail</label>
            <input type="text" name="email2" placeholder="john.doe@marupe.edu.lv" required>
        </div>
        <div>
            <div style="flex-direction: row; justify-content: space-between;">
                <label for="password1">Password</label>
                <span class="toggle-password" onclick="togglePassword('password1')">👁️</span>
            </div>
            <input type="password" name="password1" id="password1" placeholder="••••••••••" required>
        </div>
        <div>
            <div style="flex-direction: row; justify-content: space-between;">
                <label for="password2">Repeat Password</label>
                <span class="toggle-password" onclick="togglePassword('password2')">👁️</span>
            </div>
            <input type="password" name="password2" id="password2" placeholder="••••••••••" required>
        </div>
        <button type="submit" style="width: 100%;">Register</button>
        <button type="button" class="button_light" onclick="location.href='login.php'" style="width: 100%;">Login</button>
        <input type="hidden" name="page" value="register">
    </form>
</body>
</html>