<?php
require_once 'Db_connection.php';
header('Content-Type: application/json');

$sql = "SELECT productVariation_ID, product_ID, variation_Name, product_Image, dateCreated, dateUpdated FROM tbl_product_variation_id";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode(['data' => $data]);
?>