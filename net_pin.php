<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Process</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>

<?php
if (isset($_POST['submit'])) {
    $pin = $_POST['pin'];
    $send_acc = $_POST['send_acc'];
    $rev_acc = $_POST['rev_acc'];
    $amount = $_POST['amount'];
    
    $con = new mysqli("localhost", "root", "Dhanuja", "payment");

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    $stmt = $con->prepare("SELECT * FROM netbank_sender WHERE send_acc = ? AND pin = ?");
    $stmt->bind_param("ss", $send_acc, $pin);
    $stmt->execute();
    $result = $stmt->get_result();

    $transactionId = strtoupper(bin2hex(random_bytes(8)));

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $current_balance = $row['amount'];
        $new_balance = $current_balance - $amount;

        if ($new_balance >= 0) {
            $update_sender_sql = "UPDATE netbank_sender SET amount = ? WHERE send_acc = ?";
            $update_stmt = $con->prepare($update_sender_sql);
            $update_stmt->bind_param("ds", $new_balance, $send_acc);
            $update_stmt->execute();

            $update_receiver_sql = "UPDATE netbank_sender SET amount = amount + ? WHERE send_acc = ?";
            $update_stmt = $con->prepare($update_receiver_sql);
            $update_stmt->bind_param("ds", $amount, $rev_acc);

            if ($update_stmt->execute()) {
                $response = "Transaction successful. New balance: $new_balance";
                $status = 'Success';

                // Insert transaction details into the transaction_history table
                $insertSql = "INSERT INTO transaction_history (transaction_id, sender_account, receiver_account, amount, status) VALUES (?, ?, ?, ?, ?)";
                $stmt = $con->prepare($insertSql);
                $stmt->bind_param("ssssd", $transactionId, $send_acc, $rev_acc, $amount, $status);
                $stmt->execute();
              
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '" . addslashes($response) . " Transaction ID: $transactionId',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'payment.html';
                    }
                });
                </script>";
            } else {
                $response = "Error updating balance: " . $con->error;
                $status = 'Error';

                // Insert transaction details into the transaction_history table
                $insertSql = "INSERT INTO transaction_history (transaction_id, sender_account, receiver_account, amount, status) VALUES (?, ?, ?, ?, ?)";
                $stmt = $con->prepare($insertSql);
                $stmt->bind_param("ssssd", $transactionId, $send_acc, $rev_acc, $amount, $status);
                $stmt->execute();

                echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '" . addslashes($response) . " Transaction ID: $transactionId',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'payment.html';
                    }
                });
                </script>";
            }
        } else {
            $response = "Insufficient balance. Current balance: $current_balance";
            $status = 'Insufficient Balance';

            // Insert transaction details into the transaction_history table
            $insertSql = "INSERT INTO transaction_history (transaction_id, sender_account, receiver_account, amount, status) VALUES (?, ?, ?, ?, ?)";
            $stmt = $con->prepare($insertSql);
            $stmt->bind_param("ssssd", $transactionId, $send_acc, $rev_acc, $amount, $status);
            $stmt->execute();

            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '" . addslashes($response) . " Transaction ID: $transactionId',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'payment.html';
                }
            });
            </script>";
        }
    } else {
        $response = "Invalid PIN for sender account: $send_acc";
        $status = 'Invalid PIN';

        // Insert transaction details into the transaction_history table
        $insertSql = "INSERT INTO transaction_history (transaction_id, sender_account, receiver_account, amount, status) VALUES (?, ?, ?, ?, ?)";
        $stmt = $con->prepare($insertSql);
        $stmt->bind_param("ssssd", $transactionId, $send_acc, $rev_acc, $amount, $status);
        $stmt->execute();

        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '" . addslashes($response) . " Transaction ID: $transactionId',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'payment.html';
            }
        });
        </script>";
    }

    $stmt->close();
    $con->close();
}
?>

</body>
</html>
