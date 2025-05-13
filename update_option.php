<?php
require_once 'Db_connection.php';

if (
    isset($_POST['option_ID']) &&
    isset($_POST['productOption']) &&
    isset($_POST['productStock']) &&
    isset($_POST['productPrice'])
) {
    $option_ID = intval($_POST['option_ID']);
    $productOption = $conn->real_escape_string($_POST['productOption']);
    $productStock = $conn->real_escape_string($_POST['productStock']);
    $productPrice = $conn->real_escape_string($_POST['productPrice']);

    $sql = "UPDATE tbl_variation_option_id 
            SET productOption = '$productOption', 
                productStock = '$productStock', 
                productPrice = '$productPrice', 
                dateUpdated = NOW()
            WHERE option_ID = $option_ID";

    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Option updated!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
}
?>