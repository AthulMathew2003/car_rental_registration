<?php
session_start();
// check if its admin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ($email === "admin" && $password === "admin") {
        $_SESSION['username'] = "ADMIN";
        header('Location: dashboard.php');
        exit();
    }
    $connection = mysqli_connect('localhost', 'root', '', 'example');
    
    if (!$connection) {
        die("Connection Failed: " . mysqli_connect_error());
    }
    // verification of info from the db
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) == 1) {
        mysqli_close($connection);
        $namefetch = mysqli_fetch_assoc($result);
        $_SESSION['name']= $namefetch['name'];
        header('Location: index.php');
        exit();
    } else {
        mysqli_close($connection);
        $error = "Invalid credential";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
    <div class="form-container">
        <p class="title">Welcome to Car Rentals</p>
        <form class="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            
            <input type="text" name="email" class="input" placeholder="Email" required>
            <input type="password" name="password" class="input" placeholder="Password" required>
            
            <p class="page-link">
                <span class="page-link-label">Forgot Password?</span>
            </p>
            <button type="submit" class="form-btn">Log in</button>
        </form>
        <p class="sign-up-label">
            Don't have an account? <span class="sign-up-link"><a href="signup.php">Sign up</a></span>
        </p>
    </div>
</body>
</html>