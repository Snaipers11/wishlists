<?php
session_start();
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
    <!-- <header>
        <div>
            <?php if ($_SESSION["admin"]):?>
                <span style="font-size: 2rem;" onclick="location.href='admin_history.php'">Admin</span>
            <?php endif;?>
        </div>
        <span class="phone"><img style="height: 4rem; width: 4rem;" src="img/wishlists_favicon.png"></span>
        <span class="computer">Wishlists</span>
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
    </header> -->
    <header>
        <div>
            <?php if ($_SESSION["admin"]):?>
                <span class="computer" style="font-size: 2rem;" onclick="location.href='admin_history.php'">Admin</span>
                <span class="phone" style="font-size: 1.5rem;" onclick="location.href='admin_history.php'">Admin</span>
            <?php endif;?>
        </div>
        <span class="phone"><img style="height: 4rem; width: 4rem;" src="img/wishlists_favicon.png"></span>
        <span class="computer">Wishlists</span>
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
        <input id="search-input" placeholder="Search for Wishlists">
        <div id="wishlist-results">
            <!-- AJAX -->
        </div>
    </div>
</body>
</html>
