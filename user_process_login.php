<!-- user_process_login.php -->
<?php
session_start();

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=serverside;', 'serveruser', 'gorgonzola7!');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check user credentials
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND role = 'user'");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = 'user';
        header("Location: UserPage.php");
        exit();
    } else {
        echo "Invalid credentials for user login.";
    }
}
?>