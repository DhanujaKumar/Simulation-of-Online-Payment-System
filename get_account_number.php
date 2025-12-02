<?php
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

if (isset($_GET['username'])) {
    $username = $conn->real_escape_string($_GET['username']);
    
    $sql = "SELECT account_number FROM registration WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($account_number);
    
    $response = array("account_number" => null);
    if ($stmt->fetch()) {
        $response["account_number"] = $account_number;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    
    $stmt->close();
}

$conn->close();
?>
