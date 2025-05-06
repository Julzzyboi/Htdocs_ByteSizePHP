<?php
include 'productDB.php';

$sql = "SELECT * FROM test_product ORDER BY product_id DESC";
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['data' => $data]);
?>
