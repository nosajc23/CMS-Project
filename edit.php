<?php

/*******w******** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/

require('connect.php');

// Get the Post ID from the URL
$post_id = $_GET['id']; // Number 4: Get the post ID from the URL

// Retrieve the post data from the database
$query = "SELECT athlete_name,team,sport,bio FROM athletes WHERE athlete_id = :athlete_id";
$statement = $db->prepare($query);
$statement->bindParam(':athlete_id', $post_id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Edit this Post!</title>
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
    <!-- Remember that alternative syntax is good and html inside php is bad -->
    <div class ="TextBoxFour container">
        <h1>Edit Athlete Page</h1>
            <form action="processeditpost.php" method="post">
                <label for="athlete_name">Athlete Name:</label>
                <input type="text" name="athlete_name" value="<?php echo $post['athlete_name']; ?>" class="form-control" required><br>
                <label for="team">Team:</label>
                <input type="text" name="team" value="<?php echo $post['team']; ?>" class="form-control" required><br>
                <label for="sport">Sport:</label>
                <input type="text" name="sport" value="<?php echo $post['sport']; ?>" class="form-control" required><br>
                <label for="bio">Bio:</label><br>
                <textarea name="bio" rows="4"  class="form-control" required><?php echo $post['bio']; ?></textarea><br>
                <input type="hidden" name="id" value="<?php echo $post_id; ?>">
                <input type="submit" name="update" value="Update Post"  class="btn btn-primary">
                <input type="submit" name="delete" value="Delete Post"  class="btn btn-danger">
            </form>
    </div>
</body>
</html>