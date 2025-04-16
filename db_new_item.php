<?php
session_start();

include('.gitignore/db.php');
$user = $_SESSION["user"];
$name = $_POST["item_name"];
$description = $_POST["item_description"];
$photo = $_POST["item_image"];

$sql = "INSERT INTO tp_wishlists_items (user_id, item_name, item_description, item_photo) VALUES ($user, '$name', '$description', '$photo')";
mysqli_query($conn, $sql);
$item_id = mysqli_insert_id($conn);

$sql = "UPDATE tp_wishlists_users SET item_count = (SELECT COUNT(*) FROM tp_wishlists_items WHERE user_id = tp_wishlists_users.user_id AND item_status = 3)";
mysqli_query($conn, $sql);

$sql = "INSERT INTO tp_wishlists_history (user_id, type, item_id, a, b, c) VALUES ($user, 3, $item_id, '$name', '$description', '$photo')";
mysqli_query($conn, $sql);


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