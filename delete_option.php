<?php
require_once 'Db_connection.php';

if (isset($_POST['option_ID'])) {
    $option_ID = intval($_POST['option_ID']);
    $sql = "DELETE FROM tbl_variation_option_id WHERE option_ID = $option_ID";
    if ($conn->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Option deleted!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No option ID provided.']);
}
?>