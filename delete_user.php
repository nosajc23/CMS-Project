<?php 
/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/

require('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirmed_delete'])) {
        // Check if the delete parameter is set to 'confirmed_delete'
        if ($_POST['confirmed_delete'] === 'delete' ) {
            // Query to delete the post from the database
            // Get the value of the post_id
            $id = $_POST['id'];

            $query = "DELETE FROM users WHERE id = :id";
            $statement = $db->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            
            // Redirect to the home page after the deletion
            header('Location: admin_view_users.php');
            exit(); // Ensure that no further code is executed after the redirection
        } else {
            // Handle other cases or show an error message
            echo "Invalid delete action!";
        }
    }
    else {
        // Redirect to the home page after the deletion
        header('Location: admin_view_users.php');
    }
}
?>