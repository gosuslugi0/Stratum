<?php 
    require "db.php";
    unset($_SESSION['logger_users']);
    header('Location: /login.php');
?>