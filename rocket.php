<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "aanirudh_02";
$dbname = "payment";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form inputs from previous page
$senderUsername = $_POST['formUsername'];
$senderAccountNumber = $_POST['formAccountNumber'];
$formAmount = $_POST['formAmount'];
$newBalance = $_POST['newBalance'];

// Get receiver details
$receiverUsername = $_POST['receiverUsername'];
$receiverAccountNumber = $_POST['receiverAccountNumber'];

// Prepare SQL statement to check receiver details
$sqlReceiver = "SELECT * FROM credit WHERE account_number = ?";
$stmtReceiver = $conn->prepare($sqlReceiver);
$stmtReceiver->bind_param("s", $receiverAccountNumber);
$stmtReceiver->execute();
$resultReceiver = $stmtReceiver->get_result();

if ($resultReceiver->num_rows === 0) {
    echo "
        <div id='notification' style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                     width: 300px; background: #fff; padding: 20px; border-radius: 8px;
                     box-shadow: 0 0 15px rgba(0, 0, 0, 0.2); text-align: center; z-index: 1000;'>
            <h2 style='color: #ff4d4d;'>Verification Failed</h2>
            <p style='color: #333;'>Invalid receiver account number.</p>
            <button onclick='window.location.href=\"transfer.php\";' style='background: #ff4d4d; color: #fff; border: none; 
                    padding: 10px; border-radius: 5px; cursor: pointer;'>Close</button>
        </div>
    ";
    $stmtReceiver->close();
    $conn->close();
    exit();
}

// Update sender's and receiver's balance
$sqlUpdateSender = "UPDATE credit SET amount = ? WHERE account_number = ?";
$stmtUpdateSender = $conn->prepare($sqlUpdateSender);
$stmtUpdateSender->bind_param("ds", $newBalance, $senderAccountNumber);
$stmtUpdateSender->execute();

$sqlUpdateReceiver = "UPDATE credit SET amount = amount + ? WHERE account_number = ?";
$stmtUpdateReceiver = $conn->prepare($sqlUpdateReceiver);
$stmtUpdateReceiver->bind_param("ds", $formAmount, $receiverAccountNumber);
$stmtUpdateReceiver->execute();

// Close statements
$stmtUpdateSender->close();
$stmtUpdateReceiver->close();

// Retrieve updated balance for sender
$sqlSenderBalance = "SELECT amount FROM credit WHERE account_number = ?";
$stmtSenderBalance = $conn->prepare($sqlSenderBalance);
$stmtSenderBalance->bind_param("s", $senderAccountNumber);
$stmtSenderBalance->execute();
$resultSenderBalance = $stmtSenderBalance->get_result();
$rowSender = $resultSenderBalance->fetch_assoc();
$updatedSenderBalance = $rowSender['amount'];

$stmtSenderBalance->close();

// Display success message with unique style
echo "
    <div id='notification' style='position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                 width: 400px; background: #fff; padding: 20px; border-radius: 12px; 
                 box-shadow: 0 0 20px rgba(0, 0, 0, 0.3); text-align: center; z-index: 1000;'>
        <img src='sucess.png' alt='Success' style='width: 80px; height: 80px; border-radius: 50%; margin-bottom: 15px;'>
        <h2 style='color: #28a745;'>Transfer Successful</h2>
        <p style='color: #333;'>An amount of Rs $formAmount has been transferred from $senderUsername to $receiverUsername.</p>
        <p style='color: #333;'>The remaining balance in $senderUsername is Rs $updatedSenderBalance.</p>
        <button onclick='window.location.href=\"transfer.php\";' style='background: #28a745; color: #fff; border: none; 
                padding: 10px 20px; border-radius: 5px; cursor: pointer;'>Close</button>
    </div>
";

// Close the connection
$conn->close();
?>
