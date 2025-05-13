<?php
// If you have a Db_connection.php that sets up $conn, just include it and skip the next block
// include 'Db_connection.php';

// Otherwise, connect directly:
ini_set('display_errors', 1);
error_reporting(E_ALL);

$dbHost = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "htdocs_bytesizephp";

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// QUANTITY
$sql = "SELECT * FROM tbl_product_id";
$result = $conn->query($sql);

$data = array();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
//ACTIVE CUSTOMER
include 'Db_connection.php';
// Example: Count active users per day (adjust for your schema)
$sql = "SELECT * FROM tbl_product_id";
$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
// SALES
$sql = "SELECT * FROM tbl_shop_order_id";
$result = $conn->query($sql);

$data = array();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
//WEEKLY ORDERS
$sql = "SELECT * FROM tbl_product_id";
$result = $conn->query($sql);

$data = array();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$conn->close();

echo json_encode($data);
?>