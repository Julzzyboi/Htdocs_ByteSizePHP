<?php
include('Db_connection.php');
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Collect form data safely
  $firstName = trim($_POST['firstName'] ?? '');
  $lastName = trim($_POST['lastName'] ?? '');
  $emailAddress = trim($_POST['emailAddress'] ?? '');
  $contactNumber = trim($_POST['contactNumber'] ?? '');
  $gender = trim($_POST['gender'] ?? '');
  $password = $_POST['Password'] ?? '';
  $confirmPassword = $_POST['ConfirmPass'] ?? '';

  // Validate required fields
  if (
    empty($firstName) || empty($lastName) || empty($emailAddress) ||
    empty($contactNumber) || empty($gender) || empty($password) || empty($confirmPassword)
  ) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
  }

  // Validate email format
  if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
  }

  // Validate password match
  if ($password !== $confirmPassword) {
    echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
    exit;
  }

  // Optionally: Check if email already exists
  $check = $conn->prepare("SELECT user_ID FROM tbl_user_id WHERE emailAddress = ?");
  $check->bind_param("s", $emailAddress);
  $check->execute();
  $check->store_result();
  if ($check->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email already exists.']);
    exit;
  }
  $check->close();

  // Hash the password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Insert into tbl_user_id
  $stmt_user = $conn->prepare("INSERT INTO tbl_user_id (firstName, lastName, emailAddress, contactNumber, gender, password_Hash, userRole) VALUES (?, ?, ?, ?, ?, ?, 'admin')");
  $stmt_user->bind_param("ssssss", $firstName, $lastName, $emailAddress, $contactNumber, $gender, $hashedPassword);

  if ($stmt_user->execute()) {
    $user_id = $stmt_user->insert_id;

    // Insert into tbl_admin_id
    $stmt_admin = $conn->prepare("INSERT INTO tbl_admin_id (user_id, adminPassword_Hash) VALUES (?, ?)");
    $stmt_admin->bind_param("is", $user_id, $hashedPassword);

    if ($stmt_admin->execute()) {
      echo json_encode(['success' => true, 'message' => 'Admin account created successfully.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error creating admin record: ' . $stmt_admin->error]);
    }
    $stmt_admin->close();
  } else {
    echo json_encode(['success' => false, 'message' => 'Error creating user: ' . $stmt_user->error]);
  }
  $stmt_user->close();
}
?>