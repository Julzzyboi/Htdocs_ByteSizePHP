<?php
include('Db_connection.php');
$sql = "SELECT *, CONCAT(firstName, ' ', lastName) as fullName FROM tbl_user_id WHERE userRole = 'admin'";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
  $row['actions'] = '
    <button class="btn btn-success btn-sm updateAdminBtn" data-id="'.$row['user_ID'].'">Update</button>
    <button class="btn btn-danger btn-sm deleteAdminBtn" data-id="'.$row['user_ID'].'">Delete</button>
  ';
  $data[] = $row;
}
echo json_encode(['data' => $data]);
?>