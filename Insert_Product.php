<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Database connection (use your actual credentials)
    include 'Db_connection.php'; // Make sure this file defines $conn

    // Get and sanitize input
    $productCategory    = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $productName        = mysqli_real_escape_string($conn, $_POST['productName']);
    $productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']);
    $productPrice       = floatval($_POST['productPrice']);
    $productStock       = intval($_POST['productStock']);

    // Handle image upload
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === 0) {
        $imgName = $_FILES['productImage']['name'];
        $imgTmp  = $_FILES['productImage']['tmp_name'];
        $imgExt  = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imgExt, $allowedExtensions)) {
            $newImgName = uniqid("IMG-", true) . '.' . $imgExt;
            $imgPath = 'uploads/' . $newImgName;

            // Ensure the uploads folder exists
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }

            move_uploaded_file($imgTmp, $imgPath);

            // Insert into DB
            $query = "INSERT INTO tbl_product_id 
                (productCategory, productName, productDescription, productPrice, productStock, productImage)
                VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "sssdis", $productCategory, $productName, $productDescription, $productPrice, $productStock, $imgPath);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Product added successfully!');</script>";
            } else {
                echo "<script>alert('Database error: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Invalid image format. Only JPG, JPEG, PNG, GIF are allowed.');</script>";
        }
    } else {
        echo "<script>alert('Please upload a product image.');</script>";
    }
}
?>
