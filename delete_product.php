<?php
include 'Db_connection.php';
if (isset($_POST['product_ID'])) {
  $id = $_POST['product_ID'];
  $query = "DELETE FROM tbl_product_id WHERE product_ID = $id";
  mysqli_query($conn, $query);
}
?>
