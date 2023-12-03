<?php
/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/
session_start();

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=serverside', 'serveruser', 'gorgonzola7!');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

    // Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $athlete = $_POST['athlete_name'];
    $team = $_POST['team'];
    $sport= $_POST['sport'];
    $bio = $_POST['bio'];

    if($_FILES['image_path']['name'] != null) {
        // image to be uploaded
        $image_path= $_POST['image_path']['name'];
        require("fileUpload.php"); 
        $stmt = $pdo->prepare("INSERT INTO athletes (athlete_name, team, sport, bio, image_path) VALUES (?, ?, ?, ?,?)");
        header('Location: AdminPage.php'); // Redirect to the home page
    
        if ($stmt->execute([$athlete, $team, $sport, $bio, $image_path])) {
            $success_message = "Athlete added successfully.";
        } else {
            $error_message = "Error adding the athlete.";
        } 
        
    } else {
        // Insert athlete data into the "athletes" table
        $stmt = $pdo->prepare("INSERT INTO athletes (athlete_name, team, sport, bio) VALUES (?, ?, ?, ?)");
        header('Location: AdminPage.php'); // Redirect to the home page
    
        if ($stmt->execute([$athlete, $team, $sport, $bio])) {
            $success_message = "Athlete added successfully.";
        } else {
            $error_message = "Error adding the athlete.";
        } 
        
    }
}

    
?>