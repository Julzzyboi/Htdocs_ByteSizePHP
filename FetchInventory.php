<?php
include 'productDB.php';

$sql = "SELECT p.product_id, p.name, p.category, i.quantity, i.updated_at
        FROM test_product p
        LEFT JOIN test_inventory i ON p.product_id = i.product_id
        ORDER BY p.product_id DESC";

$result = $conn->query($sql);
$data = [];

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode(['data' => $data]);
?>
