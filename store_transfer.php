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

// Get form data
$user = $_POST['username'];
$senderAccountNo = $_POST['senderAccountNo'];
$receiverAccountNo = $_POST['receiverAccountNo'];
$amount = $_POST['amount'];
$remarks = $_POST['remarks'];

// Validate and sanitize inputs
$user = $conn->real_escape_string($user);
$senderAccountNo = $conn->real_escape_string($senderAccountNo);
$receiverAccountNo = $conn->real_escape_string($receiverAccountNo);
$amount = $conn->real_escape_string($amount);
$remarks = $conn->real_escape_string($remarks);

// Insert data into database
$sql = "INSERT INTO bank_transfers (username, sender_account_no, receiver_account_no, amount, remarks) 
        VALUES ('$user', '$senderAccountNo', '$receiverAccountNo', '$amount', '$remarks')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
    // Redirect to a success page or display a success message
    header("Location: validate_transfer.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
