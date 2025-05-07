<?php
session_start();
include 'productDB.php';

if (!empty($_POST['name']) && !empty($_POST['price']) && !empty($_POST['category'])) {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $category = $_POST['category'];

  $stmt = $conn->prepare("INSERT INTO test_product (name, price, category) VALUES (?, ?, ?)");
  $stmt->bind_param("sds", $name, $price, $category);

  if ($stmt->execute()) {
      echo "Product added successfully.";
  } else {
      echo "Failed to add product.";
  }

  $stmt->close();
} else {
  echo "All fields are required.";
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Admin - Register Product</title>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <style>
    form { margin-bottom: 20px; }
    input, button { margin: 5px; padding: 5px; }
  </style>
</head>
<body>

<h2>Register New Product</h2>

<form id="productForm">
  <input type="text" name="name" placeholder="Product Name" required>
  <input type="number" name="price" placeholder="Price" required step="0.01">
  <input type="text" name="category" placeholder="Category" required>
  <button type="submit">Add Product</button>
</form>

<h2>Product List</h2>
<table id="productTable" class="display">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Price</th>
      <th>Category</th>
      <th>Created At</th>
    </tr>
  </thead>
</table>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
  var table = $('#productTable').DataTable({
    ajax: 'FetchProducts.php', 
    columns: [
      { data: 'product_id' },
      { data: 'name' },
      { data: 'price' },
      { data: 'category' },
      { data: 'created_at' }
    ]
  });

  $('#productForm').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: 'AddProduct.php',
      method: 'POST',
      data: $(this).serialize(),
      success: function (response) {
        alert(response);
        $('#productForm')[0].reset();
        table.ajax.reload();
      }
    });
  });
});
</script>

  
</body>
</html>
