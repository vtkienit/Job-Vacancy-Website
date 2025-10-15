<?php

session_start();

require 'settings.php';

// Nếu đã đăng nhập thì chuyển đến trang Manage
if(isset($_SESSION['username']) && isset($_SESSION['full_name']) && !empty($_SESSION['username']) && !empty($_SESSION['full_name'])){
    header("Location: manage.php");
    exit();
}

$error = "";
$lockout_time = 60; // 1 phút khóa sau 3 lần sai trở lên

// XỬ LÝ ĐĂNG KÝ (SIGN UP)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $username = trim($_POST['signup_username']);
    $password = $_POST['signup_password'];
    $full_name = trim($_POST['full_name']);

    if (empty($username) || empty($password) || empty($full_name)) {
        $error = "⚠️ Please fill in all fields!";
    } else {
        // Kiểm tra tài khoản đã tồn tại
        $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error);
        }
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Tài khoản đã tồn tại
            $error = "⚠️ Account already exists!";
        } else {
            // Tạo mật khẩu băm SHA-256
            $hashed_password = hash('sha256', $password);
            // Chèn tài khoản vào cơ sở dữ liệu
            $stmt = $conn->prepare("INSERT INTO users (username, password, full_name) VALUES (?, ?, ?)");
            if ($stmt === false) {
                die('MySQL prepare error: ' . $conn->error);
            }
            $stmt->bind_param("sss", $username, $hashed_password, $full_name);

            if ($stmt->execute()) {
                // Đăng ký thành công
                $_SESSION['signup_success'] = "✅ Registration successful! Please log in.";
            } else {
                $error = "⚠️ Error during registration! Please try again.";
            }
        }
        $stmt->close();
    }
}

// Hiển thị thông báo đăng ký thành công (nếu có)
if (isset($_SESSION['signup_success'])) {
    $error = $_SESSION['signup_success'];
    unset($_SESSION['signup_success']);
}

// XỬ LÝ ĐĂNG NHẬP (LOGIN)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "⚠️ Please enter both username and password!";
    } else {
        // Kiểm tra số lần đăng nhập sai
        $stmt = $conn->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        $attempts = 0;
        $last_attempt = null;

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($attempts, $last_attempt);
            $stmt->fetch();

            if ($attempts >= 3 && (time() - strtotime($last_attempt)) < $lockout_time) {
                $error = "⏳ Too many failed attempts! Try again later after 60s.";
            }
        }

        // Nếu chưa bị khóa, kiểm tra thông tin đăng nhập
        if (empty($error)) {
            $stmt = $conn->prepare("SELECT password, full_name FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $stmt->bind_result($db_password, $full_name);
                $stmt->fetch();

                if (hash('sha256', $password) === $db_password) {
                    // Đăng nhập thành công
                    session_regenerate_id(true);
                    $_SESSION['username'] = $username;
                    $_SESSION['full_name'] = $full_name;

                    // Reset số lần đăng nhập sai
                    $stmt = $conn->prepare("DELETE FROM login_attempts WHERE username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();

                    header("Location: manage.php");
                    exit;
                } else {
                    $error = "⚠️ Invalid username or password!";
                    $attempts++;
                }
            } else {
                $error = "⚠️ Invalid username or password!";
                $attempts++;
            }
            $stmt->close();

            // Cập nhật số lần đăng nhập sai
            $stmt = $conn->prepare("INSERT INTO login_attempts (username, attempts, last_attempt) VALUES (?, ?, NOW()) 
                ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt = NOW()");
            $stmt->bind_param("si", $username, $attempts);
            $stmt->execute();
            $stmt->close();
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="images/logo.png">
    <meta name="description" content="Creating Web Application">
    <meta name="keywords" content="HTML, CSS">
    <meta name="author" content="Do Tien Loc">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="login-page">
        <div class="content">
            <h1>Hey, Hello!</h1>
            <h2>Join the Manager For The Management System!</h2>
            <p>We provide all the advantages that can manage all your accounts</p>
        </div>

        <div class="main">
            <input type="checkbox" id="chk" aria-hidden="true">

            <!-- Form Đăng nhập -->
            <div class="login">
                <form method="POST" action="login.php">
                    <label for="chk" aria-hidden="true">Login</label>
                    <p>All login <span class="highlight-must">MUST</span> be done by website Manager!</p>
                    <p><span class="highlight-donot">DO NOT</span> attempt to login if you are not website Manager!</p>
                    <input type="text" name="username" placeholder="User name" required="">
                    <input type="password" name="password" placeholder="Password" required="">
                    <button type="submit" name="login">Login</button>
                    <?php if (!empty($error)) : ?>
                        <p class="error-message"><?php echo $error; ?></p>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Form Đăng ký -->
            <div class="signup">
                <form method="POST" action="login.php">
                    <label for="chk" aria-hidden="true">Sign Up</label>
                    <input type="text" name="full_name" placeholder="Full name" required="">
                    <input type="text" name="signup_username" placeholder="User name" required="">
                    <input type="password" name="signup_password" placeholder="Password" required="">
                    <button type="submit" name="signup">Sign Up</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
