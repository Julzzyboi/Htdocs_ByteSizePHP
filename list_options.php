<?php
require_once 'Db_connection.php';
$data = [];
$res = $conn->query("
  SELECT o.*, v.variation_Name
  FROM tbl_variation_option_id o
  LEFT JOIN tbl_product_variation_id v ON o.productVariation_ID = v.productVariation_ID
");
while ($row = $res->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode(['data' => $data]);
?>