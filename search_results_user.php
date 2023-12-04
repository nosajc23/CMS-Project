<?php
/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/
session_start();

// Database connection
require('connect.php');


// Process search query
if (isset($_GET['search_query'])) {
    $searchQuery = '%' . $_GET['search_query'] . '%';

    // Search in athletes table
    $stmt = $db->prepare("SELECT * FROM new_athletes WHERE athlete_name LIKE :query OR team LIKE :query OR bio LIKE :query");
    $stmt->bindParam(':query', $searchQuery, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Search Results</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1 class="mb-4">Search Results</h1>

    <?php if (isset($results) && count($results) > 0): ?>
        <div class="list-group">
            <?php foreach ($results as $result): ?>
                <div class="list-group-item">
                    <h5 class="mb-1"><?php echo $result['athlete_name']; ?></h5>
                    <p class="mb-1"><strong>Team:</strong> <?php echo $result['team']; ?></p>
                    <p class="mb-1">
                        <strong>Sports Name:</strong>
                        <!-- <?php echo $result['sport_id']; ?> -->
                        <?php
                            $sport_id = $result['sport_id'];

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
                    </p>
                    <p class="mb-1"><strong>Bio:</strong> <?php echo $result['bio']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info" role="alert">
            No results found.
        </div>
    <?php endif; ?>

    <p class="mt-3"><a href="UserPage.php" class="btn btn-primary">Back to User Home</a></p>
</div>

<!-- Bootstrap JS and Popper.js -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
