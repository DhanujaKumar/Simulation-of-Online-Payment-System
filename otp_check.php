<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredOtp = $_POST['otp'];
    $sessionOtp = $_SESSION['otp'];

    $cardHolder = $_SESSION['card-holder'];
    $cardNumber = $_SESSION['card-number'];
    $expiryDate = $_SESSION['expiry-date'];
    $cvv = $_SESSION['cvv'];
    $amt = $_SESSION['amt']; // Amount to be deducted

    // Generate a random transaction ID
    $transactionId = strtoupper(bin2hex(random_bytes(8)));

    // Connect to the database
    $con = mysqli_connect("localhost", "root", "Dhanuja", "payment");

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Verify OTP
    if ($enteredOtp == $sessionOtp) {
        // OTP is correct, update the balance
        $updateSql = "UPDATE credit SET amount = amount - ? WHERE card_holder = ? AND card_number = ? AND expiry_date = ? AND cvv = ?";

        $stmt = $con->prepare($updateSql);
        $stmt->bind_param("dssss", $amt, $cardHolder, $cardNumber, $expiryDate, $cvv);

        if ($stmt->execute()) {
            // Fetch the updated balance
            $balanceSql = "SELECT amount FROM credit WHERE card_holder = ? AND card_number = ? AND expiry_date = ? AND cvv = ?";
            $stmt = $con->prepare($balanceSql);
            $stmt->bind_param("ssss", $cardHolder, $cardNumber, $expiryDate, $cvv);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $updatedBalance = $row['amount'];

                // Insert transaction details into the transactions table
                $insertSql = "INSERT INTO transactions (transaction_id, card_holder, card_number, expiry_date, cvv, amount) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $con->prepare($insertSql);
                $stmt->bind_param("sssssd", $transactionId, $cardHolder, $cardNumber, $expiryDate, $cvv, $amt);
                $stmt->execute();

                // Balance updated successfully, handle payment success
                echo '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Payment Success</title>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            icon: "success",
                            title: "Payment Successful",
                            text: "Your payment has been processed successfully. Your updated balance is ' . $updatedBalance . '. Transaction ID: ' . $transactionId . '"
                        }).then(function() {
                            window.location = "payment.html"; // Redirect to success page
                        });
                    </script>
                </body>
                </html>
                ';
            } else {
                // Error fetching updated balance
                echo "Error fetching updated balance: " . $con->error;
            }
        } else {
            // Error updating balance
            echo "Error updating balance: " . $con->error;
        }
    } else {
        // OTP is incorrect, handle failure
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Failed</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Payment Failed",
                    text: "Invalid OTP. Please try again. Transaction ID: ' . $transactionId . '"
                }).then(function() {
                    window.location = "payment.html"; // Redirect to retry page
                });
            </script>
        </body>
        </html>
        ';
    }

    // Close the database connection
    mysqli_close($con);
}
?>
