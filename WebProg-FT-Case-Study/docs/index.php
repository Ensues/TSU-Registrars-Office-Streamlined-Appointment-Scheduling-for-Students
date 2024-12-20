<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'booking_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            header("Location: booking-page.html");
            exit();
        } else {
            $alertMessage = "Invalid password.";
        }
    } else {
        $alertMessage = "No account found with that username.";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width,initial-scale=1.0">
        <title>Log In</title>
        <link rel="icon" type="image/x-icon" href="images/tsu-seal.png">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    </head>
    <body>
        <header class="header">
            <a href="#home" class="logo">
                <img src="images/tsu-seal.png"> TSU <span>Registrar</span>
            </a>
        </header>
        <section class="log-in">
            <div class="office-window-title"></div>
            <h2 class="office-window-title">Welcome to Tarlac State University Registrar</h2>
            <form method="POST">
                <div class="img-container">
                    <div class="login-wrapper">
                        <div class="input-box">
                            <h1 class="log-header">Log In</h1>
                            <input type="text" name="username" id="username" placeholder="Username" required>
                            <input type="password" name="password" id="password" placeholder="Password" required>
                            <button type="submit" class="btn">Log In</button>
                            <a href="signup.php" id="login-btn" class="btn bypass-btn guest-log-in">Sign Up</a>                       
                        </div>
                    </div>
                </div>
            </form>
        </section>

        <?php if (isset($alertMessage)) { ?>
            <script>
                alert("<?php echo $alertMessage; ?>");
            </script>
        <?php } ?>

        <script src="script.js"></script>
    </body>
</html>
