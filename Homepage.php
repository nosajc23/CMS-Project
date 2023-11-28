<?php

/*******w******** 
    
    Name: Jason Castillo
    Date: 2023-09-26    
    Description: CMS Project

****************/

require('connect.php');

$query = "SELECT athlete_id,athlete_name,team,sport,bio,created_at FROM athletes ORDER BY created_at DESC";
$statement = $db->prepare($query);
$statement->execute();
$posts = $statement->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>    
    <link rel="stylesheet" href="main.css">
    <title>Homepage</title>
</head>
    <body style="background-color:white;">
        <!-- Remember that alternative syntax is good and html inside php is bad -->
        <div id = "header">
            <h1>Athlete Pro</h1>
        </div>

        <div id = "TextBoxOne">
            <a class="active" href="Homepage.php">Home</a>
            <a class="active" href="admin_login.php">Admin Login</a>    
            <a class="active" href="user_login.php">User Login</a> 
            <a class="active" href="register.php">Register</a> 
        </div>
    
        <div class="bg"></div>
        
    </body>