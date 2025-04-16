<?php
session_start();
include('.gitignore/db.php');

if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $user = $_SESSION["user"];
    $class = explode(".", $_SESSION["full_class"])[0];
    $group = explode(".", $_SESSION["full_class"])[1];

    $searchQuery = mysqli_real_escape_string($conn, $searchQuery);
    if($_SESSION["admin"]){
        $sql = "SELECT * FROM tp_wishlists_users WHERE user_id != $user";
    } elseif (isset($_SESSION['user'])) {
        $sql = "SELECT * FROM tp_wishlists_users WHERE user_id != $user AND (wishlist_visibility >= 3 OR (wishlist_visibility = 2 AND user_class = '$class') OR (wishlist_visibility = 1 AND user_class = '$class' AND user_group = '$group')) AND item_count > 0";
    } else {
        $sql = "SELECT * FROM tp_wishlists_users WHERE wishlist_visibility = 4 AND item_count > 0";
    }
    if (!empty($searchQuery)) {
        $sql .= " AND user_name LIKE '%$searchQuery%'";
    }
    $sql .= " ORDER BY user_name"; //" AND item_count > 0 ORDER BY user_name"

    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $visibility = array(
                0 => 'URL',
                1 => $row["user_class"].'.'.$row["user_group"],
                2 => $row["user_class"],
                3 => 'Active',
                4 => 'All'
            );
            ?>
            <form onclick="this.submit()" action="wishlist.php" method="POST" role="button">
                <h2><?php echo $row["user_name"]; ?></h2>
                <div>
                    <?php if($_SESSION["admin"] and $row["item_count"] > 0){ echo "<strong>";}?>
                    <p><?php echo $row["item_count"];?> item<?php if($row["item_count"]!=1):?>s<?php endif;?></p>
                    <?php if($_SESSION["admin"] and $row["item_count"] > 0){ echo "</strong>";}?>


                    <p><?php echo $row["user_class"] . '.' . $row["user_group"]; ?></p>
                    <?php if($_SESSION["admin"]){echo "<p><i>".$visibility[$row["wishlist_visibility"]]."</i></p>";}?>
                </div>
                <input type="hidden" name="wishlist_id" value="<?php echo $row["user_id"]; ?>">
                <input type="hidden" name="wishlist_name" value="<?php echo $row["user_name"]; ?>">
                <input type="hidden" name="wishlist_full_class" value="<?php echo $row["user_class"] . '.' . $row["user_group"]; ?>">
            </form>
            <?php
        }
    } else {
        echo "<p>No results found</p>";
    }

    mysqli_close($conn);
}
?>