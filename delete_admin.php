<?php
include('Db_connection.php');
$admin_ID = $_POST['admin_ID'];
$query = "DELETE FROM tbl_admin_id WHERE admin_ID=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $admin_ID);
if ($stmt->execute()) {
  echo json_encode(['success' => true, 'message' => 'Admin deleted successfully!']);
} else {
  echo json_encode(['success' => false, 'message' => 'Delete failed.']);
}
?>