<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["wishlist_visibility"])) {
    $_SESSION["wishlist_visibility"] = (int)$_POST["wishlist_visibility"];
}

include('.gitignore/db.php');
$visibility = $_SESSION["wishlist_visibility"];
$user = $_SESSION["user"];

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tp_wishlists_users WHERE user_id = $user"));
$old_visibility = $row["wishlist_visibility"];

mysqli_query($conn, "UPDATE tp_wishlists_users SET wishlist_visibility = $visibility WHERE user_id = $user");

mysqli_query($conn, "INSERT INTO tp_wishlists_history (user_id, type, a, b) VALUES ($user, 2, $old_visibility, $visibility)");

$_POST["wishlist_id"] = $_SESSION["user"];
$_POST["wishlist_name"] = $_SESSION["name"];
$_POST["wishlist_full_class"] = $_SESSION["full_class"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0;url=wishlist.php">
    <script type="text/javascript">
        window.onload = function() {
            document.forms["postForm"].submit();
        }
    </script>
</head>
<body>
    <form name="postForm" method="POST" action="wishlist.php">
        <?php
        foreach ($_POST as $key => $value) {
            echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
        }
       ?>
    </form>
</body>
</html>