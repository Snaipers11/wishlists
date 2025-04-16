<?php
session_start();
include('.gitignore/db.php');

function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($_POST["page"] === "login") {
        $email = sanitize($_POST["email"]);
        $password = md5($_POST["password"]);

        $stmt = $conn->prepare("SELECT * FROM tp_wishlists_users WHERE user_email = ? AND user_password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            session_regenerate_id(true);
            $_SESSION["user"] = $row["user_id"];
            $_SESSION["name"] = $row["user_name"];
            $_SESSION["firstname"] = explode(" ", $row["user_name"])[0];
            $_SESSION["full_class"] = $row["user_class"] . '.' . $row["user_group"];
            $_SESSION["wishlist_visibility"] = $row["wishlist_visibility"];
            $_SESSION["admin"] = boolval($row["admin"]);

            header("Location: index.php");
            exit;
        } else {
            echo "<script>alert('Invalid credentials'); window.location.href='login.php';</script>";
            // header("Location: login.php?error=Invalid credentials");
            exit;
        }
    } else {
        // Registration
        $name = sanitize($_POST["name"]);
        $full_class = sanitize($_POST["class"]);
        $email = sanitize($_POST["email1"]);
        $password = md5($_POST["password1"]);

        $class_parts = explode(".", strtoupper($full_class));
        if (count($class_parts) != 2) {
            echo "<script>alert('Invalid class format (class.group - 11.B1)'); window.location.href='register.php';</script>";
            // header("Location: register.php?error=Invalid class format");
            exit;
        }

        list($class, $group) = $class_parts;

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || substr($email, -strlen('@marupe.edu.lv')) !== '@marupe.edu.lv') {
            echo "<script>alert('Invalid email (marupe.edu.lv only)'); window.location.href='register.php';</script>";
            // header("Location: register.php?error=Invalid email");
            exit;
        }


        // Check if email exists
        $stmt = $conn->prepare("SELECT * FROM tp_wishlists_users WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('You already have an account'); window.location.href='login.php';</script>";
            exit;
            // header("Location: register.php?error=Email already taken");
        }

        // Insert user securely
        $stmt = $conn->prepare("INSERT INTO tp_wishlists_users (user_name, user_class, user_group, user_email, user_password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $class, $group, $email, $password);
        $stmt->execute();

        // Get new user ID and update secret
        $user_id = $stmt->insert_id;
        $stmt = $conn->prepare("UPDATE tp_wishlists_users SET user_secret = ? WHERE user_id = ?");
        $secret = md5($user_id);
        $stmt->bind_param("si", $secret, $user_id);
        $stmt->execute();

        // Log history
        $stmt = $conn->prepare("INSERT INTO tp_wishlists_history (user_id, type) VALUES (?, 0)");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        echo "<script>alert('Registered successfully'); window.location.href='login.php';</script>";
        // header("Location: login.php?success=Registered successfully");
        exit;
    }
}
?>
