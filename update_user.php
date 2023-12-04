<?php 
/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/

require('connect.php');
$id = $_POST['id'];

$email = $_POST['email'];
$username = $_POST['username'];

$query = "UPDATE users SET email = :email, username = :username WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->bindParam(':email', $email);
$statement->bindParam(':username', $username);
$statement->execute();

header('Location: admin_view_users.php'); // Redirect to the home page
?>