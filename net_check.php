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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $send_acc = $_POST['accountHolder'];
    $rev_acc = $_POST['receiverAccount'];
    $ifsc = $_POST['ifscCode'];
    $amount = $_POST['amount'];

    $con = mysqli_connect("localhost", "root", "Dhanuja", "payment");

    if (!$con) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Database Error',
            text: 'Unable to connect to the database.',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'payment.html';
            }
        });
        </script>";
        exit;
    }

    $send_acc = mysqli_real_escape_string($con, $send_acc);
    $rev_acc = mysqli_real_escape_string($con, $rev_acc);
    $ifsc = mysqli_real_escape_string($con, $ifsc);

    $sql_sender = "SELECT * FROM netbank_sender WHERE send_acc = '$send_acc'";
    $result_sender = mysqli_query($con, $sql_sender);

    if (!$result_sender) {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Query Error',
            text: 'Error checking sender account.',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'payment.html';
            }
        });
        </script>";
        mysqli_close($con);
        exit;
    }

    $row_sender = mysqli_fetch_assoc($result_sender);
    $sender_balance = $row_sender['amount'];

    if (mysqli_num_rows($result_sender) > 0 && $sender_balance >= $amount) {
        $sql_receiver = "SELECT * FROM netbank_rev WHERE rev_acc = '$rev_acc' AND ifsc = '$ifsc'";
        $result_receiver = mysqli_query($con, $sql_receiver);

        if (!$result_receiver) {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Query Error',
                text: 'Error checking receiver account.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'payment.html';
                }
            });
            </script>";
            mysqli_close($con);
            exit;
        }

        if (mysqli_num_rows($result_receiver) > 0) {
            echo '
            <form id="pinForm" method="post" action="net_pin.php">
                <div class="input-container">
                    <label for="pin">Enter PIN:</label><br>
                    <input type="password" id="pin" name="pin" maxlength="4" required><br><br>
                    
                    <input type="hidden" name="send_acc" value="' . htmlspecialchars($send_acc) . '">
                    <input type="hidden" name="rev_acc" value="' . htmlspecialchars($rev_acc) . '">
                    <input type="hidden" name="ifsc" value="' . htmlspecialchars($ifsc) . '">
                    <input type="hidden" name="amount" value="' . htmlspecialchars($amount) . '">
                    
                    <input type="submit" name="submit" value="Submit PIN">
                </div>
            </form>';
        } else {
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Account Error',
                text: 'Receiver account not found or invalid IFSC code.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'payment.html';
                }
            });
            </script>";
        }
    } else {
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Balance Error',
            text: 'Insufficient balance or sender account not found.',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'payment.html';
            }
        });
        </script>";
    }

    mysqli_close($con);
}
?>

</body>
</html>
