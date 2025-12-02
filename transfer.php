<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Transfer Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            overflow: hidden; /* Optional: Hide overflow to ensure container is centered */
        }

        .form-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 100%;
            max-width: 600px;
            box-sizing: border-box; /* Ensure padding is included in width calculation */
        }

        .heading {
            text-align: center;
            font-size: 1.8em;
            color: #333;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: linear-gradient(90deg, #007bff, #0056b3);
            -webkit-background-clip: text;
            color: transparent;
        }

        .form-row {
            display: flex;
            flex-direction: column;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #007bff;
            outline: none;
        }

        button {
            display: block;
            width: 100%;
            padding: 10px;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            font-size: 1em;
        }

        #submitBtn {
            background: linear-gradient(90deg, #28a745, #218838);
        }

        #submitBtn:hover {
            background: linear-gradient(90deg, #218838, #1a6f31);
        }

        #backBtn {
            background: linear-gradient(90deg, #ffc107, #e0a800);
        }

        #backBtn:hover {
            background: linear-gradient(90deg, #e0a800, #c69500);
        }
    </style>
</head>
<body>

    <div class="form-container">
        <div class="heading">Bank Transfer</div>
        <form id="bankTransferForm" action="store_transfer.php" method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="senderAccountNo">Sender Account Number</label>
                    <input type="text" id="senderAccountNo" name="senderAccountNo" readonly>
                </div>
                <div class="form-group">
                    <label for="receiverAccountNo">Receiver Account Number</label>
                    <input type="text" id="receiverAccountNo" name="receiverAccountNo" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount to be Paid</label>
                    <input type="number" id="amount" name="amount" required>
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <input type="text" id="remarks" name="remarks">
                </div>
                <button type="submit" id="submitBtn">Submit</button>
                <button type="button" id="backBtn" onclick="window.location.href='main.html'">Back to Main</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const usernameInput = document.getElementById("username");
            const senderAccountNoInput = document.getElementById("senderAccountNo");

            usernameInput.addEventListener("blur", function() {
                const username = usernameInput.value;

                if (username) {
                    fetch('get_account_number.php?username=' + encodeURIComponent(username))
                        .then(response => response.json())
                        .then(data => {
                            if (data.account_number) {
                                senderAccountNoInput.value = data.account_number;
                            } else {
                                senderAccountNoInput.value = '';
                                alert('Account number not found for the provided username.');
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching account number:', error);
                        });
                }
            });
        });
    </script>
</body>
</html>






