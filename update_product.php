<?php
include 'Db_connection.php';

// Fetch product data for modal
if (isset($_POST['product_ID']) && !isset($_POST['update_product'])) {
    $product_ID = mysqli_real_escape_string($conn, $_POST['product_ID']);
    $query = "SELECT * FROM tbl_product_id WHERE product_ID='$product_ID'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    echo json_encode($row);
    exit;
}

// Update product logic
if (isset($_POST['update_product'])) {
    $product_ID = mysqli_real_escape_string($conn, $_POST['product_ID']);
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $productCategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']);
    $productPrice = mysqli_real_escape_string($conn, $_POST['productPrice']);
    $productStock = mysqli_real_escape_string($conn, $_POST['productStock']);

    // Check if a new image is uploaded
    if (!empty($_FILES['productImage']['name'])) {
        $imageName = $_FILES['productImage']['name'];
        $imageTmp = $_FILES['productImage']['tmp_name'];
        $imagePath = 'uploads/' . basename($imageName);

        if (move_uploaded_file($imageTmp, $imagePath)) {
            $query = "UPDATE tbl_product_id SET 
                      productCategory='$productCategory', 
                      productName='$productName', 
                      productDescription='$productDescription', 
                      productPrice='$productPrice', 
                      productStock='$productStock',
                      productImage='$imagePath'
                      WHERE product_ID='$product_ID'";
        } else {
            echo json_encode(['success' => false, 'error' => 'Image upload failed.']);
            exit;
        }
    } else {
        $query = "UPDATE tbl_product_id SET 
                  productCategory='$productCategory', 
                  productName='$productName', 
                  productDescription='$productDescription', 
                  productPrice='$productPrice', 
                  productStock='$productStock'
                  WHERE product_ID='$product_ID'";
    }

    if (mysqli_query($conn, $query)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
    exit;
}
?>