 <?php
session_start();
include 'Db_connection.php'; // DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // === SIGN UP ===
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

        $password = password_hash($passwordRaw, PASSWORD_BCRYPT);

        // Check if Admin
        $stmt = $conn->prepare("SELECT * FROM tbl_admin_id WHERE user_ID = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $adminResult = $stmt->get_result();
        $role = ($adminResult->num_rows > 0) ? 'admin' : 'customer'; 

        // Insert user
        $stmt = $conn->prepare("INSERT INTO tbl_user_id (firstName, lastName, emailAddress, contactNumber, gender, password_Hash, userRole)
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $firstName, $lastName, $email, $phone, $gender, $password, $role);

        if ($stmt->execute()) {
          // Get the newly inserted user_ID
          $newUserId = $stmt->insert_id;
          $loginTime = date('Y-m-d H:i:s');
      
          // Insert into login table
          $insertLogin = $conn->prepare("INSERT INTO tbl_login_id (user_ID, emailAddress, password_Hash, userRole, loginTime) VALUES (?, ?, ?, ?, ?)");
          $insertLogin->bind_param("issss", $newUserId, $email, $password, $role, $loginTime);
      
          if ($insertLogin->execute()) {
              // Redirect to customer page 
              header("Location: customer_home.php");
              exit();
          } else {
              $_SESSION['signup_error'] = "Registration succeeded but login logging failed.";
              header("Location: Account.php");
              exit();
          }
      }
    }      

    // === LOGIN ===
    if (isset($_POST['action']) && $_POST['action'] === 'login') {
        header('Content-Type: application/json');

        $email = trim(strtolower($_POST['LogEmail']));
        $passwordInput = $_POST['LogPassword'];

        $stmt = $conn->prepare("SELECT * FROM tbl_user_id WHERE LOWER(emailAddress) = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();
            $hashedPassword = $user['password_Hash'];

            if (password_verify($passwordInput, $hashedPassword)) {
                // Log login attempt
                $loginTime = date('Y-m-d H:i:s');
                $insertLogin = $conn->prepare("INSERT INTO tbl_login_id (user_ID, emailAddress, password_Hash, userRole, loginTime) VALUES (?, ?, ?, ?, ?)");
                $insertLogin->bind_param("issss", $user['user_ID'], $user['emailAddress'], $hashedPassword, $user['userRole'], $loginTime);
                $insertLogin->execute();

                echo json_encode(["success" => true, "role" => $user['userRole']]);
                exit();
            } else {
                echo json_encode(["success" => false, "message" => "Incorrect password."]);
                exit();
            }
        } else {
            echo json_encode(["success" => false, "message" => "Email not found."]);
            exit();
        }
    }
    $conn->close();
}

          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
              if (!isset($_POST['termsCheckbox']) || !isset($_POST['privacyCheckbox'])) {
                  $_SESSION['signup_error'] = "You must accept both the Terms & Conditions and the Privacy Policy.";
                  header("Location: Account.php");
                  exit();
              }

          }


?> 


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="zacc.css" />

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
              <svg class="visiblePassword" onclick="togglePasswordVisibility()" id="visible" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="visible">
                        <path d="m20.9 9.9-2-1.4c-4.2-2.8-9.5-2.8-13.7 0l-2 1.4C2.4 10.4 2 11.1 2 12s.4 1.6 1.1 2.1l2 1.4c2.1 1.4 4.5 2.1 6.8 2.1s4.8-.7 6.8-2.1l2-1.4c.7-.5 1.1-1.3 1.1-2.1s-.2-1.6-.9-2.1zM8.8 15c-.9-.3-1.7-.7-2.5-1.2l-2-1.4c-.3-.1-.3-.3-.3-.4s0-.3.2-.5l2-1.4c.9-.4 1.7-.8 2.6-1.1-.7.8-1.2 1.9-1.2 3 0 1.2.5 2.2 1.2 3zm3.2-.6c-1.3 0-2.4-1.1-2.4-2.4s1.1-2.4 2.4-2.4 2.4 1.1 2.4 2.4-1.1 2.4-2.4 2.4zm7.8-1.9-2 1.4c-.8.5-1.6.9-2.5 1.2.7-.8 1.2-1.9 1.2-3 0-1.2-.5-2.2-1.2-3 .9.3 1.7.7 2.5 1.2l2 1.4c.2 0 .2.2.2.3s0 .3-.2.5z" fill="#2e222f" class="color000000 svgShape"></path>
                    </svg>
                    <svg class="invisiblePassword" onclick="togglePasswordVisibility()" id="hidden" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" id="Hidden">
                        <g id="_icons" fill="#2e222f" class="color000000 svgShape">
                          <path d="M21.0303 9.8164c-.5518-.541-1.1211-1.0146-1.6934-1.4092-.4541-.3135-1.0771-.1992-1.3906.2559-.3135.4541-.1992 1.0771.2559 1.3906.4775.3291.958.7305 1.4492 1.2109l.1113.1025C19.9111 11.5117 20 11.748 20 12s-.0889.4883-.2188.6152l-.1514.1406c-1.4482 1.4219-3.1992 2.4307-5.0576 2.915-1.1475.2939-2.3047.3936-3.4453.293-.5391-.0479-1.0342.3594-1.083.9092-.0479.5498.3584 1.0352.9092 1.083.3447.0303.6914.0459 1.0381.0449 1.0254 0 2.0576-.1309 3.0811-.3936 2.2012-.5742 4.2607-1.7578 5.9365-3.4033l.1484-.1377C21.6924 13.5469 22 12.793 22 12s-.3076-1.5469-.8613-2.084L21.0303 9.8164zM5.293 17.293C5.0977 17.4883 5 17.7441 5 18s.0977.5117.293.707S5.7441 19 6 19s.5117-.0977.707-.293l1.8096-1.8096 8.3809-8.3809L18.707 6.707C18.9023 6.5117 19 6.2559 19 6s-.0977-.5117-.293-.707c-.3906-.3906-1.0234-.3906-1.4141 0l-1.377 1.377c-.2809-.0948-.5518-.2024-.8457-.2773-2.0156-.5215-4.123-.5215-6.1426 0C6.7266 6.9668 4.667 8.1504 2.9912 9.7959L2.8428 9.9336C2.3076 10.4531 2 11.207 2 12s.3076 1.5469.8613 2.084l.1074.0986c.9468.9313 1.9971 1.6994 3.129 2.3055L5.293 17.293zM4.2373 12.6328C4.0889 12.4883 4 12.252 4 12s.0889-.4883.2188-.6152l.1514-.1406c1.4482-1.4219 3.1992-2.4307 5.0596-2.916C10.2744 8.1104 11.1387 8 12 8c.7754 0 1.5537.0898 2.3184.2666l-1.0339 1.0339C12.8943 9.1138 12.4622 9 12 9c-1.66 0-3 1.34-3 3 0 .4622.1138.8943.3005 1.2844L7.582 15.0029c-1.1738-.5488-2.2539-1.3047-3.2334-2.2676L4.2373 12.6328z" fill="#2e222f" class="color000000 svgShape"></path>
                        </g>
                      </svg>
            </div>
            <span id="errorpassword" class="error-message"></span>

            <div class="ConfirmPass">
              <input type="password" class="inputSignUpCPass" id="Cpass" name="ConfirmPass"
                placeholder="Confirm Password" />
                <svg class="visibleConfirmPassword" onclick="toggleConfirmPasswordVisibility()" id="visible" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="visible">
                        <path d="m20.9 9.9-2-1.4c-4.2-2.8-9.5-2.8-13.7 0l-2 1.4C2.4 10.4 2 11.1 2 12s.4 1.6 1.1 2.1l2 1.4c2.1 1.4 4.5 2.1 6.8 2.1s4.8-.7 6.8-2.1l2-1.4c.7-.5 1.1-1.3 1.1-2.1s-.2-1.6-.9-2.1zM8.8 15c-.9-.3-1.7-.7-2.5-1.2l-2-1.4c-.3-.1-.3-.3-.3-.4s0-.3.2-.5l2-1.4c.9-.4 1.7-.8 2.6-1.1-.7.8-1.2 1.9-1.2 3 0 1.2.5 2.2 1.2 3zm3.2-.6c-1.3 0-2.4-1.1-2.4-2.4s1.1-2.4 2.4-2.4 2.4 1.1 2.4 2.4-1.1 2.4-2.4 2.4zm7.8-1.9-2 1.4c-.8.5-1.6.9-2.5 1.2.7-.8 1.2-1.9 1.2-3 0-1.2-.5-2.2-1.2-3 .9.3 1.7.7 2.5 1.2l2 1.4c.2 0 .2.2.2.3s0 .3-.2.5z" fill="#2e222f" class="color000000 svgShape"></path>
                    </svg>
                    <svg class="invisibleConfirmPassword" onclick="toggleConfirmPasswordVisibility()" id="hidden" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24" id="Hidden">
                        <g id="_icons" fill="#2e222f" class="color000000 svgShape">
                          <path d="M21.0303 9.8164c-.5518-.541-1.1211-1.0146-1.6934-1.4092-.4541-.3135-1.0771-.1992-1.3906.2559-.3135.4541-.1992 1.0771.2559 1.3906.4775.3291.958.7305 1.4492 1.2109l.1113.1025C19.9111 11.5117 20 11.748 20 12s-.0889.4883-.2188.6152l-.1514.1406c-1.4482 1.4219-3.1992 2.4307-5.0576 2.915-1.1475.2939-2.3047.3936-3.4453.293-.5391-.0479-1.0342.3594-1.083.9092-.0479.5498.3584 1.0352.9092 1.083.3447.0303.6914.0459 1.0381.0449 1.0254 0 2.0576-.1309 3.0811-.3936 2.2012-.5742 4.2607-1.7578 5.9365-3.4033l.1484-.1377C21.6924 13.5469 22 12.793 22 12s-.3076-1.5469-.8613-2.084L21.0303 9.8164zM5.293 17.293C5.0977 17.4883 5 17.7441 5 18s.0977.5117.293.707S5.7441 19 6 19s.5117-.0977.707-.293l1.8096-1.8096 8.3809-8.3809L18.707 6.707C18.9023 6.5117 19 6.2559 19 6s-.0977-.5117-.293-.707c-.3906-.3906-1.0234-.3906-1.4141 0l-1.377 1.377c-.2809-.0948-.5518-.2024-.8457-.2773-2.0156-.5215-4.123-.5215-6.1426 0C6.7266 6.9668 4.667 8.1504 2.9912 9.7959L2.8428 9.9336C2.3076 10.4531 2 11.207 2 12s.3076 1.5469.8613 2.084l.1074.0986c.9468.9313 1.9971 1.6994 3.129 2.3055L5.293 17.293zM4.2373 12.6328C4.0889 12.4883 4 12.252 4 12s.0889-.4883.2188-.6152l.1514-.1406c1.4482-1.4219 3.1992-2.4307 5.0596-2.916C10.2744 8.1104 11.1387 8 12 8c.7754 0 1.5537.0898 2.3184.2666l-1.0339 1.0339C12.8943 9.1138 12.4622 9 12 9c-1.66 0-3 1.34-3 3 0 .4622.1138.8943.3005 1.2844L7.582 15.0029c-1.1738-.5488-2.2539-1.3047-3.2334-2.2676L4.2373 12.6328z" fill="#2e222f" class="color000000 svgShape"></path>
                        </g>
                      </svg>

            </div>
            <span id="errorCpass" class="error-message"></span>
          </div>

          <button type="submit" id="SignUp-Button">Register</button>
        </form>
      </div>


      <!-- Login -->
      <div class="Login">
        <form method="POST" id="loginForm" onsubmit="validateLogin(event)">
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
</body>
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
     //password visibility

     function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const visibleIcon = document.querySelector('.visiblePassword');
    const invisibleIcon = document.querySelector('.invisiblePassword');

    // Toggle the password type
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        visibleIcon.style.display = "none";  // Hide the visible icon
        invisibleIcon.style.display = "block"; // Show the invisible icon
    } else {
        passwordInput.type = "password";
        visibleIcon.style.display = "block";  // Show the visible icon
        invisibleIcon.style.display = "none"; // Hide the invisible icon
    }
}

function toggleConfirmPasswordVisibility() {
    const confirmPasswordInput = document.getElementById('Cpass');
    const visibleIconConfirm = document.querySelector('.visibleConfirmPassword');
    const invisibleIconConfirm = document.querySelector('.invisibleConfirmPassword');

    // Toggle the password type
    if (confirmPasswordInput.type === "password") {
        confirmPasswordInput.type = "text";
        visibleIconConfirm.style.display = "none";  // Hide the visible icon
        invisibleIconConfirm.style.display = "block"; // Show the invisible icon
    } else {
        confirmPasswordInput.type = "password";
        visibleIconConfirm.style.display = "block";  // Show the visible icon
        invisibleIconConfirm.style.display = "none"; // Hide the invisible icon
    }
}
  </script>
</html>