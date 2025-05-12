<?php
require_once 'Db_connection.php';

$errors = [];

if (empty($_POST['productCategory'])) $errors[] = "Category required.";
if (empty($_POST['productName'])) $errors[] = "Name required.";
if (empty($_POST['productDescription'])) $errors[] = "Description required.";
if (empty($_POST['productPrice']) || !is_numeric($_POST['productPrice'])) $errors[] = "Valid price required.";
if (empty($_POST['productStock']) || !is_numeric($_POST['productStock'])) $errors[] = "Valid stock required.";
if (!isset($_FILES['productImage']) || $_FILES['productImage']['error'] != 0) $errors[] = "Image required.";

if ($errors) {
    echo json_encode(['success' => false, 'message' => implode("\\n", $errors)]);
    exit;
}

// Handle image upload
$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
$imageName = time() . '_' . basename($_FILES["productImage"]["name"]);
$targetFile = $uploadDir . $imageName;
if (!move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFile)) {
    echo json_encode(['success' => false, 'message' => 'Failed to upload image.']);
    exit;
}

$category = $conn->real_escape_string($_POST['productCategory']);
$name = $conn->real_escape_string($_POST['productName']);
$description = $conn->real_escape_string($_POST['productDescription']);
$price = (float)$_POST['productPrice'];
$stock = (int)$_POST['productStock'];
$imagePath = $conn->real_escape_string($targetFile);

$sql = "INSERT INTO tbl_product_id (productCategory, productName, productDescription, productPrice, productStock, productImage) 
        VALUES ('$category', '$name', '$description', $price, $stock, '$imagePath')";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Product successfully added!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . addslashes($conn->error)]);
}
?>