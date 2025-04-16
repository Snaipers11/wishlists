<?php
header('Cache-Control: no cache');
session_cache_limiter('public');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Wishlists</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get input fields and preview elements
            const nameInput = document.getElementById("item_name");
            const descInput = document.getElementById("item_description");
            const imgInput = document.getElementById("item_photo");
    
            const previewTitle = document.getElementById("preview_title");
            const previewDesc = document.getElementById("preview_description");
            const previewImage = document.getElementById("preview_image");
    
            // Function to update preview
            function updatePreview() {
                previewTitle.textContent = nameInput.value || "Title";
                previewDesc.textContent = descInput.value || "Description";
                previewImage.src = imgInput.value || "";
            }
    
            // Add event listeners for input changes
            nameInput.addEventListener("input", updatePreview);
            descInput.addEventListener("input", updatePreview);
            imgInput.addEventListener("input", updatePreview);
    
            // Initialize preview with existing values
            updatePreview();
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
        <span onclick="location.href='index.php'">Wishlists</span>
        <div>
            <?php if(isset($_SESSION["user"])): ?>
                <form onclick="this.submit()" action="wishlist.php" method="POST" role="button">
                    <img src="img/account_icon.png">
                    <?php echo $_SESSION["firstname"]; ?>
                    <input type="hidden" name="wishlist_id" value="<?php echo $_SESSION["user"]; ?>">
                    <input type="hidden" name="wishlist_name" value="<?php echo $_SESSION["name"]; ?>">
                    <input type="hidden" name="wishlist_full_class" value="<?php echo $_SESSION["full_class"]; ?>">
                </form>
                <button onclick="location.href='unset.php'">Sign Out</button>
            <?php else: ?>
                <button style="padding-bottom: 0;" onclick="location.href='login_eklase.php'">
                    <img class="img_login" src="img/google_logo.png">
                </button>
            <?php endif; ?>
        </div>
    </header> -->
    <header>
        <div>
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
    
    <div class="preview">
        <div style="text-align: center; display: flex; flex-direction: column; gap: 1rem;">
            <h1 style="margin: 0;">Preview</h1>
            <div class="item" style="margin: 0;">
                <img id="preview_image" src="" alt="Preview Image">
                <div style="justify-content: space-evenly;">
                    <h2 id="preview_title">Title</h2>
                    <p id="preview_description">Description</p>
                </div>
            </div>
        </div>
        
        <form class="add_new" method="POST" action="db_new_item.php">
            <label for="item_name">Name</label>
            <input id="item_name" name="item_name" maxlength="50" required>
            
            <label for="item_description">Description</label>
            <textarea id="item_description" style="resize: none; height: 5rem;" name="item_description" maxlength="255"></textarea>
            
            <label for="item_photo">Image URL</label>
            <input id="item_photo" name="item_photo" maxlength="2083" required>
            
            <button type="submit" style="align-self: center; width: 50%">Add</button>
        </form>
    </div>

</body>
</html>