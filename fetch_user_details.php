<?php
session_start();

// Check if username is in the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

    // Database connection
    $conn = mysqli_connect("localhost", "root", "Dhanuja", "payment");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to fetch user details
    $fetch_user_query = "SELECT * FROM registration WHERE username = ?";
    $stmt = $conn->prepare($fetch_user_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch user details
        $user = $result->fetch_assoc();

        // Prepare user details as JSON response
        $response = array(
            'success' => true,
            'username' => $user['username'],
            'name' => $user['name'],
            'age' => $user['age'],
            'city' => $user['city'],
            'address' => $user['address'],
            'dob' => $user['dob'],
            'pincode' => $user['pincode'],
            'country' => $user['country'],
            'bank_name' => $user['bank_name'],
            'account_number' => $user['account_number'],
            'card_number' => $user['card_number'],
            'cvv' => $user['cvv'],
            'expiry_date' => $user['expiry_date'],
            'upi_id' => $user['upi_id'],
            'upi_phone' => $user['upi_phone'],
            'cif' => $user['cif'],
            'ifsc' => $user['ifsc'],
            'net_banking_pin' => $user['net_banking_pin'],
            'amount' => $user['amount']
        );

        // Return user details as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Username not provided']);
}
?>
