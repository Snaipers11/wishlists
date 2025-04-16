<?php
session_start();

include('.gitignore/db.php');
mysqli_query($conn, "UPDATE tp_wishlists_users SET item_count = (SELECT COUNT(*) FROM tp_wishlists_items WHERE user_id = tp_wishlists_users.user_id AND item_status = 3)");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Wishlists</title>
    <link rel="icon" type="image/x-icon" href="/img/W.png">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
    <script>
        $(document).ready(function() {
            $('#search-input').on('input', function() {
                const query = $(this).val();
                $.ajax({
                    url: 'search.php',
                    type: 'GET',
                    data: { search: query },
                    success: function(response) {
                        $('#wishlist-results').html(response);
                    }
                });
            });
            $('#search-input').trigger('input');
        });
    </script>
    <link rel="icon" type="image/png" sizes="32x32" href="img/wishlists_favicon.png">
</head>
<body>
    <header>
        <div>
            <span style="font-size: 2rem;">Admin</span>
        </div>
        <span onclick="location.href='index.php'">Wishlists</span>
        <div>
            <?php if (isset($_SESSION["user"])):?>
                <form onclick="this.submit()" action="wishlist.php" method="POST" role="button">
                    <img src="img/account_icon.png">
                    <?php echo $_SESSION["firstname"];?>
                    <input type="hidden" name="wishlist_id" value="<?php echo $_SESSION["user"];?>">
                    <input type="hidden" name="wishlist_name" value="<?php echo $_SESSION["name"];?>">
                    <input type="hidden" name="wishlist_full_class" value="<?php echo $_SESSION["full_class"];?>">
                </form>
                <button class="computer" onclick="location.href='unset.php'">Sign Out</button>
            <?php else:?>
                <button class="computer" onclick="location.href='login.php'">Login</button>
                <button class="computer" onclick="location.href='register.php'">Register</button>
                <button class="phone button_light" onclick="location.href='login.php'">Login</button>
            <?php endif;?>
        </div>
    </header>
    <h1 style="text-align: center;">History</h1>
    <div class="center" style="width: fit-content; gap: 1rem;">
        <?php $result = mysqli_query($conn, "SELECT * FROM tp_wishlists_history ORDER BY timestamp DESC");
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $user_id = $row["user_id"];
                $type = $row["type"];
                $row0 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tp_wishlists_users WHERE user_id = $user_id"));?>
                <div>
                    <?php echo $row["timestamp"];?>
                    <?php if($type == 0):?>
                        New user: <strong><?php echo $row0["user_name"];?></strong>
                    <?php elseif($type == 2):
                        $visibility = array(
                            0 => 'URL',
                            1 => $row0["user_class"].'.'.$row0["user_group"],
                            2 => $row0["user_class"],
                            3 => 'Active',
                            4 => 'All'
                        );?>
                        <strong><?php echo $row0["user_name"];?></strong> changed wishlist visibility from <strong><?php echo $visibility[$row["a"]];?></strong> to <strong><?php echo $visibility[$row["b"]];?></strong>
                    <?php elseif($type == 3):?>
                        <strong><?php echo $row0["user_name"];?></strong> added a new item
                        <div class="item" style="margin: 0;">
                            <img id="preview_image" src="<?php echo $row["c"];?>" alt="Preview Image">
                            <div style="justify-content: space-evenly;">
                                <h2 id="preview_title"><?php echo $row["a"];?></h2>
                                <p id="preview_description"><?php echo $row["b"];?></p>
                            </div>
                        </div>
                    <?php elseif($type == 4):?>
                        <strong><?php echo $row0["user_name"];?></strong> edited an item
                        <div style="display: flex; flex-direction: row; gap: 1rem;">
                            <div class="item" style="margin: 0;">
                                <img id="preview_image" src="<?php echo $row["c"];?>" alt="Preview Image">
                                <div style="justify-content: space-evenly;">
                                    <h2 id="preview_title"><?php echo $row["a"];?></h2>
                                    <p id="preview_description"><?php echo $row["b"];?></p>
                                </div>
                            </div>
                            <div class="item" style="margin: 0;">
                                <img id="preview_image" src="<?php echo $row["f"];?>" alt="Preview Image">
                                <div style="justify-content: space-evenly;">
                                    <h2 id="preview_title"><?php echo $row["d"];?></h2>
                                    <p id="preview_description"><?php echo $row["e"];?></p>
                                </div>
                            </div>
                        </div>
                    <?php elseif($type == 5):?>
                        <strong><?php echo $row0["user_name"];?></strong> hid an item
                        <div class="item" style="margin: 0;">
                            <img id="preview_image" src="<?php echo $row["c"];?>" alt="Preview Image">
                            <div style="justify-content: space-evenly;">
                                <h2 id="preview_title"><?php echo $row["a"];?></h2>
                                <p id="preview_description"><?php echo $row["b"];?></p>
                            </div>
                        </div>
                    <?php elseif($type == 6):?>
                        <strong><?php echo $row0["user_name"];?></strong> showed an item
                        <div class="item" style="margin: 0;">
                            <img id="preview_image" src="<?php echo $row["c"];?>" alt="Preview Image">
                            <div style="justify-content: space-evenly;">
                                <h2 id="preview_title"><?php echo $row["a"];?></h2>
                                <p id="preview_description"><?php echo $row["b"];?></p>
                            </div>
                        </div>
                    <?php elseif($type == 7):
                        $item_id = $row["item_id"];
                        $row7 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tp_wishlists_items WHERE item_id = $item_id"));
                        if($user_id == $row7["user_id"]):?>
                            <strong><?php echo $row0["user_name"];?></strong> deleted an item
                        <?php else:
                            $row72 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tp_wishlists_users WHERE user_id = (SELECT user_id FROM tp_wishlists_items WHERE item_id = $item_id)"));?>
                            Admin <strong><?php echo $row0["user_name"];?></strong> deleted <strong><?php echo $row72["user_name"];?></strong>'s item
                        <?php endif?>
                        <div class="item" style="margin: 0;">
                            <img id="preview_image" src="<?php echo $row["c"];?>" alt="Preview Image">
                            <div style="justify-content: space-evenly;">
                                <h2 id="preview_title"><?php echo $row["a"];?></h2>
                                <p id="preview_description"><?php echo $row["b"];?></p>
                            </div>
                        </div>
                    <?php elseif($type == 8):
                        $item_id = $row["item_id"];
                        $row8 = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tp_wishlists_users WHERE user_id = (SELECT user_id FROM tp_wishlists_items WHERE item_id = $item_id)"));?>
                        <strong><?php echo $row0["user_name"];?></strong> completed <strong><?php echo $row8["user_name"];?></strong>'s item
                        <div class="item" style="margin: 0;">
                            <img id="preview_image" src="<?php echo $row["c"];?>" alt="Preview Image">
                            <div style="justify-content: space-evenly;">
                                <h2 id="preview_title"><?php echo $row["a"];?></h2>
                                <p id="preview_description"><?php echo $row["b"];?></p>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            <?php };
        }?>
    </div>
</body>
</html>
