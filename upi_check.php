<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $send_upi = $_POST['send_upi'];
    $rev_upi = $_POST['rev_upi'];
    $amt = $_POST['amt']; // Fetching amount from form data
    
    // Connect to the database
    $con = mysqli_connect("localhost", "root", "Dhanuja", "payment");

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Escape input to prevent SQL injection
    $send_upi = mysqli_real_escape_string($con, $send_upi);
    $rev_upi = mysqli_real_escape_string($con, $rev_upi);
    
    // Query to check if sender UPI ID exists
    $sql_sender = "SELECT * FROM upi_details WHERE upi_id = '$send_upi'";
    $result_sender = mysqli_query($con, $sql_sender);

    // Query to check if receiver UPI ID exists
    $sql_receiver = "SELECT * FROM reciever_upi WHERE rev_upi = '$rev_upi'";
    $result_receiver = mysqli_query($con, $sql_receiver);
    
    // Check if both UPI IDs are found
    if (mysqli_num_rows($result_sender) > 0 && mysqli_num_rows($result_receiver) > 0) {
        // Both UPI IDs are valid, prepare the PIN entry form HTML
        session_start();
        $_SESSION['send_upi'] = $send_upi;
        $_SESSION['rev_upi'] = $rev_upi;
        $_SESSION['amt'] = $amt;
        $response = '
        <form id="pinForm" method="post" action="pin_check.php">
            <div class="input-container">
                <label for="pin">Enter PIN:</label><br>
                <input type="password" id="pin" name="pin" required><br><br>
                
                <div class="buttons">
                    <input type="submit" value="PROCEED">
                </div>
            </div>
        </form>
        ';
    } else {
        // Either sender or receiver UPI ID is not found
        $response = "<p>Invalid sender or receiver UPI ID. Please check and try again.</p>";
    }
    
    // Close the database connection
    mysqli_close($con);
    
    // Echo the response
    echo $response;
}
?>
