<?php
include 'Db_connection.php'; // your DB connection
if (isset($_POST['product_ID'])) {
  $id = $_POST['product_ID'];
  $query = "SELECT * FROM tbl_product_id WHERE product_ID = $id";
  $result = mysqli_query($conn, $query);
  echo json_encode(mysqli_fetch_assoc($result));
}
?>

