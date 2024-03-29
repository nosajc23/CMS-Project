<?php

/*******w******** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/

require('connect.php');

// Get the Post ID from the URL
$post_id = $_GET['id']; // Number 4: Get the post ID from the URL

$query = "SELECT * FROM new_athletes WHERE athlete_id = :athlete_id";
$statement = $db->prepare($query);
$statement->bindParam(':athlete_id', $post_id, PDO::PARAM_INT);
$statement->execute();
$post = $statement->fetch();

$sport_query = "SELECT * FROM sports";
$sport_statement = $db->prepare($sport_query);
$sport_statement->execute();
$sports = $sport_statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link
        href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css"rel="stylesheet"type="text/css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="path/to/tinymce/tinymce.min.js"></script>

    <script>tinymce.init({
        selector: 'textarea#default-editor'
        });
    </script>
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
            <form action="processeditpost.php" method="post" enctype="multipart/form-data">
                <br/>
                <img src="./uploads/<?php echo $post['image_path']?>" alt="<?php echo $post['image_path']?>" class="mt-3"/>
                <br/>
                <label for="is_image_delete">Do you want to delete this image?</label>
                <input type="checkbox" id="is_image_delete" name="is_image_delete" value="true">
                <br/>
                <label for="athlete_name">Athlete Name:</label>
                <input type="text" name="athlete_name" value="<?php echo $post['athlete_name']; ?>" class="form-control" required><br>

                <label for="team">Team:</label>
                <input type="text" name="team" value="<?php echo $post['team']; ?>" class="form-control" required><br>

                <label for="sport">Sport:</label>            
                <select name="sport" id="sport" class="form-control">
                    <?php
                        foreach ($sports as $sport) {
                            echo '<option value="' . $sport['sport_id'] . '">' . $sport['sport_name'] . '</option>';
                        }
                    ?>
                </select>

                <label for="bio">Bio:</label><br>
                <textarea id = "myEditor" name="bio" rows="4"  class="form-control" required><?php echo $post['bio']; ?></textarea><br>

                <input type="file" name="image_path" accept=".jpg, .png, .gif, .pdf"><br>

                <input type="hidden" name="id" value="<?php echo $post_id; ?>">

                <input type="submit" name="update" value="Update Post"  class="btn btn-primary">
            </form>
            <br/>
            <form id="deleteForm" action="delete_athlete.php" method="post">
                <?php
                    // Remove all non-numeric characters from $post_id
                    $numeric_post_id = preg_replace("/[^0-9]/", "", $post_id);
                ?>
                <input type="hidden" name="id" value="<?php echo $numeric_post_id; ?>">
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

