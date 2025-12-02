<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Centered Box Example</title>
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
  body, html {
    height: 100%;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Align items slightly above center */
    background-color: #f0f0f0; /* Background color for the entire page */
    font-family: Arial, sans-serif; /* Optional: Choose your preferred font */
  }

  .box {
    opacity: 0; /* Initially hide the box */
    height: 68%;
    width: 930px; /* Adjust width as needed */
    max-width: 95%; /* Limit maximum width for larger screens */
    background-color: #f0f0f0; /* Your preferred color */
    border: 3px solid pink;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    padding: 40px; /* Adjust padding to maintain proportions */
    margin-top: 50px; /* Adjust the margin to position the box above center */
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Space evenly within the box */
    position: relative;
    animation: fadeIn 1s ease-in-out 2s forwards; /* Fade-in animation after 2 seconds */
  }

  @keyframes fadeIn {
    from {
      opacity: 0;
    }
    to {
      opacity: 1;
    }
  }

  .forgot-password {
    animation: appear 1s forwards; /* Animation for appearing suddenly */
    margin-bottom: 20px;
  }

  hr {
    margin: 1px 0;
    border: none;
    border-top: 1px solid #ccc;
  }

  .box-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .box-content img {
    max-width: 45%; /* Adjust image size */
    border-radius: 8px; /* Rounded corners for image */
  }

  .box-content .content-text {
    text-align: left; /* Align text to the left */
    max-width: 50%; /* Adjust text width */
  }

  .buttons {
    display: flex;
    justify-content: flex-end;
    margin-top: 3px;
  }

  .button {
    padding: 8px 18px;
    margin-left: 10px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    font-size: 14px;
    font-weight: bold;
  }
  button:hover
  {
    background-color: red;
  }

  .blue-button {
    background-color: blue;
    color: white;
  }

  @keyframes appear {
    0% {
      opacity: 0;
    }
    100% {
      opacity: 1;
    }
  }

  /* Styling for harsh dialog box */
  .harsh-dialog-box {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff; /* White background */
    border: 2px solid #ccc; /* Light border */
    border-radius: 10px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    z-index: 1000; /* Ensure it's above other content */
    display: none; /* Initially hidden */
  }
  .close-button {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
  font-size: 20px;
  color: #333; /* Dark text color */
}

  .harsh-dialog-box img {
    max-width: 100%;
    border-radius: 50%; /* Rounded shape for the image */
  }

  .harsh-dialog-box p {
    font-style: italic;
    color: #333; /* Dark text color */
    font-size: larger;
    margin-top: 20px;
  }

  .harsh-dialog-box .button {
    margin-top: 20px;
    background-color: #333; /* Dark button background */
    color: #fff; /* White button text */
  }

  /* Flickering glow effect on body */
  
 /* Flickering glow effect on body */
@keyframes flicker {
  0% {
    box-shadow: 0 0 200px 100px red, 0 0 200px 100px brown, 0 0 20px 10px black;
  }
  50% {
    box-shadow: 0 0 200px 10px red, 0 1 20px 10px brown, 1 0 20px 10px black;
  }
  100% {
    box-shadow: none;
  }
  /* Extend duration to 15 seconds */
  animation-duration: 15s;
}

.body-flicker {
  animation: flicker 5s infinite;
}
  /* Styling for violet dialog box */
  .violet-dialog-box {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: violet;
    border: 2px solid #8a2be2; /* Violet border */
    border-radius: 10px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    z-index: 1000; /* Ensure it's above other content */
    display: none; /* Initially hidden */
  }

  .violet-dialog-box input {
    padding: 8px;
    margin-bottom: 10px;
    border-radius: 5px;
    border: 1px solid #8a2be2;
  }

  .violet-dialog-box .button {
    background-color: #8a2be2;
    color: white;
  }

  /* Styling for the popup box */
  .popup_box {
    width: 400px;
    background: #f2f2f2;
    text-align: center;
    align-items: center;
    padding: 40px;
    border: 1px solid #b3b3b3;
    box-shadow: 0px 5px 10px rgba(0,0,0,.2);
    z-index: 9999;
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  }
  .popup_box i {
    font-size: 60px;
    color: #eb9447;
    border: 5px solid #eb9447;
    padding: 20px 40px;
    border-radius: 50%;
    margin: -10px 0 20px 0;
  }
  .popup_box h1 {
    font-size: 30px;
    color: #1b2631;
    margin-bottom: 5px;
  }
  .popup_box label {
    font-size: 23px;
    color: #404040;
  }
  .popup_box .btns {
    margin: 40px 0 0 0;
  }
  .btns .btn1, .btns .btn2 {
    background: #999999;
    color: white;
    font-size: 18px;
    border-radius: 5px;
    border: 1px solid #808080;
    padding: 10px 13px;
  }
  .btns .btn2 {
    margin-left: 20px;
    background: #ff3333;
    border: 1px solid #cc0000;
  }
  .btns .btn1:hover {
    transition: .5s;
    background: #8c8c8c;
  }
  .btns .btn2:hover {
    transition: .5s;
    background: #e60000;
  }

  /* Styling for the notification dialog */
  .notification-dialog {
    width: 300px;
    background: #ffffff;
    text-align: center;
    padding: 20px;
    border: 1px solid #cccccc;
    box-shadow: 0px 5px 10px rgba(0,0,0,.2);
    z-index: 10000;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: none;
  }
  .notification-dialog p {
    font-size: 18px;
    color: #333333;
    margin-bottom: 10px;
  }
  .notification-dialog .button {
    background-color: #008cba;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
</style>
</head>
<body>
  <div class="box">
    <div class="forgot-password">
      <h3>Forgot password</h3>
      <p>You can reset your password.</p>
    </div>
    <hr>
    <div class="box-content">
      <img src="main.png" width="390px" height="320px" alt="Forgot Password Image">
      <div class="content-text">
        <h4>It's quite common to forget your password.</h4>
        <p>Many users have experienced it. But don't worry, we can help you overcome this struggle. Remember, your password is crucial. Do not share it with anyone.</p>
      </div>
    </div>
    <div class="buttons">
      <button class="button" onclick="location.href='forgot.php'">Try another way</button>
      <button class="button blue-button" onclick="showUsernameDialog()">Send notification</button>
    </div>
  </div>

  <!-- Harsh dialog box -->
<div class="harsh-dialog-box" id="harshDialogBox">
  <img src="cybu.png" alt="Warning Image" style="height: 200px;">
  <p><em>Be Aware!</em></p>
  <p>Someone is trying to hack your attempt. Make the required security steps.</p>
  <div class="buttons">
    <button class="button small-button" onclick="location.href='user_login.php'">OK</button>
  </div>
  <span class="close-button" onclick="hideHarshDialogBox()">&#10005;</span> <!-- Close button -->
</div>


  <!-- Violet dialog box -->
  <div class="violet-dialog-box" id="violetDialogBox">
    <h3>Enter your username</h3>
    <form method="post" action="">
      <input type="text" name="username" id="usernameInput" placeholder="Username" required>
      <button type="submit" class="button">Validate</button>
    </form>
  </div>

  <!-- Notification dialog -->
  <div class="notification-dialog" id="notificationDialog">
    <p>A notification has been sent to <span id="usernameSpan"></span>.</p>
    <button class="button" onclick="hideNotificationDialog(); showPopupBox();">OK</button>
  </div>

  <!-- Popup box -->
<div class="popup_box" id="popupBox">
  <img src="circle.png" alt="Verification Image" style="width: 100px; height: 100px; border-radius: 50%;">
  <h1>Verify whether it's you!</h1>
  <label>Someone is trying to login from your account.<br>Whether it's you or someone else.<br>Please do verify by clicking yes or no</label>
  <div class="btns">
    <a href="transcaction.php" class="btn1">Yes</a>
    <a href="#" class="btn2">No</a>
  </div>
  <br><br>
  <span class="close-button" onclick="hidePopupBox()">&#10005;</span> <!-- Close button -->
</div>


  <script>
    // Function to fade in the box after 2 seconds
    setTimeout(function() {
      document.querySelector('.box').style.opacity = "1";
    }, 2000);

    // Function to hide popup boxes
    function hideHarshDialogBox() {
      var harshDialogBox = document.getElementById('harshDialogBox');
      harshDialogBox.style.display = 'none';
    }

    function hideNotificationDialog() {
      var notificationDialog = document.getElementById('notificationDialog');
      notificationDialog.style.display = 'none';
    }

    function hidePopupBox() {
      var popupBox = document.getElementById('popupBox');
      popupBox.style.display = 'none';
    }

    // Function to show harsh dialog box
    // Function to show harsh dialog box
function showHarshDialogBox() {
  hideNotificationDialog(); // Hide notification dialog if it's open
  var harshDialogBox = document.getElementById('harshDialogBox');
  harshDialogBox.style.display = 'block';
  
  // Apply flickering effect to body
  document.body.classList.add('body-flicker');
  setTimeout(function() {
    document.body.classList.remove('body-flicker');
  }, 5000); // Stop flickering after 5 seconds
}


    // Function to show the username dialog box
    function showUsernameDialog() {
      hideNotificationDialog(); // Hide notification dialog if it's open
      var violetDialogBox = document.getElementById('violetDialogBox');
      violetDialogBox.style.display = 'block';
    }

    // Function to show the notification dialog
    function showNotificationDialog(username) {
      var notificationDialog = document.getElementById('notificationDialog');
      var usernameSpan = document.getElementById('usernameSpan');
      usernameSpan.textContent = username;
      notificationDialog.style.display = 'block';
    }

    // Function to show the popup box
    function showPopupBox() {
      var popupBox = document.getElementById('popupBox');
      popupBox.style.display = 'block';
    }

    // Event listener for Yes button in popup box
    document.querySelector('.btn1').addEventListener('click', function() {
      alert('You clicked Yes!');
      // Handle the action for Yes here, if needed
    });

    // Event listener for No button in popup box
    document.querySelector('.btn2').addEventListener('click', function() {
      hidePopupBox(); // Hide the popup box
      showHarshDialogBox(); // Show the harsh dialog box
    });
   // Event listener for Yes button in popup box
document.querySelector('.btn1').addEventListener('click', function() {
  // Navigate to transcaction.php and replace current history entry
  window.location.replace('transcaction.php');
  history.replaceState(null, null,null,null, window.location.href); // Update history entry
});

// Event listener for No button in popup box
document.querySelector('.btn2').addEventListener('click', function() {
  // Navigate to another page and replace current history entry
  window.location.replace('user_login.php');
  history.replaceState(null, null,null,null, window.location.href); // Update history entry
});
  </script>

  <?php
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection settings
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

    // Get the username from the form
    $inputUsername = $_POST['username'];

    // Query to check if the username exists
    $sql = "SELECT username FROM registration WHERE username = '$inputUsername'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo "<script>showNotificationDialog('$inputUsername');</script>"; // Show notification dialog
    } else {
      echo "<script>alert('Username does not exist. Please try again.');</script>";
    }

    // Close connection
    $conn->close();
  }
  ?>
</body>
</html>