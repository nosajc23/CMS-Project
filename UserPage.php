<?php

/*******w******** 
    
    Name: Jason Castillo
    Date: 2023-09-26    
    Description: CMS Project

****************/

require('connect.php');

$athlete_query = "SELECT athlete_id,athlete_name,team,sport,bio,created_at FROM new_athletes ORDER BY created_at DESC";
$comment_query = "SELECT name, comment, timestamp FROM comments";

$athlete_statement = $db->prepare($athlete_query);
$athlete_statement->execute();
$posts = $athlete_statement->fetchAll();

$comment_statement = $db->prepare($comment_query);
$comment_statement->execute();
$getComments = $comment_statement->fetchAll();

session_start();
$status = '';
if ( isset($_POST['captcha']) && ($_POST['captcha']!="") ){
// Validation: Checking entered captcha code with the generated captcha code
if(strcasecmp($_SESSION['captcha'], $_POST['captcha']) != 0){
// Note: the captcha code is compared case insensitively.
// if you want case sensitive match, check above with strcmp()
$status = "<p style='color:#FFFFFF; font-size:20px'>
<span style='background-color:#FF0000;'>Entered captcha code does not match! 
Kindly try again.</span></p>";
}else{
$status = "<p style='color:#FFFFFF; font-size:20px'>
<span style='background-color:#46ab4a;'>Your captcha code is match.</span>
</p>";	
	}
}
echo $status;


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
        <title>User Page</title>
    </head>
        <body style="background-color:white;">
            <!-- Remember that alternative syntax is good and html inside php is bad -->
            <div id = "header">
                <h1>Athlete Pro</h1>
            </div>

            <div id = "TextBoxOne">
                <a class="active" href="UserPage.php">Home</a>
                <a class="active" href="logout.php">Logout</a> 
                
                <form action="search_results_user.php" method="get">
                    <label for="search_query">Search:</label>
                    <input type="text" name="search_query" id="search_query" required>
                    <input type="submit" value="Search" id="search_query">
                </form>

            </div>
            <?php foreach ($posts as $post) :?>
                <div> 
                    <h2>Athlete name: <?php echo $post['athlete_name']; ?></h2>
                    <h3>Team: <?php echo $post['team']; ?></h3>
                    <h3>Sports: <?php echo $post['sport']; ?></h3>
                    <h4><p>Bio: <?php echo $post['bio']; ?></p></h4>
                
                    <div class="post">
                        <p><?php echo date('F d, Y, h:i a', strtotime($post['created_at'])); ?></p>
                    </div>
                       <!-- Comment Form -->
                        <form method="post" action="comment.php">
                        <label for="name">Name:</label>
                        <input type="text" name="name" id="name" required><br>
                        
                        <label for="comment">Comment:</label>
                        <textarea name="comment" id="comment" required></textarea><br>

                        <input type="hidden" name="page" value="<?php echo $current_page; ?>">
                    
                        <label><strong>Enter Captcha:</strong></label><br />
                        <input type="text" name="captcha" />
                        <p><br />
                        <img src="captcha_image.php?rand=<?php echo rand(); ?>" id='captcha_image'>
                        </p>
                        <p>Can't read the image?
                        <a href='javascript: refreshCaptcha();'>click here</a>
                        to refresh</p>
                        <input type="submit" value="Submit Comment">
                    </form>
                    <br>
          

                </div>
            <?php endforeach; ?>

         

            <!-- Display Comments -->
            <h2>Comments:</h2>
            <?php
                foreach($getComments as $comment) :?>
                    <?php echo "<h4><strong>{$comment['name']}</strong> {$comment['comment']} <br>({$comment['timestamp']})</br></h4>";?>
            <?php endforeach; ?>

        </body>
</html>

<script>
//Refresh Captcha
function refreshCaptcha(){
    var img = document.images['captcha_image'];
    img.src = img.src.substring(
		0,img.src.lastIndexOf("?")
		)+"?rand="+Math.random()*1000;
}
</script>

