<?php
// Initialize error variables
$username_error = '';
$email_error = '';
$password_error = '';
$db_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

    $valid = true;
    //  validations
    if (empty($username)) {
        $username_error = "Please enter your full name.";
        $valid = false;
    } elseif (!preg_match("/^[a-zA-Z ]{2,50}$/", $username)) {
        $username_error = "Name can only contain letters and spaces.";
        $valid = false;
    }
    if (empty($email)) {
        $email_error = "Please enter your email address.";
        $valid = false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Please enter a valid email address.";
        $valid = false;
    }
    if (empty($password)) {
        $password_error = "Please enter a password.";
        $valid = false;
    } 

    // db only if validation passes connection code
    if ($valid) {
        $conn = mysqli_connect('localhost', 'root', '');
        if (!$conn) {
            $db_error = "Connection failed: " . mysqli_connect_error();
        } else {
            // if not exist is used to create db if there is no such db
            $create_db = "CREATE DATABASE IF NOT EXISTS example";
            if (!mysqli_query($conn, $create_db)) {
                $db_error = "Error creating database: " . mysqli_error($conn);
            }
            mysqli_select_db($conn, 'example');
             //same as db to create table if not exist
            $create_table = "CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";

            if (!mysqli_query($conn, $create_table)) {
                $db_error = "Error creating table: " . mysqli_error($conn);
            }
            //emal verification since its unique key in db
            $check_email = "SELECT email FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $check_email);

            if (mysqli_num_rows($result) > 0) {
                $email_error = "This email is already registered.";
            } else {
                
                $insert_query = "INSERT INTO users (name, email, password) VALUES ('$username', '$email', '$password')";
                if (mysqli_query($conn, $insert_query)) {
                    mysqli_close($conn);
                    header('Location: login.php');
                    exit();
                } else {
                    $db_error = "Error registering user: " . mysqli_error($conn);
                }
            }
            mysqli_close($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f5f5f5;
            background-image: url(back2.webp);
            background-size: cover;
        }

        .form-box {
            max-width: 300px;
            background: #f1f7fe;
            overflow: hidden;
            border-radius: 16px;
            color: #010101;
        }

        .form {
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 32px 24px 24px;
            gap: 16px;
            text-align: center;
        }

        .title {
            font-weight: bold;
            font-size: 1.6rem;
        }

        .subtitle {
            font-size: 1rem;
            color: #666;
        }

        .form-container {
            overflow: hidden;
            border-radius: 8px;
            background-color: #fff;
            margin: 1rem 0 .5rem;
            width: 100%;
        }

        .input {
            background: none;
            border: 0;
            outline: 0;
            height: 40px;
            width: 100%;
            border-bottom: 1px solid #eee;
            font-size: .9rem;
            padding: 11px 3px;
        }

        .form-section {
            padding: 16px;
            font-size: .85rem;
            background-color: #e0ecfb;
            box-shadow: rgb(0 0 0 / 8%) 0 -1px;
        }

        .form-section a {
            font-weight: bold;
            color: #0066ff;
            transition: color .3s ease;
        }

        .form-section a:hover {
            color: #005ce6;
            text-decoration: underline;
        }

        .form button {
            background-color: #0066ff;
            color: #fff;
            border: 0;
            border-radius: 24px;
            padding: 10px 16px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color .3s ease;
        }

        .form button:hover {
            background-color: #005ce6;
        }

        .error {
            color: red;
            font-size: 0.8rem;
            display: block;
            margin-top: 5px;
            padding: 0 3px;
            text-align: left;
        }

        .input-group {
            position: relative;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <form class="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <span class="title">Sign up</span>
            <span class="subtitle">Create a free account with your email.</span>
            <div class="form-container">
                <div class="input-group">
                    <input type="text" 
                           class="input" 
                           name="username" 
                           placeholder="Full Name"
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                    <?php if (!empty($username_error)): ?>
                        <span class="error"><?php echo $username_error; ?></span>
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <input type="email" 
                           class="input" 
                           name="email" 
                           placeholder="Email"
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    <?php if (!empty($email_error)): ?>
                        <span class="error"><?php echo $email_error; ?></span>
                    <?php endif; ?>
                </div>

                <div class="input-group">
                    <input type="password" 
                           class="input" 
                           name="password" 
                           placeholder="Password">
                    <?php if (!empty($password_error)): ?>
                        <span class="error"><?php echo $password_error; ?></span>
                    <?php endif; ?>
                </div>

                <?php if (!empty($db_error)): ?>
                    <span class="error"><?php echo $db_error; ?></span>
                <?php endif; ?>
            </div>
            <button type="submit">Sign up</button>
        </form>
        <div class="form-section">
            <p>Have an account? <a href="login.php">Log in</a></p>
        </div>
    </div>
</body>
</html>