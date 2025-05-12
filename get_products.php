<?php
require_once 'Db_connection.php';

$sql = "SELECT * FROM tbl_product_id ORDER BY product_ID DESC";
$result = $conn->query($sql);

$products = [];
while ($row = $result->fetch_assoc()) {
    $products[] = $row;
}

header('Content-Type: application/json');
echo json_encode($products);
?>