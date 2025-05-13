<?php
require_once 'Db_connection.php';
$id = intval($_POST['productVariation_ID']);
$sql = "DELETE FROM tbl_product_variation_id WHERE productVariation_ID = $id";
if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Variation deleted!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}
?>