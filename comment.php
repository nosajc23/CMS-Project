<?php
$host = 'localhost';
$dbname = 'serverside';
$user = 'serveruser';
$password = 'gorgonzola7!';



try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to add a new comment to the database
function addComment($name, $comment, $page) {
    global $pdo;

    $stmt = $pdo->prepare("INSERT INTO comments (name, comment, page, timestamp) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$name, $comment, $page]);
}

// Function to get comments for a specific page
function getComments($page) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM comments WHERE page = ? ORDER BY timestamp DESC");
    $stmt->execute([$page]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $comment = $_POST['comment'];
    $page = $_POST['page'];

    // Validate input
    if (!empty($comment) && !empty($page)) {
        // If name is empty, set it to "Anonymous"
        $name = empty($name) ? "Anonymous" : $name;

        // Add the comment to the database
        addComment($name, $comment, $page);
    }
}

header('Location: UserPage.php');

// Display comments for the current page
$current_page = basename($_SERVER['PHP_SELF']);
$comments = getComments($current_page);
?>