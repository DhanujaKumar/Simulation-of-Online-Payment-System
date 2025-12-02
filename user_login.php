<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <style>
        body {
            margin: 0;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 22px;
            color: #333;
            background-color: #f0f0f0;
            text-align: center;
        }
        .container {
            position: relative;
            top: 100px;
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
        }
        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 90%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 12px 20px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
        .new-account {
            margin-top: 10px;
            text-align: center;
        }
        .new-account a {
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
        }
        .forgot-password
        {
            margin-top: 10px;
            text-align: right;
            position: absolute; 
            top: 280px;
            right: 20px;
           
        }
     .forgot-password a {
    color: #ff4500;
    text-decoration: none;
    font-size: 16px;
    padding: 10px; /* Add padding for better appearance */
    border-radius: 4px; /* Optional: add rounded corners */
      }

.forgot-password a:hover {
    text-decoration: underline;
    background-color: initial; /* Reset background color */
}
        .top {
            height: 200px;
            background-color: #0f5a90;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="top">
        <h2>Online Payment</h2>
    </div>
    <div class="container">
        <h2>Login</h2>
        <form action="login_check.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Login">
            </div>
             <br>
            <div class="forgot-password">
                <br>
                <p><a href="forgot.php">Forgot Password?</a></p>
            </div>
        </form>
        <div class="new-account">
            <p>Don't have an account? <br><a href="form_register.php">Create New Account</a></p>
        </div>
    </div>
</body>
</html>
