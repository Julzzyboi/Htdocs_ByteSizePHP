<?php
require_once 'Db_connection.php';

if (isset($_POST['option_ID'])) {
    $option_ID = intval($_POST['option_ID']);
    $sql = "SELECT * FROM tbl_variation_option_id WHERE option_ID = $option_ID";
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Option not found.']);
    }
} else {
    echo json_encode(['error' => 'No option ID provided.']);
}
?>