<?php
require_once 'Db_connection.php';

$errors = [];

if (empty($_POST['product_ID'])) $errors[] = "Product ID required.";
if (empty($_POST['variation_Name'])) $errors[] = "Variation name required.";

if ($errors) { 
    echo json_encode(['success' => false, 'message' => implode("\\n", $errors)]);
    exit;
}

$product_ID = intval($_POST['product_ID']);
$variation_Name = $conn->real_escape_string($_POST['variation_Name']);

// Optional: handle image upload if needed
$product_Image = '';
if (isset($_FILES['product_Image']) && $_FILES['product_Image']['error'] == 0) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $imageName = time() . '_' . basename($_FILES["product_Image"]["name"]);
    $targetFile = $uploadDir . $imageName;
    if (move_uploaded_file($_FILES["product_Image"]["tmp_name"], $targetFile)) {
        $product_Image = $conn->real_escape_string($targetFile);
    }
}

$sql = "INSERT INTO tbl_product_variation_id (product_ID, product_Image, variation_Name) VALUES ($product_ID, '$product_Image', '$variation_Name')";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Variation added!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . addslashes($conn->error)]);
}
?>