<?php

/*******w******** 
    
    Name: Jason Castillo
    Date: 2023-09-26    
    Description: CMS Project

****************/

require('connect.php');

$user_query = "SELECT * FROM users WHERE role = 'user'";
$user_statement = $db->prepare($user_query);
$user_statement->execute();
$user_datas = $user_statement->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>    
    <title>View Users</title>
</head>
<body>
    <div id = "header">
        <h1>Athlete Pro</h1>
    </div>

    <div id = "TextBoxOne">
        <a class="active" href="AdminPage.php">Home</a>
        <a class="active" href="admin_view_users.php">View Users</a>
        <a class="active" href="athlete_form.php">Create Post</a>    
        <a class="active" href="logout.php">Logout</a> 
        
        <form action="search_results_admin.php" method="get">
            <label for="search_query">Search:</label>
            <input type="text" name="search_query" id="search_query" required>
            <input type="submit" value="Search" id="search_query">
        </form>
    </div>

    <div>
        <button type="button" class="btn btn-primary">Add New User</button>
    </div>

    <table class="table container">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Email</th>
                <th scope="col">Username</th>
                <th scope="col">Password</th>
                <th scope="col">Role</th>
                <th scope="col">Update/Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($user_datas as $user_data) :?>
                <tr>
                    <th scope="row"><?php echo $user_data['id']?></th>
                    <td><?php echo $user_data['email']?></td>
                    <td><?php echo $user_data['username']?></td>
                    <td><?php echo $user_data['password']?></td>
                    <td><?php echo $user_data['role']?></td>
                    <td>
                        <a class="active" href="edit_user_form.php?id= <?php echo $user_data['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            
        </tbody>
    </table>
    
</body>
</html>