<?php
// Enable error reporting (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// DB connection
require_once 'Db_connection.php';

// Force JSON header
header('Content-Type: application/json');

// Query to join login and user tables
$sql = "SELECT *
        FROM tbl_login_id 
        ORDER BY loginTime DESC";

$result = $conn->query($sql);

$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode(['data' => $data]);
} else {
    echo json_encode(['data' => [], 'error' => $conn->error]);
}

$conn->close();
?>
