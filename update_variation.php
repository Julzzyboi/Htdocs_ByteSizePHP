<?php
require_once 'Db_connection.php';
$id = intval($_POST['productVariation_ID']);
$name = $conn->real_escape_string($_POST['variation_Name']);
$image = '';

if (isset($_FILES['product_Image']) && $_FILES['product_Image']['error'] == 0) {
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
    $imageName = time() . '_' . basename($_FILES["product_Image"]["name"]);
    $targetFile = $uploadDir . $imageName;
    if (move_uploaded_file($_FILES["product_Image"]["tmp_name"], $targetFile)) {
        $image = $conn->real_escape_string($targetFile);
    }
}

$setImage = $image ? ", product_Image='$image'" : "";
$sql = "UPDATE tbl_product_variation_id SET variation_Name='$name' $setImage WHERE productVariation_ID=$id";
if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Variation updated!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
}
?>