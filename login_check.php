<?php
session_start();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli("localhost", "root", "Dhanuja", "payment");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute query to fetch user credentials
    $query = "SELECT * FROM registration WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['username'] = $username;
            header("Location: main.html");
            exit();
        } else {
            // Invalid password
            echo "Invalid username or password";
        }
    } else {
        // Username not found
        echo "Invalid username or password";
    }

    $stmt->close();
    $conn->close();
}
?>
