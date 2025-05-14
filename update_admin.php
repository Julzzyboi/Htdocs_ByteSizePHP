<?php
include('Db_connection.php');
$user_ID = $_POST['user_ID'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$emailAddress = $_POST['emailAddress'];
$contactNumber = $_POST['contactNumber'];
$gender = $_POST['gender'];
$userRole = $_POST['userRole'];

$query = "UPDATE tbl_user_id SET firstName=?, lastName=?, emailAddress=?, contactNumber=?, gender=?, userRole=? WHERE user_ID=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssssi", $firstName, $lastName, $emailAddress, $contactNumber, $gender, $userRole, $user_ID);
if ($stmt->execute()) {
  echo json_encode(['success' => true, 'message' => 'Admin updated successfully!']);
} else {
  echo json_encode(['success' => false, 'message' => 'Update failed.']);
}
?>