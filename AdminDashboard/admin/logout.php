<?php
    include("connect.php");
    
    session_start();

    header('Location: ../../PHP/login.php');

    session_destroy();  
?>