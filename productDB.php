<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "testdata"; // change this

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
