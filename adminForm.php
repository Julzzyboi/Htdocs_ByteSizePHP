<?php
include('Db_connection.php');
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName = trim($_POST['lastName'] ?? '');
    $emailAddress = trim($_POST['emailAddress'] ?? '');
    $phoneNumber = trim($_POST['phoneNumber'] ?? '');
    $gender = $_POST['Gender'] ?? '';
    $password = $_POST['Password'] ?? '';
    $confirmPassword = $_POST['ConfirmPass'] ?? '';

    $errors = [];

    if (!preg_match("/^[a-zA-Z]+$/", $firstName)) {
        $errors[] = "First name must contain only letters.";
    }

    if (!preg_match("/^[a-zA-Z]+$/", $lastName)) {
        $errors[] = "Last name must contain only letters.";
    }

    if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }

    if (!preg_match("/^\d{10,15}$/", $phoneNumber)) {
        $errors[] = "Phone number must be 10–15 digits.";
    }

    if (!in_array($gender, ['Male', 'Female', 'Other'])) {
        $errors[] = "Invalid gender selected.";
    }

    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    if ($errors) {
        echo json_encode([
            'status' => 'error',
            'title' => 'Validation Failed',
            'message' => implode(' ', $errors)
        ]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $conn->begin_transaction();

    try {
        $stmt_user = $conn->prepare("INSERT INTO tbl_user_id (firstName, lastName, emailAddress, contactNumber, gender, password_Hash, userRole) VALUES (?, ?, ?, ?, ?, ?, 'admin')");
        $stmt_user->bind_param("ssssss", $firstName, $lastName, $emailAddress, $phoneNumber, $gender, $hashedPassword);
        $stmt_user->execute();
        $user_id = $stmt_user->insert_id;

        $stmt_admin = $conn->prepare("INSERT INTO tbl_admin_id (user_id, adminPassword_Hash) VALUES (?, ?)");
        $stmt_admin->bind_param("is", $user_id, $hashedPassword);
        $stmt_admin->execute();

        $conn->commit();

        echo json_encode([
            'status' => 'success',
            'title' => 'Success!',
            'message' => 'Admin account created successfully.'
        ]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode([
            'status' => 'error',
            'title' => 'Database Error',
            'message' => 'Transaction failed: ' . $e->getMessage()
        ]);
    }

    $stmt_user?->close();
    $stmt_admin?->close();
    $conn->close();
}
?>