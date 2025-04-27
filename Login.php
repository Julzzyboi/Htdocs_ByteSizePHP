<?php 

$host = "localhost";
$user = "root";
$password = "";
$db = "testdata";

$data = mysqli_connect($host, $user, $password, $db);

if($data === false ){
    die("Connection error");
}

// if($_SERVER["REQUEST_METHOD"] == "POST"){
//     $username
// }
?>