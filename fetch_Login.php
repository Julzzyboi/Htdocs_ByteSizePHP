<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

include('Db_connection.php');

// Join login and user tables to get email and role
$query = "
  SELECT 
    l.login_ID, 
    l.user_ID, 
    u.emailAddress, 
    u.userRole, 
    l.loginTime
  FROM tbl_login_id
  LEFT JOIN tbl_user_id u ON l.user_ID = u.user_ID
  ORDER BY l.loginTime DESC
";

$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode([
    "data" => $data
]);
?>