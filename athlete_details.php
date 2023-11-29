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

// Fetch athlete details
if (isset($_GET['athlete_id'])) {
    $athlete_id = $_GET['athlete_id'];

    $stmt = $pdo->prepare("SELECT * FROM athletes WHERE athlete_id = ?");
    $stmt->execute([$athlete_id]);
    $athlete = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch comments for the athlete
    $stmt_comments = $pdo->prepare("SELECT * FROM comments WHERE athlete_id = ? ORDER BY created_at DESC");
    $stmt_comments->execute([$athlete_id]);
    $comments = $stmt_comments->fetchAll(PDO::FETCH_ASSOC);
}

// Process comment form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_name = isset($_POST['comment_name']) ? $_POST['comment_name'] : 'Anonymous';
    $comment_content = $_POST['comment_content'];

    // Insert comment into the "comments" table
    $stmt_insert_comment = $pdo->prepare("INSERT INTO comments (athlete_id, comment_name, comment_content) VALUES (?, ?, ?)");
    $stmt_insert_comment->execute([$athlete_id, $comment_name, $comment_content]);

    // Redirect to avoid form resubmission on page refresh
    header("Location: athlete_details.php?athlete_id=$athlete_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Athlete Details</title>
</head>
<body>
    <!-- Comment Form -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Leave a Comment</h5>
            <form action="athlete_details.php?athlete_id=<?php echo $athlete_id; ?>" method="post">
                <div class="form-group">
                    <label for="comment_name">Name:</label>
                    <input type="text" class="form-control" name="comment_name" id="comment_name">
                </div>
                <div class="form-group">
                    <label for="comment_content">Comment:</label>
                    <textarea class="form-control" name="comment_content" id="comment_content" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
    </div>
    <!-- Display Comments -->
    <div class="mt-4">
        <h5>Comments</h5>
        <?php if (!empty($comments)): ?>
            <ul class="list-group">
                <?php foreach ($comments as $comment): ?>
                    <li class="list-group-item">
                        <strong><?php echo $comment['name']; ?>:</strong>
                        <?php echo $comment['content']; ?>
                        <small class="text-muted float-right"><?php echo date('F j, Y, g:i a', strtotime($comment['created_at'])); ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No comments yet.</p>
        <?php endif; ?>
    </div>

</body>
</html>
