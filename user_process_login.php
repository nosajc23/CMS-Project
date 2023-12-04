<!-- user_process_login.php -->
<?php
/*************** 
    
    Name: Jason Castillo    
    Date: 2023-09-26
    Description: CMS Project

****************/
// Database connection
require("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check user credentials
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND role = 'user'");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = 'user';
        header("Location: UserPage.php");
        exit();
    } else {
        echo "Invalid credentials for user login.";
    }
}
?>