<?php
require_once 'Db_connection.php';

$errors = [];
if (empty($_POST['productVariation_ID'])) $errors[] = "Variation ID required.";
if (empty($_POST['productOption'])) $errors[] = "Option name required.";
if (empty($_POST['productStock'])) $errors[] = "Stock required.";
if (empty($_POST['productPrice'])) $errors[] = "Price required.";

if ($errors) {
    echo json_encode(['success' => false, 'message' => implode("\\n", $errors)]);
    exit;
}

$variation_ID = intval($_POST['productVariation_ID']);
$option = $conn->real_escape_string($_POST['productOption']);
$stock = $conn->real_escape_string($_POST['productStock']);
$price = $conn->real_escape_string($_POST['productPrice']);

$sql = "INSERT INTO tbl_variation_option_id (productVariation_ID, productOption, productStock, productPrice) VALUES ($variation_ID, '$option', '$stock', '$price')";
if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Option added!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}
?>