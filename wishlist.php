<?php
header('Cache-Control: no cache');
session_cache_limiter('public');
session_start();
include('.gitignore/db.php');

if (isset($_GET['id'])) {
    $wishlist_secret = $_GET['id'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tp_wishlists_users WHERE user_secret = '$wishlist_secret'"));
    $wishlist_id = $row["user_id"];
} else if (isset($_POST["wishlist_id"])) {
    $wishlist_id = $_POST["wishlist_id"];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tp_wishlists_users WHERE user_id = $wishlist_id"));
    $wishlist_secret = $row["user_secret"];
} else {
   header("Location: index.php");
}

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tp_wishlists_users WHERE user_id = $wishlist_id"));
$name = $row["user_name"];
$class = $row["user_class"].'.'.$row["user_group"];

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Wishlists</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function copyToClipboard(element) {
                const urlToCopy = element.getAttribute("data-url");
                navigator.clipboard.writeText(urlToCopy).catch(function(err) {
                    console.error("Failed to copy: ", err);
                });
            }

            const copyButton = document.getElementById("copyUrlButton");
            const copyName = document.getElementById("copyName");

            copyButton.addEventListener("click", function() {
                copyToClipboard(copyButton);
            });

            copyName.addEventListener("click", function() {
                copyToClipboard(copyName);
            });
        });
    </script>
    <link rel="icon" type="image/png" sizes="32x32" href="img/wishlists_favicon.png">
</head>
<body>
    <header>
        <div>
            <button id="copyUrlButton" data-url="https://mvg.lv/tp/wishlist.php?id=<?php echo $wishlist_secret?>">Copy URL</button>
            <?php if ($_SESSION["admin"]):?>
                <span class="computer" style="font-size: 2rem;" onclick="location.href='admin_history.php'">Admin</span>
                <span class="phone" style="font-size: 1.5rem;" onclick="location.href='admin_history.php'">Admin</span>
            <?php endif;?>
        </div>
        <span class="phone" onclick="location.href='index.php'"><img style="height: 4rem; width: 4rem;" src="img/wishlists_favicon.png"></span>
        <span class="computer" onclick="location.href='index.php'">Wishlists</span>
        <div>
            <?php if (isset($_SESSION["user"])):?>
                <form onclick="this.submit()" action="wishlist.php" method="POST" role="button">
                    <img src="img/account_icon.png">
                    <?php echo $_SESSION["firstname"];?>
                    <input type="hidden" name="wishlist_id" value="<?php echo $_SESSION["user"];?>">
                    <input type="hidden" name="wishlist_name" value="<?php echo $_SESSION["name"];?>">
                    <input type="hidden" name="wishlist_full_class" value="<?php echo $_SESSION["full_class"];?>">
                </form>
                <button onclick="location.href='unset.php'">Sign Out</button>
            <?php else:?>
                <button class="computer" onclick="location.href='login.php'">Login</button>
                <button class="computer" onclick="location.href='register.php'">Register</button>
                <button class="phone" onclick="location.href='login.php'">Login</button>
            <?php endif;?>
        </div>
    </header>
    <div class="center">
        <div class="wishlist_info">
            <?php if(isset($_SESSION["user"]) and $_SESSION["user"] == $_POST["wishlist_id"]):?>
                <form class="button_new" method="POST" action="new_item.php" onclick="this.submit()">New item</form>
                <div style="display: flex; flex-direction: column; gap: 0.5rem">
                    <p>Wishlist visibility</p>
                    <form class="wishlist_info_side" method="POST" action="visibility.php" class="switch">
                        <input onclick="this.form.submit()" type="radio" id="position1" name="wishlist_visibility" value="4" class="switch-option" <?php if ($_SESSION["wishlist_visibility"] == 4) echo 'checked';?>>
                        <input onclick="this.form.submit()" type="radio" id="position2" name="wishlist_visibility" value="3" class="switch-option" <?php if ($_SESSION["wishlist_visibility"] == 3) echo 'checked';?>>
                        <input onclick="this.form.submit()" type="radio" id="position3" name="wishlist_visibility" value="2" class="switch-option" <?php if ($_SESSION["wishlist_visibility"] == 2) echo 'checked';?>>
                        <input onclick="this.form.submit()" type="radio" id="position4" name="wishlist_visibility" value="1" class="switch-option" <?php if ($_SESSION["wishlist_visibility"] == 1) echo 'checked';?>>
                        <input onclick="this.form.submit()" type="radio" id="position5" name="wishlist_visibility" value="0" class="switch-option" <?php if ($_SESSION["wishlist_visibility"] == 0) echo 'checked';?>>

                        <label for="position1" class="switch-label">All</label>
                        <label for="position2" class="switch-label">Active</label>
                        <label for="position3" class="switch-label"><?php echo explode(".", $class)[0];?></label>
                        <label for="position4" class="switch-label"><?php echo $class;?></label>
                        <label for="position5" class="switch-label">URL</label>
                    </form>
                </div>
            <?php else:?>
                <?php if($_SESSION["admin"]):?>
                <div style="display: flex; flex-direction: column; gap: 0.5rem; color: rgb(127, 127, 127);">
                    <p class="wishlist_info_side">User joined</p>
                    <p class="wishlist_info_side"><?php echo $row["user_joined"]; ?></p>
                </div>
                <?php endif;?>
                <h1 class="wishlist_info_side" style="margin: 1rem;" id="copyName" data-url="https://mvg.lv/tp/wishlist.php?id=<?php echo $wishlist_secret;?>"><?php echo $name;?></h1>
                <div style="align-items: center; margin: 1rem;">
                    <!-- <button style="font-size: 1.5rem;" class="button_clear phone" id="copyUrlButton" data-url="https://mvg.lv/tp/wishlist.php?id=<?php echo $wishlist_secret?>">🔗</button> -->
                    <h2 class="wishlist_info_side" style='color: rgb(127, 127, 127);'><?php echo $class?></h2>
                </div>
            <?php endif;?>
        </div>
        <div class="items">
            <?php if(isset($_SESSION["user"]) and $_SESSION["user"] == $wishlist_id):
                $result = mysqli_query($conn, "SELECT * FROM tp_wishlists_items WHERE user_id = $wishlist_id AND item_status >= 1 ORDER BY item_status DESC, item_name");
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if($row["item_status"] == 3):?>
                            <div class="item">
                                <img src="<?php echo $row["item_photo"]?>">
                                <div>
                                    <h2><?php echo $row["item_name"]?></h2>
                                    <p><?php echo $row["item_description"]?></p>
                                    <div>
                                        <form class="button_show" action="wishlist_update.php" method="POST" onclick="this.submit()">Hide<input type="hidden" name="data" value="hide___<?php echo $row["item_id"].'___'.$_POST["wishlist_id"].'___'.$name.'___'.$class?>"></form>
                                        <form class="button_edit" action="edit_item.php" method="POST" onclick="this.submit()">Edit<input type="hidden" name="item_id" value="<?php echo $row["item_id"]?>"></form>
                                        <form class="button_delete" action="wishlist_update.php" method="POST" onclick="if(confirm('Are you sure you want to delete this item?')) this.submit(); return false;">
                                            Delete
                                            <input type="hidden" name="data" value="delete___<?php echo $row['item_id'].'___'.$_POST['wishlist_id'].'___'.$name.'___'.$class;?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php elseif($row["item_status"] == 2):?>
                            <div class="item" style="opacity: 0.5;">
                                <img src="<?php echo $row["item_photo"]?>">
                                <div>
                                    <h2><?php echo $row["item_name"]?></h2>
                                    <p><?php echo $row["item_description"]?></p>
                                    <div>
                                        <form class="button_show" action="wishlist_update.php" method="POST" onclick="this.submit()">Show<input type="hidden" name="data" value="show___<?php echo $row["item_id"].'___'.$_POST["wishlist_id"].'___'.$name.'___'.$class?>"></form>
                                        <form class="button_edit" action="edit_item.php" method="POST" onclick="this.submit()">Edit<input type="hidden" name="item_id" value="<?php echo $row["item_id"]?>"></form>
                                        <form class="button_delete" action="wishlist_update.php" method="POST" onclick="if(confirm('Are you sure you want to delete this item?')) this.submit(); return false;">
                                            Delete
                                            <input type="hidden" name="data" value="delete___<?php echo $row['item_id'].'___'.$_POST['wishlist_id'].'___'.$name.'___'.$class;?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php else:?>
                                <div class="item" style="border-color: green; opacity: 0.5;">
                                    <img src="<?php echo $row["item_photo"]?>">
                                    <div style="justify-content: space-evenly;">
                                        <h2 style="color: green;"><?php echo $row["item_name"]?></h2>
                                        <p style="color: green;"><?php echo $row["item_description"]?></p>
                                    </div>
                                </div>
                        <?php endif;
                    };
                } else {?>
                    <p>No items yet</p>
                <?php }
            elseif($_SESSION["admin"]):
                $result = mysqli_query($conn, "SELECT * FROM tp_wishlists_items WHERE user_id = $wishlist_id AND item_status >= 1 ORDER BY item_status DESC, item_name");
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if($row["item_status"] == 3):?>
                            <div class="item">
                                <img src="<?php echo $row["item_photo"]?>">
                                <div>
                                    <h2><?php echo $row["item_name"]?></h2>
                                    <p><?php echo $row["item_description"]?></p>
                                    <div>
                                        <form class="button_light" action="wishlist_update.php" method="POST" onclick="if(confirm('Are you sure you want to complete this item?')) this.submit(); return false;">
                                            Complete
                                            <input type="hidden" name="data" value="complete___<?php echo $row["item_id"].'___'.$_POST["wishlist_id"].'___'.$name.'___'.$class;?>">
                                        </form>
                                        <form class="button_delete" action="wishlist_update.php" method="POST" onclick="if(confirm('Are you sure you want to delete this item?')) this.submit(); return false;">
                                            Delete
                                            <input type="hidden" name="data" value="delete___<?php echo $row['item_id'].'___'.$_POST['wishlist_id'].'___'.$name.'___'.$class;?>">
                                        </form>
                                        <div style="text-align: center;">
                                            <p><?php echo explode(" ", $row["item_added"])[1];?></p>
                                            <p><?php echo explode(" ", $row["item_added"])[0];?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php elseif($row["item_status"] == 2):?>
                            <div class="item" style="opacity: 0.5;">
                                <img src="<?php echo $row["item_photo"]?>">
                                <div>
                                    <h2><?php echo $row["item_name"]?></h2>
                                    <p><?php echo $row["item_description"]?></p>
                                    <div>
                                        <form class="button_delete" action="wishlist_update.php" method="POST" onclick="if(confirm('Are you sure you want to delete this item?')) this.submit(); return false;">
                                            Delete
                                            <input type="hidden" name="data" value="delete___<?php echo $row['item_id'].'___'.$_POST['wishlist_id'].'___'.$name.'___'.$class;?>">
                                        </form>
                                        <div style="text-align: center;">
                                            <p><?php echo explode(" ", $row["item_added"])[1];?></p>
                                            <p><?php echo explode(" ", $row["item_added"])[0];?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else:?>
                                <div class="item" style="border-color: green; opacity: 0.5;">
                                    <img src="<?php echo $row["item_photo"]?>">
                                    <div style="justify-content: space-evenly;">
                                        <h2 style="color: green;"><?php echo $row["item_name"]?></h2>
                                        <p style="color: green;"><?php echo $row["item_description"]?></p>
                                        <div>
                                        <form class="button_delete" action="wishlist_update.php" method="POST" onclick="if(confirm('Are you sure you want to delete this item?')) this.submit(); return false;">
                                            Delete
                                            <input type="hidden" name="data" value="delete___<?php echo $row['item_id'].'___'.$_POST['wishlist_id'].'___'.$name.'___'.$class;?>">
                                        </form>
                                        <div style="text-align: center;">
                                            <p><?php echo explode(" ", $row["item_added"])[1];?></p>
                                            <p><?php echo explode(" ", $row["item_added"])[0];?></p>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                        <?php endif;
                    };
                } else {?>
                    <p>No items yet</p>
                <?php }
            elseif(isset($_SESSION["user"])):
                $result = mysqli_query($conn, "SELECT * FROM tp_wishlists_items WHERE user_id = $wishlist_id AND (item_status = 1 OR item_status = 3) ORDER BY item_status DESC, item_name");
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if($row["item_status"] == 3):?>
                            <div div class="item">
                                <img src="<?php echo $row["item_photo"]?>">
                                <div>
                                    <h2><?php echo $row["item_name"]?></h2>
                                    <p><?php echo $row["item_description"]?></p>
                                    <div>
                                        <form class="button_light" action="wishlist_update.php" method="POST" onclick="if(confirm('Are you sure you want to complete this item?')) this.submit(); return false;">
                                            Complete
                                            <input type="hidden" name="data" value="complete___<?php echo $row["item_id"].'___'.$_POST["wishlist_id"].'___'.$name.'___'.$class;?>">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php elseif($row["item_status"] == 1):?>
                            <div div class="item" style="border-color: green; opacity: 0.5;">
                                    <img src="<?php echo $row["item_photo"]?>">
                                    <div style="justify-content: space-evenly;">
                                        <h2 style="color: green;"><?php echo $row["item_name"]?></h2>
                                        <p style="color: green;"><?php echo $row["item_description"]?></p>
                                    </div>
                                </div>
                        <?php endif;
                    };
                } else {?>
                    <p>No items yet</p>
                <?php }
            else:
                $result = mysqli_query($conn, "SELECT * FROM tp_wishlists_items WHERE user_id = $wishlist_id AND item_status = 3 ORDER BY item_status DESC, item_name");
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {?>
                        <div div class="item">
                            <img src="<?php echo $row["item_photo"]?>">
                            <div style="justify-content: space-evenly;">
                                <h2><?php echo $row["item_name"]?></h2>
                                <p><?php echo $row["item_description"]?></p>
                            </div>
                        </div>
                    <?php }
                } else {?>
                    <p>No items yet</p>
                <?php }
            endif;
            mysqli_close($conn);?>
        </div>
    </div>
</body>
</html>