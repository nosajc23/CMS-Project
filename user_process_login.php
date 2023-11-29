<!-- user_process_login.php -->
<?php
/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/
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
    
    // Hash the password (you should use password_hash in a real-world scenario)
   // $hashedPassword = md5($password);

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