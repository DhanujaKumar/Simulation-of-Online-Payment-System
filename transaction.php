<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
</head>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from form
    $uname = $_POST['username'];
    $psw = $_POST['password'];
    
    // Connect to the database
    $con = mysqli_connect("localhost", "root", "Dhanuja", "payment");

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Query to retrieve the hashed password for the given username
    $query = "SELECT password FROM registration WHERE username=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $uname);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if ($hashed_password) {
        // Verify the password
        if (password_verify($psw, $hashed_password)) {
            // Redirect to main.html if credentials match
            echo '<script>
                    window.location.href = "main.html";
                  </script>';
            exit();
        } else {
            // Display sweet alert for invalid username or password
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Invalid username or password."
                        }).then(function() {
                            window.location.href = "user_login.html";
                        });
                    });
                  </script>';
        }
    } else {
        // Display sweet alert for invalid username or password
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Invalid username or password."
                    }).then(function() {
                        window.location.href = "user_login.html";
                    });
                });
              </script>';
    }

    // Close statement and database connection
    $stmt->close();
    mysqli_close($con);
}
?>
</body>
</html>
