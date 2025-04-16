<?php
session_start();

include('.gitignore/db.php');
$id = $_POST["item_id"];
$name = $_POST["item_name"];
$description = $_POST["item_description"];
$photo = $_POST["item_photo"];

$user = $_SESSION["user"];
$old_name = $_POST["old_name"];
$old_description = $_POST["old_description"];
$old_photo = $_POST["old_photo"];

mysqli_query($conn, "UPDATE tp_wishlists_items SET item_name = '$name', item_description = '$description', item_photo = '$photo' WHERE item_id = $id");

mysqli_query($conn, "INSERT INTO tp_wishlists_history (user_id, type, item_id, a, b, c, d, e, f) VALUES ($user, 4, $id, '$old_name', '$old_description', '$old_photo', '$name', '$description', '$photo')");

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