

<?php
require_once 'Db_connection.php';

$errors = [];

if (empty($_POST['productCategory'])) $errors[] = "Category required.";

if ($errors) {
    echo json_encode(['success' => false, 'message' => implode("\\n", $errors)]);
    exit;
}

$category = $conn->real_escape_string($_POST['productCategory']);

$sql = "INSERT INTO tbl_product_id (productCategory, productStock) VALUES ('$category', 0)";

if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Product successfully added!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . addslashes($conn->error)]);
}
?>

