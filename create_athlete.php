<?php
session_start();

// Database connection
try {
    $pdo = new PDO('mysql:host=localhost;dbname=serverside', 'serveruser', 'gorgonzola7!');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

    // Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $athlete = $_POST['athlete_name'];
    $team = $_POST['team'];
    $sport= $_POST['sport'];
    $bio = $_POST['bio'];

      // Image upload handling
      //$imagePath = handleImageUpload();

     // Validate and process image upload
    //  $imageType = exif_imagetype($tmpName);
 
        // Insert athlete data into the "athletes" table
        $stmt = $pdo->prepare("INSERT INTO athletes (athlete_name, team, sport, bio) VALUES (?, ?, ?, ?)");

        // Insert image path into the "images" table
        // $stmt = $pdo->prepare("INSERT INTO images (filename) VALUES (?)");
        // $stmt->execute([$uploadPath]);

    
        header('Location: AdminPage.php'); // Redirect to the home page

        if ($stmt->execute([$athlete, $team, $sport, $bio])) {
            $success_message = "Athlete added successfully.";
        } else {
            $error_message = "Error adding the athlete.";
        } 
    
}

// Function to handle image upload
// function handleImageUpload() {
//     if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
//         $tmpName = $_FILES['image']['tmp_name'];
//         $imageName = $_FILES['image']['name'];
        
//         // Check if the uploaded file is an image
//         $imageType = exif_imagetype($tmpName);

//         if ($imageType !== false) {
//             $uploadDir = 'uploads/';
//             $uploadPath = $uploadDir . $imageName;

//             // Move the image to the uploads folder
//             move_uploaded_file($tmpName, $uploadPath);

      
//             return $uploadPath;
//         } else {
//             echo "Invalid image format. Please upload a valid image.";
//             // You may want to redirect or display an error message here
//             exit();
//         }
//     }
//     return null;
// }


    
?>