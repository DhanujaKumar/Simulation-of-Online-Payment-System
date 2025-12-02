<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardHolder = $_POST['card-holder'];
    $cardNumber = $_POST['card-number'];
    $expiryDate = $_POST['expiry-date'];
    $cvv = $_POST['cvv'];
    $amt = $_POST['amt']; // Fetching amount from form data

    // Connect to the database
    $con = mysqli_connect("localhost", "root", "Dhanuja", "payment");

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Escape input to prevent SQL injection
    $sql = "SELECT * FROM credit WHERE card_holder = ? AND card_number = ? AND expiry_date = ? AND cvv = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $cardHolder, $cardNumber, $expiryDate, $cvv);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if card details are found
    if ($result && $result->num_rows > 0) {
        // Card details are valid, generate OTP
        $otp = rand(100000, 999999); // Generate a 6-digit OTP

        // Store OTP and card details in session
        $_SESSION['otp'] = $otp;
        $_SESSION['card-holder'] = $cardHolder;
        $_SESSION['card-number'] = $cardNumber;
        $_SESSION['expiry-date'] = $expiryDate;
        $_SESSION['cvv'] = $cvv;
        $_SESSION['amt'] = $amt;

        // Display OTP (for testing purposes)
        // In real-world, send OTP via email/SMS
        echo '
        <form id="pinForm" method="post" action="otp_check.php">
            <div class="input-container">
                <label for="pin">Enter OTP:</label><br>
                <input type="number" id="otp" name="otp" required><br><br>
                
                <input type="hidden" name="card-holder" value="' . htmlspecialchars($cardHolder) . '">
                <input type="hidden" name="card-number" value="' . htmlspecialchars($cardNumber) . '">
                <input type="hidden" name="expiry-date" value="' . htmlspecialchars($expiryDate) . '">
                <input type="hidden" name="cvv" value="' . htmlspecialchars($cvv) . '">
                <input type="hidden" name="amt" value="' . htmlspecialchars($amt) . '">
                
                <input type="submit" name="submit" value="Submit OTP">
            </div>
        </form>
        <p>Your OTP is: ' . $otp . '</p>
        ';
    } else {
        // Invalid card details
        echo "<p>Invalid User. Please check and try again.</p>";
    }

    // Close the database connection
    mysqli_close($con);
}
?>