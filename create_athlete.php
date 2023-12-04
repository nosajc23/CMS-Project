<?php
/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/
session_start();

// Database connection
require("connect.php");

    // Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $athlete = $_POST['athlete_name'];
    $team = $_POST['team'];
    $sport_id= $_POST['sport'];
    $bio = $_POST['bio'];

    if($_FILES['image_path']['name'] != null) {
        // image to be uploaded
        $image_path= $_FILES['image_path']['name'];
        require("fileUpload.php"); 
        $stmt = $db->prepare("INSERT INTO new_athletes (athlete_name, team, bio, image_path, sport_id) VALUES (?, ?, ?, ?, ?)");
    
        if ($stmt->execute([$athlete, $team, $bio, $image_path, $sport_id])) {
            $success_message = "Athlete added successfully.";
        } else {
            $error_message = "Error adding the athlete.";
        } 
        
    } else {
        // Insert athlete data into the "athletes" table
        $stmt = $db->prepare("INSERT INTO new_athletes (athlete_name, team, bio, sport_id) VALUES (?, ?, ?, ?)");
    
        if ($stmt->execute([$athlete, $team, $bio, $sport_id])) {
            $success_message = "Athlete added successfully.";
        } else {
            $error_message = "Error adding the athlete.";
        } 
        
    }

    header('Location: AdminPage.php'); // Redirect to the home page
}

    
?>