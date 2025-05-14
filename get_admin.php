<?php
include('Db_connection.php');
$user_ID = $_POST['user_ID'];
$query = "SELECT * FROM tbl_user_id WHERE user_ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_ID);
$stmt->execute();
$result = $stmt->get_result();
echo json_encode($result->fetch_assoc());
?>