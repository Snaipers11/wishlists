<?php
session_start();

include('.gitignore/db.php');
$sep = "___";
$action = explode($sep,$_POST["data"])[0];
$item_id = explode($sep,$_POST["data"])[1];
$user_id = explode($sep, $_POST["data"])[2];
$user = $_SESSION["user"];

$_POST["wishlist_id"] = $user_id;
$_POST["wishlist_name"] = explode($sep, $_POST["data"])[3];
$_POST["wishlist_full_class"] = explode($sep, $_POST["data"])[4];


$status = 0;
$type = 7;
if ($action == 'complete') {
    $status = 1;
    $type = 8;
} elseif ($action == 'hide') {
    $status = 2;
    $type = 5;
} elseif ($action == 'show') {
    $status = 3;
    $type = 6;
}
mysqli_query($conn, "UPDATE tp_wishlists_items SET item_status = $status WHERE item_id = $item_id");

mysqli_query($conn, "UPDATE tp_wishlists_users SET item_count = (SELECT COUNT(*) FROM tp_wishlists_items WHERE user_id = tp_wishlists_users.user_id AND item_status = 3)");

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tp_wishlists_items WHERE item_id = $item_id"));
$a = $row["item_name"];
$b = $row["item_description"];
$c = $row["item_photo"];

mysqli_query($conn, "INSERT INTO tp_wishlists_history (user_id, type, item_id, a, b, c) VALUES ($user, $type, $item_id, '$a', '$b', '$c')");
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
    <link rel="icon" type="image/png" sizes="32x32" href="img/wishlists_favicon.png">
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