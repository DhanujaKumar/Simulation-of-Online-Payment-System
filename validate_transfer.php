<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter PIN</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container input {
            margin-bottom: 10px;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .container button {
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="pinForm" onsubmit="return handleSubmit(event);">
            <label for="pin">Enter your PIN:</label>
            <input type="password" id="pin" name="pin" placeholder="Enter PIN" required>
            <button type="submit">Proceed</button>
        </form>
    </div>

    <script>
        function handleSubmit(event) {
            event.preventDefault(); // Prevent the default form submission

            // Show the success alert
            window.alert('Transfer Success');

            // Redirect to validate.php
            window.location.href = 'history.php';

            return false; // Prevent the form from submitting normally
        }
    </script>
</body>
</html>
