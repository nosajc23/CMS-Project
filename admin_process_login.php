<!-- admin_process_login.php -->
<?php
// Database connection
require("connect.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check admin credentials
    $stmt = $db->prepare("SELECT * FROM users WHERE username = ? AND password = ? AND role = 'admin'");
    $stmt->execute([$username, $password]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['user_role'] = 'admin';
        header("Location: AdminPage.php");
        echo"Login was successful!";
        exit();
    } else {
        echo "Invalid credentials for admin login.";
    }
}
?>