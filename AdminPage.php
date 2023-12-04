<?php

/*******w******** 
    
    Name: Jason Castillo
    Date: 2023-09-26    
    Description: CMS Project

****************/

require('connect.php');

// $athlete_query = "SELECT athlete_id,athlete_name,team,sport,bio,created_at,image_path FROM athletes ORDER BY created_at DESC";
$athlete_query = "SELECT * FROM new_athletes ORDER BY created_at DESC";
$athlete_statement = $db->prepare($athlete_query);
$athlete_statement->execute();
$athlete_datas = $athlete_statement->fetchAll();
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
    <title>Admin Page</title>
</head>
    <body style="background-color:white;">
        <!-- Remember that alternative syntax is good and html inside php is bad -->
        <div id = "header">
            <h1>Athlete Pro</h1>
        </div>

        <div id = "TextBoxOne">
            <a class="active" href="Homepage.php">Home</a>
            <a class="active" href="athlete_form.php">Create Post</a>    
            <a class="active" href="logout.php">Logout</a> 
            
            <form action="search_results_admin.php" method="get">
                <label for="search_query">Search:</label>
                <input type="text" name="search_query" id="search_query" required>
                <input type="submit" value="Search" id="search_query">
            </form>
        </div>

        <?php foreach ($athlete_datas as $athlete_data) :?>
            <div> 
                <h2>Athlete name: <?php echo $athlete_data['athlete_name']; ?></h2>
                <h3>Team: <?php echo $athlete_data['team']; ?></h3>
                <h3>Sports Name:
                    <?php
                        $sport_id = $athlete_data['sport_id'];

                        $sport_query = "SELECT * FROM sports WHERE sport_id = :sport_id";
                        $sport_statement = $db->prepare($sport_query);
                        $sport_statement->bindParam(':sport_id', $sport_id, PDO::PARAM_INT);
                        $sport_statement->execute();
                        $sport_data = $sport_statement->fetch();

                        if (!empty($sport_data)) {
                            echo htmlspecialchars($sport_data['sport_name']);
                        } else {
                            echo "Unknown Sport";
                        }
                    ?>
                </h3>
                <h4><p>Bio: <?php echo $athlete_data['bio']; ?></p></h4>

                <div class="post">
                    <p><?php echo date('F d, Y, h:i a', strtotime($athlete_data['created_at'])); ?></p>
                </div>

                <div class ="edit_test">
                    <a href="edit.php?id= <?php echo $athlete_data['athlete_id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                </div>

            </div>
        <?php endforeach; ?>
    </body>
</html>