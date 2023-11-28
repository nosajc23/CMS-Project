<?php
session_start();

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=serverside', 'serveruser', 'gorgonzola7!');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Process user registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $confirm_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match. Please try again.";
    } else {
        // Hash the password before storing in the database
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert user data into the "users" table
        $stmt = $pdo->prepare("INSERT INTO users (email, username, password, role) VALUES (?, ?, ?, 'user')");

        if ($stmt->execute([$email, $username, $password])) {
            $success_message = "Registration successful. You can now log in.";
        } else {
            $error_message = "Error registering user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Registration</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>    
</head>
<body>

<div class="container mt-5">
    <h1>User Registration</h1>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form action="register.php" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="username" class="form-control" name="username" id="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <p class="mt-3">Already have an account? <a href="user_login.php">Log in here</a>.</p>
</div>

</body>
</html>
