<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link rel="stylesheet" href="paymentstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            text-align: center;
            padding: 20px;
        }
        .top-right {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .payment-button {
            background-color: black;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .payment-button:hover {
            background-color: #042944;
        }
        .content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
	    text-align: left;
            color: #333; /* Text color for user details */
        }
        #userDetails p {
            color: #555; /* Specific color for user details text */
            font-size: 16px;
        }
        #errorMessage {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="top-right">
        <button class="payment-button" onclick="window.location.href='payment.html'">Go to Payment</button>
    </div>

    <div class="content">
        <h2>User Details</h2>
        <div id="userDetails">
            <!-- User details will be loaded here -->
        </div>
        <div id="errorMessage"></div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch('fetch_user_details.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const userDetails = document.getElementById('userDetails');
                    userDetails.innerHTML = `
                        <p><strong>Username:</strong> ${data.username}</p>
                        <p><strong>Name:</strong> ${data.name}</p>
                        <p><strong>Age:</strong> ${data.age}</p>
                        <p><strong>City:</strong> ${data.city}</p>
                        <p><strong>Address:</strong> ${data.address}</p>
                        <p><strong>DOB:</strong> ${data.dob}</p>
                        <p><strong>Pincode:</strong> ${data.pincode}</p>
                        <p><strong>Country:</strong> ${data.country}</p>
                        <p><strong>Bank Name:</strong> ${data.bank_name}</p>
                        <p><strong>Account Number:</strong> ${data.account_number}</p>
                        <p><strong>Card Number:</strong> ${data.card_number}</p>
                        <p><strong>UPI ID:</strong> ${data.upi_id}</p>
                        <p><strong>UPI Phone:</strong> ${data.upi_phone}</p>
                        <p><strong>CIF:</strong> ${data.cif}</p>
                        <p><strong>IFSC:</strong> ${data.ifsc}</p>
                        <p><strong>Amount:</strong> ${data.amount}</p>
                    `;
                } else {
                    document.getElementById('errorMessage').textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('errorMessage').textContent = 'Failed to fetch details!';
            });
        });
    </script>
</body>
</html>
