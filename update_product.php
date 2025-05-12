<?php
include 'Db_connection.php'; // adjust this if your DB connection is elsewhere

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
            // Update with new image
            $query = "UPDATE tbl_product_id SET 
                      productCategory='$productCategory', 
                      productName='$productName', 
                      productDescription='$productDescription', 
                      productPrice='$productPrice', 
                      productStock='$productStock',
                      productImage='$imagePath'
                      WHERE product_ID='$product_ID'";
        } else {
            die("Image upload failed.");
        }
    } else {
        // Update without changing the image
        $query = "UPDATE tbl_product_id SET 
                  productCategory='$productCategory', 
                  productName='$productName', 
                  productDescription='$productDescription', 
                  productPrice='$productPrice', 
                  productStock='$productStock'
                  WHERE product_ID='$product_ID'";
    }

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Product updated successfully!');
                window.location.href='your_main_page.php'; // change this to your actual page
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
