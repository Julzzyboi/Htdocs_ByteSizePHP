<?php
session_start();

include 'Db_connection.php'; // Include your correct DB connection

// Handle Sign Up
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['firstName'])) {

  $firstName = $conn->real_escape_string($_POST['firstName']);
  $lastName = $conn->real_escape_string($_POST['lastName']);
  $email = $conn->real_escape_string($_POST['emailAddress']);
  $phone = $conn->real_escape_string($_POST['phoneNumber']);
  $gender = isset($_POST['Gender']) ? $conn->real_escape_string($_POST['Gender']) : '';
  $passwordRaw = $_POST['Password'];
  $confirmPasswordRaw = $_POST['ConfirmPass'];

  // Passwords Match?
  if ($passwordRaw !== $confirmPasswordRaw) {
    $_SESSION['signup_error'] = "Passwords do not match.";
    header("Location: Account.php");
    exit();
  }

  $password = password_hash($passwordRaw, PASSWORD_DEFAULT);

  // Check if email exists in admin
  $checkAdminQuery = "SELECT * FROM admin WHERE LOWER(adminEmail) = LOWER('$email')";
  $adminResult = $conn->query($checkAdminQuery);

  $role = ($adminResult->num_rows > 0) ? 'admin' : 'customer';

  // Insert new user
  $sql = "INSERT INTO user (firstName, lastName, emailAddress, contactNumber, gender, password, role, dateCreated, dateUpdated)
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$gender', '$password', '$role', NOW(), NOW())";


  if ($conn->query($sql) === TRUE) {
    header("Location: customer_home.php");
    exit();
  } else {
    header("Location: Account.php");
    exit();
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['LogEmail']);
  $passwordInput = trim($_POST['LogPassword']);

  header('Content-Type: application/json'); // Tell browser it's JSON

  if (empty($email)) {
    echo json_encode([
      'success' => false,
      'errorType' => 'email',
      'errorMessage' => 'Email is required.'
    ]);
    exit();
  }

  if (empty($passwordInput)) {
    echo json_encode([
      'success' => false,
      'errorType' => 'password',
      'errorMessage' => 'Password is required.'
    ]);
    exit();
  }

  $email = $conn->real_escape_string($email);
  $sql = "SELECT * FROM user WHERE emailAddress = '$email'";
  $result = $conn->query($sql);

  if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($passwordInput, $user['password'])) {
      // Correct password
      $_SESSION['user_id'] = $user['user_ID'];
      $_SESSION['user_Email'] = $user['emailAddress'];
      $_SESSION['user_role'] = $user['role'];

      // Record login
      $insertLogin = "INSERT INTO user_login (emailAddress, login_Time) VALUES ('$email', NOW())";
      $conn->query($insertLogin);

      echo json_encode([
        'success' => true,
        'role' => $user['role']
      ]);
      exit();
    } else {
      // Wrong password
      echo json_encode([
        'success' => false,
        'errorType' => 'password',
        'errorMessage' => 'Incorrect password.'
      ]);
      exit();
    }
  } else {
    // Email not found
    echo json_encode([
      'success' => false,
      'errorType' => 'email',
      'errorMessage' => 'Email not found.'
    ]);
    exit();
  }
}

$conn->close();
//Handle Login
// Handle Login
// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] === 'login') {
//   $email = trim($_POST['LogEmail']);
//   $passwordInput = trim($_POST['LogPassword']);

//   // Basic validation (empty fields)
//   if (empty($email)) {
//       $_SESSION['login_error_type'] = "email";
//       $_SESSION['login_error_message'] = "Email is required.";
//       header("Location: Account.php");
//       exit();
//   }

//   if (empty($passwordInput)) {
//       $_SESSION['login_error_type'] = "password";
//       $_SESSION['login_error_message'] = "Password is required.";
//       header("Location: Account.php");
//       exit();
//   }

//   // Check database for email
//   $email = $conn->real_escape_string($email);
//   $sql = "SELECT * FROM user WHERE emailAddress = '$email'";
//   $result = $conn->query($sql);

//   if ($result && $result->num_rows === 1) {
//       $user = $result->fetch_assoc();

//       if (password_verify($passwordInput, $user['password'])) {
//           // Correct password
//           $_SESSION['user_id'] = $user['user_ID'];
//           $_SESSION['user_Email'] = $user['emailAddress'];
//           $_SESSION['user_role'] = $user['role'];

//           // Record login
//           $insertLogin = "INSERT INTO user_login (emailAddress, login_Time) VALUES ('$email', NOW())";
//           $conn->query($insertLogin);

//           if ($user['role'] == 'admin') {
//               header("Location: admin.php");
//           } else {
//               header("Location: customer_home.php");
//           }
//           exit();
//       } else {
//           // Password incorrect
//           $_SESSION['login_error_type'] = "password";
//           $_SESSION['login_error_message'] = "Incorrect Password.";
//           header("Location: Account.php");
//           exit();
//       }
//   } else {
//       // Email not found
//       $_SESSION['login_error_type'] = "email";
//       $_SESSION['login_error_message'] = "Email not found.";
//       header("Location: Account.php");
//       exit();
//   }
// }

// Show signup or login error messages
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
        <form action="Account.php" method="POST">
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
            <span id="errorLogEmail" class="error-message">
              <?php
              if (isset($_SESSION['login_error_type']) && $_SESSION['login_error_type'] === 'email') {
                echo $_SESSION['login_error_message'];
                unset($_SESSION['login_error_type']);
                unset($_SESSION['login_error_message']);
              }
              ?>
            </span>

            <div class="LogPass">
              <input type="password" class="inputPassLogIn" id="LogPass" name="LogPassword" placeholder="Password" />
            </div>
            <span id="errorLogPass" class="error-message">
              <?php
              if (isset($_SESSION['login_error_type']) && $_SESSION['login_error_type'] === 'password') {
                echo $_SESSION['login_error_message'];
                unset($_SESSION['login_error_type']);
                unset($_SESSION['login_error_message']);
              }
              ?>
            </span>

          </div>

          <button type="submit" id="Login-Button" name="login_user">Login</button>
        </form>
        <div id="modal" style="display:none; position:fixed; top:20%; left:50%; transform:translate(-50%, -50%);
        background:white; padding:20px; border:1px solid black; box-shadow:0 0 10px rgba(0,0,0,0.5); z-index:1000;">
          <p id="modalMessage"></p>
          <button onclick="closeModal()">OK</button>
        </div>
        <div id="overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
        background:rgba(0,0,0,0.5); z-index:999;"></div>

      </div>
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