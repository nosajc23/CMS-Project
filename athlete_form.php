<?php

/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/

require('connect.php');


$query = "SELECT athlete_id,athlete_name,team,sport,bio FROM athletes";
$statement = $db->prepare($query);
$statement->execute();
$posts = $statement->fetchAll();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Athlete Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

    <div id = "TextBoxOne">
        <div id = "header">
            <h1>Athlete Pro</h1>
        </div>

        <div id = "TextBoxOne">
            <a class="active" href="AdminPage.php">Home</a>
        </div>
    </div>


    <div class = "container">
         <h1>Create Athlete Page</h1>
        <form action="create_athlete.php" method="POST">
            <label for="athlete_name">Athlete Name:</label>
            <input type="text" name="athlete_name" class="form-control" required><br>
            <label for="team">Team:</label>
            <input type="text" name="team" class="form-control" required><br>
            <label for="sport">Sport:</label>
            <input type="text" name="sport" class="form-control" required><br>
            <label for="bio">Bio:</label><br>
            <textarea name="bio" rows="4"  class="form-control" required></textarea>
            <input type="submit"  class="btn btn-primary" value="Create Athlete Page">
        </form>
    </div>
   
 </body>
</html>

