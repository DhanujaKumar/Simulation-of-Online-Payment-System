<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $enteredPin = $_POST['pin'];
    $send_upi = $_SESSION['send_upi'];
    $rev_upi = $_SESSION['rev_upi'];
    $amt = $_SESSION['amt'];

    // Establish database connection
    $con = mysqli_connect("localhost", "root", "Dhanuja", "payment");

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare SQL statement to retrieve sender's UPI details
    $sql = "SELECT * FROM upi_details WHERE upi_id = ? AND pin = ?";
    
    // Create a prepared statement
    $stmt = mysqli_prepare($con, $sql);
    
    // Bind parameters to the prepared statement
    mysqli_stmt_bind_param($stmt, "ss", $send_upi, $enteredPin);
    
    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    
    // Get result set
    $result = mysqli_stmt_get_result($stmt);

    // Check if there is a row with matching UPI ID and PIN
    if ($row = mysqli_fetch_assoc($result)) {
        // PIN is correct, proceed with transaction
        $current_balance = $row['balance'];
        $new_balance = $current_balance - $amt;

        if ($new_balance >= 0) {
            // Update balance for sender's UPI ID
            $update_sql = "UPDATE upi_details SET balance = $new_balance WHERE upi_id = '$send_upi'";
            if (mysqli_query($con, $update_sql)) {
                // Insert transaction details
                $insert_sql = "INSERT INTO upi_transact (sender_upi, reciever_upi, amount, trans_date) VALUES ('$send_upi', '$rev_upi', $amt, NOW())";
                if (mysqli_query($con, $insert_sql)) {
                    // Insert into all_transactions table
                    $all_trans_sql = "INSERT INTO all_transactions (sender_upi, receiver_upi, amount, transaction_date, status) VALUES ('$send_upi', '$rev_upi', $amt, NOW(), 'Success')";
                    mysqli_query($con, $all_trans_sql);

                    // Transaction and balance update successful
                    $response = "Transaction successful. New balance: $new_balance";

                    // Display success message using SweetAlert
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
                                text: "' . addslashes($response) . '"
                            }).then(function() {
                                window.location.href = "payment.html"; // Redirect to success page
                            });
                        </script>
                    </body>
                    </html>
                    ';
                } else {
                    // Error inserting transaction details
                    $response = "Error inserting transaction details: " . mysqli_error($con);

                    // Insert into all_transactions table with error status
                    $all_trans_sql = "INSERT INTO all_transactions (sender_upi, receiver_upi, amount, transaction_date, status) VALUES ('$send_upi', '$rev_upi', $amt, NOW(), 'Error Inserting Transaction Details')";
                    mysqli_query($con, $all_trans_sql);

                    // Display error message using SweetAlert
                    echo '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Payment Error</title>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    </head>
                    <body>
                        <script>
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "' . addslashes($response) . '"
                            }).then(function() {
                                window.location.href = "payment.html"; // Redirect to error page
                            });
                        </script>
                    </body>
                    </html>
                    ';
                }
            } else {
                // Error updating balance
                $response = "Error updating balance: " . mysqli_error($con);

                // Insert into all_transactions table with error status
                $all_trans_sql = "INSERT INTO all_transactions (sender_upi, receiver_upi, amount, transaction_date, status) VALUES ('$send_upi', '$rev_upi', $amt, NOW(), 'Error Updating Balance')";
                mysqli_query($con, $all_trans_sql);

                // Display error message using SweetAlert
                echo '
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Payment Error</title>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "' . addslashes($response) . '"
                        }).then(function() {
                            window.location.href = "payment.html"; // Redirect to error page
                        });
                    </script>
                </body>
                </html>
                ';
            }
        } else {
            // Insufficient balance
            $response = "Insufficient balance. Current balance: $current_balance";

            // Insert into all_transactions table with insufficient balance status
            $all_trans_sql = "INSERT INTO all_transactions (sender_upi, receiver_upi, amount, transaction_date, status) VALUES ('$send_upi', '$rev_upi', $amt, NOW(), 'Insufficient Balance')";
            mysqli_query($con, $all_trans_sql);

            // Display insufficient balance message using SweetAlert
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Payment Error</title>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: "' . addslashes($response) . '"
                    }).then(function() {
                        window.location.href = "payment.html"; // Redirect to error page
                    });
                </script>
            </body>
            </html>
            ';
        }
    } else {
        // Invalid PIN for sender's UPI ID
        $response = "Invalid PIN for sender's UPI ID: $send_upi";

        // Insert into all_transactions table with invalid PIN status
        $all_trans_sql = "INSERT INTO all_transactions (sender_upi, receiver_upi, amount, transaction_date, status) VALUES ('$send_upi', '$rev_upi', $amt, NOW(), 'Invalid PIN')";
        mysqli_query($con, $all_trans_sql);

        // Display invalid PIN message using SweetAlert
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Payment Error</title>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "' . addslashes($response) . '"
                }).then(function() {
                    window.location.href = "payment.html"; // Redirect to error page
                });
            </script>
        </body>
        </html>
        ';
    }

    // Close database connection
    mysqli_close($con);
}
?>
