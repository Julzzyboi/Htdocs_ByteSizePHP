<?php
session_start();
include 'Db_connection.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // SIGN UP
  if (isset($_POST['firstName'])) {
      $firstName = trim($_POST['firstName']);
      $lastName = trim($_POST['lastName']);
      $email = trim(strtolower($_POST['emailAddress']));
      $phone = trim($_POST['phoneNumber']);
      $gender = isset($_POST['Gender']) ? trim($_POST['Gender']) : '';
      $passwordRaw = $_POST['Password'];
      $confirmPasswordRaw = $_POST['ConfirmPass'];

      if ($passwordRaw !== $confirmPasswordRaw) {
          $_SESSION['signup_error'] = "Passwords do not match.";
          header("Location: Account.php");
          exit();
      }

      // $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

      // Check if Admin
      $stmt = $conn->prepare("SELECT * FROM tbl_admin_id WHERE user_ID = ?");
      $stmt->bind_param("s", $email); // You may need to change this depending on how admin is identified
      $stmt->execute();
      $adminResult = $stmt->get_result();
      $role = ($adminResult->num_rows > 0) ? 'admin' : 'customer'; 

      // Insert user (omit user_ID, dateCreated, dateUpdated — they auto-fill)
      $stmt = $conn->prepare("INSERT INTO tbl_user_id (firstName, lastName, emailAddress, contactNumber, gender, password_Hash, userRole)
                              VALUES (?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("sssssss", $firstName, $lastName, $email, $phone, $gender, $passwordRaw, $role);

      if ($stmt->execute()) {
          header("Location: customer_home.php");
          exit();
      } else {
          $_SESSION['signup_error'] = "Failed to register user.";
          header("Location: Account.php");
          exit();
      }
  }

      
    

    // LOGIN
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'login') {
      header('Content-Type: application/json');
  
      $email = trim(strtolower($_POST['LogEmail']));
      $passwordInput = $_POST['LogPassword'];
  
      // Use correct table name and column names
      $stmt = $conn->prepare("SELECT * FROM tbl_user_id WHERE LOWER(emailAddress) = ?");
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
  
      if ($result && $result->num_rows === 1) {
          $user = $result->fetch_assoc();
          $hashedPassword = $user['password_Hash'];
  
          // Correct usage of password_verify
          if (password_verify($passwordInput, $hashedPassword)) {
              // Password correct
              $_SESSION['user_id'] = $user['user_ID'];
              $_SESSION['user_Email'] = $user['emailAddress'];
              $_SESSION['user_role'] = $user['userRole'];
  
              // Insert into user_login
              $loginStmt = $conn->prepare("INSERT INTO user_login (firstName, lastName, emailAddress, login_Time) VALUES (?, ?, ?, ?)");
              $loginStmt->bind_param("sss", $user['firstName'], $user['lastName'], $user['emailAddress']);
              $loginStmt->execute();
  
              echo json_encode(["success" => true, "role" => $user['userRole']]);
              exit();
          } else {
              // echo json_encode(["success" => false, "message" => "Incorrect password."]);
              // exit();
              echo json_encode([
                "success" => false,
                "error" => "Incorrect password debug.",
                "input" => $passwordInput,
                "hash" => $hashedPassword,
                "verify" => password_verify($passwordInput, $hashedPassword) // should be true
            ]);
          }
      } else {
          echo json_encode(["success" => false, "message" => "Email not found."]);
          exit();
      }
  }
  $conn->close();
}  
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="Account.css" />

</head>

<body>
  <div class="Main-Container" id="Main">
    <!-- Logo -->
    <div class="Logo-Container">
      <div class="Account-Logo">
        <img src="AccountPage/StickerLogo.png" />
      </div>
    </div>

    <div class="Form-Container">
      <!-- Sign Up -->
      <div class="SignUp">
        <form action="Account.php" method="POST" onsubmit="validateForm(event)">
          <p class="Title Form1">Sign Up</p>
          <p>
            Already have an account?
            <span><a href="#" onclick="showLogin()">Login</a></span>
          </p>

          <div class="signUpInputs">
            <div class="Fname">
              <input type="text" class="inputFN" id="Fname" name="firstName" placeholder="First Name (ex. Juan)"
                maxlength="50" />
              <span class="remainingFN" id="remainingFN">50</span>
            </div>

            <span id="errorFname" class="error-message"></span>

            <div class="Lname">
              <input type="text" class="inputLN" id="Lname" name="lastName" placeholder="Last Name (ex. Dela Cruz)"
                maxlength="50" />
              <span class="remainingLN" id="remainingLN">50</span>
            </div>

            <span id="errorLname" class="error-message"></span>

            <div class="Email">
              <input type="email" class="inputEmailSignUp" id="email" name="emailAddress"
                placeholder="Email (ex. juandelacruz@gmail.com)" />
            </div>

            <span id="erroremail" class="error-message"></span>

            <div class="PhoneNum">
              <input type="number" class="inputPhoneNum" id="Phone" name="phoneNumber"
                placeholder="Phone Number (09991234567)" oninput="this.value=this.value.slice(0,11)" />
            </div>

            <span id="errorPhone" class="error-message"></span>

            <div class="Gender">
              <label for="Gender">Gender:</label>
              <input type="radio" id="Male" name="Gender" value="Male" />
              <label for="Male">Male</label>
              <input type="radio" id="Female" name="Gender" value="Female" />
              <label for="Female">Female</label>
            </div>
            <span id="errorGender" class="error-message"></span>

            <div class="Password">
              <input type="password" class="inputSignUpPass" id="password" name="Password" placeholder="Password" />
            </div>
            <span id="errorpassword" class="error-message"></span>

            <div class="ConfirmPass">
              <input type="password" class="inputSignUpCPass" id="Cpass" name="ConfirmPass"
                placeholder="Confirm Password" />
            </div>
            <span id="errorCpass" class="error-message"></span>
          </div>

          <button type="submit" id="SignUp-Button">Register</button>
        </form>
      </div>

      <!-- Login -->
      <div class="Login">
        <form action="Account.php" method="POST" id="loginForm" onsubmit="validateLogin(event)">
          <input type="hidden" name="action" value="login">
          <p class="Title Form2">Login</p>
          <p>
            Don't have an account yet?
            <span><a href="#" onclick="showSignUp()">Sign Up</a></span>
          </p>
          <div class="loginInputs">

            <div class="LogEmail">
              <input type="email" class="inputEmailLogIn" id="LogEmail" name="LogEmail" placeholder="Email" />
            </div>
            <span id="errorLogEmail" class="error-message"></span> 

            <div class="LogPass">
              <input type="password" class="inputPassLogIn" id="LogPass" name="LogPassword" placeholder="Password" />
            </div>
            <span id="errorLogPass" class="error-message"></span>

          </div>

          <button type="submit" id="Login-Button" name="login_user">Login</button>
        </form>
      </div>
    </div>

    <div id="modal" class="Modal-Wrap">
      <div class="modal">
        <div class="CloseModal-Button"><a onclick="closeModal()"><img src="AccountPage/close.svg" alt=""></a></div>
      <div class="Error-Cookie"><img src="AccountPage/Crunch Confused.png" alt=""></div>
      <div class="Error-Graham"><img src="AccountPage/Grahan Confused.png" alt=""></div>
        <div class="Error-Pastillas"><img src="AccountPage/Pasty Confused.png" alt=""></div>
          <div class="modalContainer">
            <p class="Error-Title">Error:</p>
            <p class="modalMess" id="modalMessage"></p>
            <button class="Error-Button" onclick="closeModal()">OK</button>
          </div>
      </div>
    </div>
        <div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
      background:rgba(0,0,0,0.5); z-index:999;">
        </div>
  </div>
  <script src="Account.js"></script>
  <script>
    // for  sliding animation
    const Mcontainer = document.getElementById("Main");

    function showLogin() {
      Mcontainer.classList.add("Login-mode");
    }

    function showSignUp() {
      Mcontainer.classList.remove("Login-mode");
    }

  </script>
</body>

</html>