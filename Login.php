<?php
include 'Db_connection.php'; // your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the login inputs safely
    $email = $conn->real_escape_string($_POST['LogEmail']);
    $password = $_POST['LogPassword']; // raw password input

    // Step 1: Find the user by email
    $sql = "SELECT * FROM user WHERE LOWER(emailAddress) = LOWER('$email')";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Step 2: Verify password
        if (password_verify($password, $user['password'])) {
            // Password matches

            // Save user information in session
            $_SESSION['user_id'] = $user['userID'];
            $_SESSION['user_email'] = $user['emailAddress'];
            $_SESSION['user_role'] = $user['role'];

            // Step 3: Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin.php");
                exit();
            } else {
                header("Location: customer_home.php");
                exit();
            }
        } else {
            // Password doesn't match
            $_SESSION['login_error'] = "Invalid email or password.";
            header("Location: Account.php");
            exit();
        }
    } else {
        // No user found with that email
        $_SESSION['login_error'] = "Invalid email or password.";
        header("Location: Account.php");
        exit();
    }
    if (isset($_SESSION['login_error'])) {
        echo '<p class="error-message">' . $_SESSION['login_error'] . '</p>';
        unset($_SESSION['login_error']);
    }
}

$conn->close();
