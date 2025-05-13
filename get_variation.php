<?php
require_once 'Db_connection.php';
$id = intval($_POST['productVariation_ID']);
$res = $conn->query("SELECT * FROM tbl_product_variation_id WHERE productVariation_ID = $id");
echo json_encode($res->fetch_assoc());
?>