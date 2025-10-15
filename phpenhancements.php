<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="images/logo.png">
    <meta name="description" content="Creating Web Application">
    <meta name="keywords" content="HTML, CSS">
    <meta name="author" content="Vu Trung Kien">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <title>Enhancements</title>
</head>
<body>
    <?php include 'header.inc'; ?>
    
    <div class="enhancements-container">
        <dl>
            <dt>
                Sort the EOI records by Fields
                <a id="a-color1" href="manage.php">[View Here]</a>
            </dt>
            <dd>
                <p>Arrange the EOI records based on specified fields to facilitate easier analysis</p>
                <code class="css-code" id="code-color1">
                    if($type_query==1){
                        echo "type='hidden' name='search_first_name' value=$firstName";
                        echo "type='hidden' name='search_last_name' value=$lastName";

                    }elseif($type_query==2){
                        echo "type='hidden' name='eoi_number' value=$eoiNumber";

                    }elseif($type_query==3){
                        echo "type='hidden' name='list_all' value='1'";
                    }

                    if(!empty($_GET['option_sort'])){
                        $sortField = isset($_GET['option_sort']) ? $_GET['option_sort'] : '';
                    }

                    if ($sortField !== '') {
                        $sql .= " ORDER BY $sortField";
                    }
                </code>
            </dd>
            <br>
            <dt>
                Manager Sign Up and Sign In Page
                <a id="a-color1" href="login.php">[View Here]</a>
            </dt>
            <dd>
                <p>A page for managers to securely register a new account or log in to an existing account to access the management system</p>
                <code class="css-code" id="code-color1">
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
                        $username = trim($_POST['signup_username']);
                        $password = $_POST['signup_password'];
                        $full_name = trim($_POST['full_name']);

                        if (empty($username) || empty($password) || empty($full_name)) {
                            $error = "⚠️ Please fill in all fields!";
                        } else {
                            $stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
                            if ($stmt === false) {
                                die('MySQL prepare error: ' . $conn->error);
                            }
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $stmt->store_result();

                            if ($stmt->num_rows > 0) {
                                $error = "⚠️ Account already exists!";
                            } else {
                                $hashed_password = hash('sha256', $password);
                                $stmt = $conn->prepare("INSERT INTO users (username, password, full_name) VALUES (?, ?, ?)");
                                if ($stmt === false) {
                                    die('MySQL prepare error: ' . $conn->error);
                                }
                                $stmt->bind_param("sss", $username, $hashed_password, $full_name);

                                if ($stmt->execute()) {
                                    $_SESSION['signup_success'] = "✅ Registration successful! Please log in.";
                                    exit;
                                } else {
                                    $error = "⚠️ Error during registration! Please try again.";
                                }
                            }
                            $stmt->close();
                        }
                    }

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
                        $username = trim($_POST['username']);
                        $password = $_POST['password'];

                        if (empty($username) || empty($password)) {
                            $error = "⚠️ Please enter both username and password!";
                        } else {
                            $stmt = $conn->prepare("SELECT attempts, last_attempt FROM login_attempts WHERE username = ?");
                            $stmt->bind_param("s", $username);
                            $stmt->execute();
                            $stmt->store_result();

                            if (empty($error)) {
                                $stmt = $conn->prepare("SELECT password, full_name FROM users WHERE username = ?");
                                $stmt->bind_param("s", $username);
                                $stmt->execute();
                                $stmt->store_result();

                                if ($stmt->num_rows > 0) {
                                    $stmt->bind_result($db_password, $full_name);
                                    $stmt->fetch();
                                    session_regenerate_id(true);
                                    $_SESSION['username'] = $username;
                                    $_SESSION['full_name'] = $full_name;
                                    header("Location: manage.php");
                                    exit;  
                                } else {
                                    $error = "⚠️ Invalid username or password!";
                                    $attempts++;
                                }
                                $stmt->close();
                            }
                        }
                    }
                </code>
            </dd>
            <br>
            <dt>
                Account Lockout After Multiple Failed Login Attempts
                <a id="a-color1" href="login.php">[View Here]</a>
            </dt>
            <dd>
                <p>Temporarily disable user access for 60 seconds after a specified number of consecutive failed login attempts to prevent unauthorized access</p>
                <code class="css-code" id="code-color1">
                    $attempts = 0;
                    $last_attempt = null;

                    if ($attempts >= 3 && (time() - strtotime($last_attempt)) < $lockout_time) {
                        $error = "⏳ Too many failed attempts! Try again later after 60s.";
                    }

                    $stmt = $conn->prepare("DELETE FROM login_attempts WHERE username = ?");
                    $stmt->bind_param("s", $username);
                    $stmt->execute();

                    $stmt = $conn->prepare("INSERT INTO login_attempts (username, attempts, last_attempt) VALUES (?, ?, NOW()) 
                    ON DUPLICATE KEY UPDATE attempts = attempts + 1, last_attempt = NOW()");
                    $stmt->bind_param("si", $username, $attempts);
                    $stmt->execute();
                </code>
            </dd>
        </dl>
    </div>
    
    <?php include 'footer.inc'; ?>
</body>
</html>
