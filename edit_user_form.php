<?php

/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/

require('connect.php');

// Get the Post ID from the URL
$id = $_GET['id']; // Number 4: Get the post ID from the URL

$query = "SELECT * FROM users WHERE id = :id";
$statement = $db->prepare($query);
$statement->bindParam(':id', $id, PDO::PARAM_INT);
$statement->execute();
$user = $statement->fetch();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
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
         <h1>Edit User</h1>
        <form action="update_user.php" method="POST" enctype="multipart/form-data">
            <label for="email">Email:</label>
            <input type="text" name="email" class="form-control" required  value="<?php echo $user['email']; ?>"> <br>

            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control" required  value="<?php echo $user['username']; ?>"> <br>
            
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit"  class="btn btn-primary" value="Update User">
            
        </form>

        <br/>
        <form id="deleteForm" action="delete_user.php" method="post">
            <?php
                // Remove all non-numeric characters from $id
                $id = preg_replace("/[^0-9]/", "", $id);
            ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="delete" class="btn btn-danger" value="delete" onclick="confirmAndSubmit()">
        </form>
        <br/>
    </div>
   
 </body>
</html>

<script>
    function confirmAndSubmit() {
        // Ask for confirmation
        let result = confirm("Are you sure you want to delete?");

        // If the user confirms, update the form and submit
        if (result) {
            // Update the name attribute
            document.getElementById('deleteForm').elements['delete'].name = 'confirmed_delete';

            // Submit the form
            document.getElementById('deleteForm').submit();
        } else {
            // If the user cancels, prevent the form submission
            return false;
        }
    }
</script>