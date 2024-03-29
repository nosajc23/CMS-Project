<?php
/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/

require('connect.php');


$athlete_id = $_POST['id']; // Get the post ID from the form
$action = isset($_POST['update']) ? 'update' : (isset($_POST['delete']) ? 'delete' : '');


if ($action === 'update') {
    $athleteName = $_POST['athlete_name'];
    $team = $_POST['team'];
    $sport_id = $_POST['sport'];
    $bio = $_POST['bio'];

    if($_FILES['image_path']['name'] != null) {
        // image to be uploaded
        $image_path= $_FILES['image_path']['name'];
        require("fileUpload.php"); 
       // Query to update the post in the database
        $query = "UPDATE new_athletes SET athlete_name = :athlete_name, team = :team, bio = :bio, sport_id = :sport_id, image_path = :image_path WHERE athlete_id = :athlete_id";
        $statement = $db->prepare($query);
        $statement->bindParam(':athlete_id', $athlete_id, PDO::PARAM_INT);
        $statement->bindParam(':athlete_name', $athleteName);
        $statement->bindParam(':team', $team);
        $statement->bindParam(':sport_id', $sport_id);
        $statement->bindParam(':bio', $bio);
        $statement->bindParam(':image_path', $image_path);
        $statement->execute();
        
    } else {
        if (isset($_POST['is_image_delete']) && $_POST['is_image_delete'] == 'true') {
            // The checkbox is checked, take appropriate action
            $query = "UPDATE new_athletes SET athlete_name = :athlete_name, team = :team, bio = :bio, sport_id = :sport_id, image_path = :image_path WHERE athlete_id = :athlete_id";
            $statement = $db->prepare($query);
            $statement->bindParam(':athlete_id', $athlete_id, PDO::PARAM_INT);
            $statement->bindParam(':athlete_name', $athleteName);
            $statement->bindParam(':team', $team);
            $statement->bindParam(':sport_id', $sport_id);
            $statement->bindParam(':bio', $bio);
            $statement->bindParam(':image_path', $image_path, PDO::PARAM_NULL);
            $statement->execute();
        } else {
            // Query to update the post in the database
            $query = "UPDATE new_athletes SET athlete_name = :athlete_name, team = :team, bio = :bio, sport_id = :sport_id WHERE athlete_id = :athlete_id";
            $statement = $db->prepare($query);
            $statement->bindParam(':athlete_id', $athlete_id, PDO::PARAM_INT);
            $statement->bindParam(':athlete_name', $athleteName);
            $statement->bindParam(':team', $team);
            $statement->bindParam(':sport_id', $sport_id);
            $statement->bindParam(':bio', $bio);
            $statement->execute();
        }
       
    }
}

header('Location: AdminPage.php'); // Redirect to the home page

if (isset($_GET['athlete_id']) && is_numeric($_GET['athlete_id'])) {
    $athlete_id = (int)$_GET['athlete_id'];
    // Now $athlete_id is a safe integer to use in SQL queries.
} else {
    // Handle the case where the ID is not a valid integer (e.g., redirect the user).
}

// Prepare a SQL statement with placeholders
$query = "SELECT athlete_name, team, sport, bio FROM new_athletes WHERE athlete_id = :athlete_id";
$statement = $db->prepare($query);

// Bind the parameter with a safe value
$statement->bindParam(':athlete_id', $athlete_id, PDO::PARAM_INT);

// Execute the prepared statement
$statement->execute();

// Fetch the results
$post = $statement->fetch();

$athlete = filter_var($_POST['athlete_name'], FILTER_SANITIZE_STRING);
$team = filter_var($_POST['team'], FILTER_SANITIZE_STRING);
$sport = filter_var($_POST['sport'], FILTER_SANITIZE_STRING);
$bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);

?>