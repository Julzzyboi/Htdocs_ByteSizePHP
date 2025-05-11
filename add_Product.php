<?php
header('Content-Type: application/json');

$errors = [];

if(empty($_POST['productCategory'])){
     $errors['productCategory'] = "Must choose a product type.";
}

if (empty($_POST['productName'])) {
    $errors['productName'] = "Product name is required.";
}

if(empty($_POST['productDescription'])){
     $errors['productDescription'] = "Description is required.";
}

if(empty($_POST['productStock'])){
     $errors['productStock'] = "Stock number is required.";
}

if(empty($_POST['productImage'])){
     $errors['productImage'] = "Product Image is required.";
}


if (empty($_POST['productPrice']) || !is_numeric($_POST['productPrice'])) {
    $errors['productPrice'] = "Valid price is required.";
}
 
// Add more validations...

if (!empty($errors)) {
    echo json_encode([
        'status' => 'error',
        'errors' => $errors
    ]);
    exit;
}

// Proceed with inserting into the database
// Assume success...

echo json_encode([
    'status' => 'success',
    'message' => 'Product successfully added!'
]);
?>