<?php
/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/
session_start();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: Homepage.php");
exit();
?>
