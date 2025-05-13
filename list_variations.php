<?php
header('Content-Type: application/json');
include('Db_connection.php');
$result = mysqli_query($conn, "SELECT * FROM tbl_product_variation_id");
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode(['data' => $data]);
?>