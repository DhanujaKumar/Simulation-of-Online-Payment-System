<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "Dhanuja";
$dbname = "payment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $bankName = mysqli_real_escape_string($conn, $_POST['bankName']);
    $accountNumber = mysqli_real_escape_string($conn, $_POST['accountNumber']);
    $cardNumber = mysqli_real_escape_string($conn, $_POST['cardNumber']);
    $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
    $expiryDate = mysqli_real_escape_string($conn, $_POST['expiryDate']);
    $upiId = mysqli_real_escape_string($conn, $_POST['upiId']);
    $upiPhone = mysqli_real_escape_string($conn, $_POST['upiPhone']);
    $cif = mysqli_real_escape_string($conn, $_POST['cif']);
    $ifsc = mysqli_real_escape_string($conn, $_POST['ifsc']);
    $Pin = mysqli_real_escape_string($conn, $_POST['netBankingPin']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Assuming 'password' field is included in the form

    // Check if username already exists
    $checkUsernameSql = "SELECT * FROM registration WHERE username='$username'";
    $result = $conn->query($checkUsernameSql);

    if ($result->num_rows > 0) {
        // Username already exists
        echo json_encode(array('success' => false, 'message' => 'Username already exists'));
        $conn->close();
        exit;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Generate random 4-digit rounded number
    $amount = rand(1000, 9999);

    // Insert into registration table
    $sql = "INSERT INTO registration (username, password, name, age, city, address, dob, pincode, country, bank_name, account_number, card_number, cvv, expiry_date, upi_id, upi_phone, cif, ifsc, net_banking_pin, amount)
            VALUES ('$username', '$hashed_password', '$name', '$age', '$city', '$address', '$dob', '$pincode', '$country', '$bankName', '$accountNumber', '$cardNumber', '$cvv', '$expiryDate', '$upiId', '$upiPhone', '$cif', '$ifsc', '$Pin', '$amount')";

    if ($conn->query($sql) === TRUE) {
        // Registration successful, now insert UPI details
        $insertUpiSql = "INSERT INTO upi_details (upi_id, phn_num, balance, pin) VALUES ('$upiId', '$upiPhone', '$amount', '$Pin')";
        
        if ($conn->query($insertUpiSql) === TRUE) {
            // UPI details inserted successfully, now insert net banking details
            $insertNetbankingSql = "INSERT INTO netbank_sender (send_acc, pin, amount) VALUES ('$accountNumber', '$Pin', '$amount')";
            
            if ($conn->query($insertNetbankingSql) === TRUE) {
                // Net banking details inserted successfully
                $conn->close();

                // Redirect to main.html using JavaScript after a delay
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "main.html";
                        }, 1000); // 1000 milliseconds delay before redirecting
                      </script>';
                exit;
            } else {
                // Net banking details insertion failed
                $conn->close();
                echo json_encode(array('success' => false, 'message' => 'Error inserting net banking details: ' . $conn->error));
                exit;
            }
        } else {
            // UPI details insertion failed
            $conn->close();
            echo json_encode(array('success' => false, 'message' => 'Error inserting UPI details: ' . $conn->error));
            exit;
        }
    } else {
        // Registration failed
        $conn->close();
        // Send response as JSON
        echo json_encode(array('success' => false, 'message' => 'Error: ' . $sql . '<br>' . $conn->error));
        exit;
    }
}
?>