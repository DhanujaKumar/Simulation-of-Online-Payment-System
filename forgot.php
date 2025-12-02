<?php
session_start();

function openConnection() {
    $servername = "localhost";
    $username = "root"; // Replace with your database username
    $password = "Dhanuja"; // Replace with your database password
    $dbname = "payment"; // Replace with your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

$conn = openConnection();

function generateCaptcha() {
    return rand(1000, 9999);
}

function generateOTP() {
    return rand(10000, 99999); 
}

// Function to regenerate OTP and update session
function regenerateOTP() {
    $_SESSION['otp'] = generateOTP();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['username_submit'])) {
        $username = $_POST['username'];
        
        $stmt = $conn->prepare("SELECT id FROM registration WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['username'] = $username;
            $_SESSION['captcha'] = generateCaptcha();
            header("Location: forgot.php?step=verify_captcha");
            exit;
        } else {
            $error_message = "Username not found";
        }
    } elseif (isset($_POST['captcha_submit'])) {
        $user_captcha = $_POST['captcha_input'];
        $generated_captcha = $_SESSION['captcha'];

        if ($user_captcha == $generated_captcha) {
            $_SESSION['otp'] = generateOTP();
            header("Location: forgot.php?step=verify_otp");
            exit;
        } else {
            $error_message = "CAPTCHA verification failed";
        }
    } elseif (isset($_POST['otp_submit'])) {
        $user_otp = $_POST['otp_input'];
        $generated_otp = $_SESSION['otp'];

        if ($user_otp == $generated_otp) {
            header("Location: forgot.php?step=reset_password");
            exit;
        } else {
            $error_message = "OTP verification failed";
        }
    } elseif (isset($_POST['password_submit'])) {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        $username = $_SESSION['username'];

        if ($new_password === $confirm_password) {
            // Update the user's password in the database (hashed password)
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("UPDATE registration SET password = ? WHERE username = ?");
            $stmt->bind_param("ss", $hashed_password, $username);
            $stmt->execute();

            echo "<script>alert('Password updated successfully!');</script>";
            header("Location: user_login.php"); // Redirect to user_login.php after password update
            exit;
        } else {
            $error_message = "Passwords do not match";
        }
    } elseif (isset($_POST['resend_otp'])) {
        regenerateOTP(); // Regenerate OTP
        header("Location: forgot.php?step=verify_otp"); // Redirect back to OTP verification step
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background: #4cae4c;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
        .captcha-display {
            position: relative;
            width: 200px;
            height: 80px;
            margin: 20px auto;
            background: url('doc.jpg') no-repeat center center;
            background-size: cover;
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            color: transparent;
            -webkit-text-stroke: 1px black;
        }
        .otp-notification {
            display: none;
            padding: 10px;
            background: #dff0d8;
            border: 1px solid #d6e9c6;
            border-radius: 5px;
            margin-top: 10px;
        }
        .otp-notification.show {
            display: block;
        }
        .otp-notification span {
            font-weight: bold;
        }
        .otp-buttons {
            margin-top: 10px;
        }
        .otp-buttons button {
            margin-right: 5px;
        }
    </style>
    <script>
        function dismissNotification() {
            document.getElementById('otp-notification').classList.remove('show');
        }
    </script>
</head>
<body>
    <div class="container">
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <?php if (!isset($_GET['step'])): ?>
            <h1>Forgot Password</h1>
            <form method="post">
                <input type="text" name="username" placeholder="Enter your username" required>
                <button type="submit" name="username_submit">Submit</button>
            </form>
        <?php elseif ($_GET['step'] == 'verify_captcha'): ?>
            <!-- Step 2: CAPTCHA -->
            <h1>Verify CAPTCHA</h1>
            <div class="captcha-display"><?php echo $_SESSION['captcha']; ?></div>
            <form method="post">
                <input type="text" name="captcha_input" placeholder="Enter the CAPTCHA" required>
                <button type="submit" name="captcha_submit">Verify</button>
            </form>
        <?php elseif ($_GET['step'] == 'verify_otp'): ?>
            <!-- Step 3: OTP -->
            <h1>Verify OTP</h1>
            <form method="post">
                <input type="text" name="otp_input" placeholder="Enter the OTP" required>
                <button type="submit" name="otp_submit">Verify</button>
            </form>
            <div id="otp-notification" class="otp-notification show">
                <p>Your OTP is: <span id="otp"><?php echo $_SESSION['otp']; ?></span></p>
                <div class="otp-buttons">
                    <form method="post">
                        <button type="submit" name="resend_otp">Resend</button>
                    </form>
                    <button type="button" onclick="dismissNotification()">Dismiss</button>
                </div>
            </div>
        <?php elseif ($_GET['step'] == 'reset_password'): ?>
            <!-- Step 4: Reset Password -->
            <h1>Reset Password</h1>
            <form method="post">
                <input type="password" name="new_password" placeholder="New Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit" name="password_submit">Update Password</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
