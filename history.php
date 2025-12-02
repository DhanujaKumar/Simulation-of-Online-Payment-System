<?php
// Start the session
session_start();

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

// Get the username from the query parameter or session variable
$user = isset($_GET['username']) ? $_GET['username'] : (isset($_SESSION['username']) ? $_SESSION['username'] : '');

// Validate and sanitize the input
$user = $conn->real_escape_string($user);

if (!empty($user)) {
    // Prepare and execute the query
    $sql = "SELECT sender_account_no, receiver_account_no, amount, remarks, transfer_date 
            FROM bank_transfers 
            WHERE username = ? 
            ORDER BY transfer_date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any transactions
    if ($result->num_rows > 0) {
        echo "<h2>Transaction History for Username: " . htmlspecialchars($user) . "</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Sender Account No</th>
                    <th>Receiver Account No</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th>Transfer Date</th>
                </tr>";

        // Fetch and display the transactions
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['sender_account_no']) . "</td>
                    <td>" . htmlspecialchars($row['receiver_account_no']) . "</td>
                    <td>" . htmlspecialchars($row['amount']) . "</td>
                    <td>" . htmlspecialchars($row['remarks']) . "</td>
                    <td>" . htmlspecialchars($row['transfer_date']) . "</td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No transactions found for the username: " . htmlspecialchars($user) . "</p>";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "<p>Please provide a username to view the transaction history.</p>";
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
	 button {
            display: block;
            width: 10%;
            padding: 10px;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 500px;
            font-size: 1em;
        }

        #backBtn {
background: linear-gradient(90deg, #28a745, #218838);        }

        #backBtn:hover {
background: linear-gradient(90deg, #28a745, #218838);        }

    </style>
</head>
<body>

 <button type="button" id="backBtn" onclick="window.location.href='transfer.php'">Back to Main</button>

<?php
// Output the transaction history table here
?>
</body>
</html>
