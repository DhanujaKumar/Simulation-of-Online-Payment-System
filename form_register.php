<!DOCTYPE html>
<html>
<head>
    <title>Online Banking</title>
    <!-- Include SweetAlert CSS and JS files -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            position:relative;
            top:450px;
            height:1500px;
            background-color: #ffffff;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            width: 500%;
            max-width: 800px;
        }
        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
            background: #E5B966;
            padding: 10px;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #007BFF;
            outline: none;
        }
        .form-group input[type="submit"], .form-group button {
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
            padding: 12px 0;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
            width: 100%;
        }
        .form-group input[type="submit"]:hover, .form-group button:hover {
            background-color: #E5B966;
            color: #4D4D00;
        }
        .form-row {
            display: flex;
            gap: 10px;
        }
        .form-row .form-group {
            flex: 1;
        }
        .hidden {
            display: none;
        }
        .dialog-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            visibility: hidden;
        }
        .dialog-box {
            position: relative;
            background: #5499C7;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #e9ecef;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }
        .notification {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            background: #f5f5fa;
            color: #000;
            padding: 10px 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
            visibility: hidden;
        }
        .notification button {
            background: #66E5A7;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        h3 {
            background-color: pink;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }
        h3:hover {
            color: green;
            background: #FFFFFF;
        }
        .error-message {
            color: red;
            font-size: 0.9em;
            display: none;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Registration Form</h2>
        <form id="registrationForm" action="process_registration.php" method="post" onsubmit="return validateForm()">
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                    <div class="error-message" id="nameError">Please enter your name.</div>
                </div>
                <div class="form-group">
                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" required>
                    <div class="error-message" id="ageError">You must be at least 18 years old.</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" required>
                    <div class="error-message" id="cityError">Please enter your city.</div>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" required>
                    <div class="error-message" id="addressError">Please enter your address.</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" id="dob" name="dob" required>
                    <div class="error-message" id="dobError">You must be at least 18 years old.</div>
                </div>
                <div class="form-group">
                    <label for="pincode">Pincode</label>
                    <input type="text" id="pincode" name="pincode" required>
                    <div class="error-message" id="pincodeError">Please enter your pincode.</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" id="country" name="country" required>
                    <div class="error-message" id="countryError">Please enter your country.</div>
                </div>
                <div class="form-group">
                    <label for="bankName">Bank Name</label>
                    <select id="bankName" name="bankName" required>
                        <option value="Indian Bank">Indian Bank</option>
                        <option value="Andhra Bank">Andhra Bank</option>
                        <option value="Canara Bank">Canara Bank</option>
                        <option value="State Bank">State Bank</option>
                    </select>
                    <div class="error-message" id="bankNameError">Please select your bank.</div>
                </div>
            </div>
            <div class="form-group">
                <label for="accountNumber">Account Number</label>
                <input type="text" id="accountNumber" name="accountNumber" required>
                <div class="error-message" id="accountNumberError">Account number should have exactly 10 alphanumeric characters.</div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                    <div class="error-message" id="usernameError">Please enter your username.</div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required minlength="8">
                    <div class="error-message" id="passwordError">Password must be at least 8 characters long.</div>
                </div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required minlength="8">
                <div class="error-message" id="confirmPasswordError">Passwords do not match.</div>
            </div>
            <div class="form-group">
                <label for="netBankingPin">PIN</label>
                <input type="password" id="netBankingPin" name="netBankingPin" required minlength="4" maxlength="4">
                <div class="error-message" id="pinError">PIN should be exactly 4 numeric characters.</div>
            </div>
<div id="creditCardDetails">
                <h3>Credit Card</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="cardNumber">Card Number</label>
                        <input type="text" id="cardNumber" name="cardNumber">
                    </div>
                    <div class="form-group">
                        <label for="cvv">CVV Code</label>
                        <input type="text" id="cvv" name="cvv">
                    </div>
                </div>
                <div class="form-group">
                    <label for="expiryDate">Expiry Date</label>
                    <input type="month" id="expiryDate" name="expiryDate">
                </div>
                            </div>
            <div id="upiDetails">
                <h3>UPI</h3>
                <div class="form-group">
                    <label for="upiId">UPI ID</label>
                    <input type="text" id="upiId" name="upiId">
                </div>
                <div class="form-group">
                    <label for="upiPhone">Phone Number</label>
                    <input type="text" id="upiPhone" name="upiPhone">
                </div>
               
            </div>
            <div id="netBankingDetails">
                <h3>Net Banking</h3>
                <div class="form-group">
                    <label for="cif">CIF</label>
                    <input type="text" id="cif" name="cif">
                </div>
                <div class="form-group">
                    <label for="ifsc">IFSC Code</label>
                    <input type="text" id="ifsc" name="ifsc">
                </div>
</div>
            <div class="form-group">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>

    <script>
        // Set the max date for Date of Birth to 18 years ago from today
        document.addEventListener("DOMContentLoaded", function() {
            const dobInput = document.getElementById('dob');
            const today = new Date();
            const maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());
            const maxDateString = maxDate.toISOString().split('T')[0];
            dobInput.setAttribute('max', maxDateString);
        });

        function validateForm() {
            let valid = true;

            // Validate Name
            const name = document.getElementById('name').value.trim();
            if (name === "") {
                document.getElementById('nameError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('nameError').style.display = 'none';
            }

            // Validate Age
const age = parseInt(document.getElementById('age').value, 10);
            if (isNaN(age) || age < 18) {
                document.getElementById('ageError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('ageError').style.display = 'none';
            }

            // Validate City
            const city = document.getElementById('city').value.trim();
            if (city === "") {
                document.getElementById('cityError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('cityError').style.display = 'none';
            }

            // Validate Address
            const address = document.getElementById('address').value.trim();
            if (address === "") {
                document.getElementById('addressError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('addressError').style.display = 'none';
            }

            // Validate Date of Birth
            const dob = new Date(document.getElementById('dob').value);
            const minDob = new Date();
            minDob.setFullYear(minDob.getFullYear() - 18);
            if (dob > minDob) {
                document.getElementById('dobError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('dobError').style.display = 'none';
            }

            // Validate Pincode
            const pincode = document.getElementById('pincode').value.trim();
            if (pincode === "") {
                document.getElementById('pincodeError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('pincodeError').style.display = 'none';
            }

            // Validate Country
            const country = document.getElementById('country').value.trim();
            if (country === "") {
                document.getElementById('countryError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('countryError').style.display = 'none';
            }

            // Validate Bank Name
            const bankName = document.getElementById('bankName').value;
            if (bankName === "") {
                document.getElementById('bankNameError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('bankNameError').style.display = 'none';
            }

            // Validate Account Number
            const accountNumber = document.getElementById('accountNumber').value.trim();
            const accountNumberPattern = /^[a-zA-Z0-9]{10}$/;
            if (!accountNumberPattern.test(accountNumber)) {
                document.getElementById('accountNumberError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('accountNumberError').style.display = 'none';
            }

            // Validate Username
            const username = document.getElementById('username').value.trim();
            if (username === "") {
                document.getElementById('usernameError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('usernameError').style.display = 'none';
            }

            // Validate Password
            const password = document.getElementById('password').value;
            if (password.length < 8) {
                document.getElementById('passwordError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('passwordError').style.display = 'none';
            }

            // Validate Confirm Password
            const confirmPassword = document.getElementById('confirmPassword').value;
            if (password !== confirmPassword) {
                document.getElementById('confirmPasswordError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('confirmPasswordError').style.display = 'none';
            }

            // Validate PIN
            const pin = document.getElementById('netBankingPin').value;
            const pinPattern = /^[0-9]{4}$/;
            if (!pinPattern.test(pin)) {
                document.getElementById('pinError').style.display = 'block';
                valid = false;
            } else {
                document.getElementById('pinError').style.display = 'none';
            }

            if (!valid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please correct the errors in the form before submitting.'
                });
            }

            return valid;
        }
    </script>
</body>
</html>
