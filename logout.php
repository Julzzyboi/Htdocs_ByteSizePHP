<?php
session_start();

if(isset($_GET['logout'])){
    unset($user_id);
    session_destroy();
    header('location:Account.php');
 };

?>