<?php

/*******w******** 
    
    Name: Jason Castillo
    Date: 2023-11-03
    Description: FileUploads

****************/


    $targetDir = "uploads/";  // Create an "uploads" directory to store uploaded files

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (isset($_FILES["fileToUpload"])) {
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading file.";
        }
    }

    $targetDir = "uploads/";

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (isset($_FILES["fileToUpload"])) {
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $fileType = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);

        $allowedTypes = array("image/jpeg", "image/png", "image/gif", "application/pdf");

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                echo "File uploaded successfully.";
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, GIF, and PDF files are allowed.";
        }
    }

    require 'C:\xampp\htdocs\WD2\assignments\Module 6 Cookies and Sessions\C7 Starting Files\ImageResize.php';
    require 'C:\xampp\htdocs\WD2\assignments\Module 6 Cookies and Sessions\C7 Starting Files\ImageResizeException.php';

    $targetDir = "uploads/";

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    if (isset($_FILES["fileToUpload"])) {
        $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);
        $fileType = mime_content_type($_FILES["fileToUpload"]["tmp_name"]);

        $allowedTypes = array("image/jpeg", "image/png", "image/gif", "application/pdf");

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                echo "File uploaded successfully.";

                // Check if it's an image and resize
                if (in_array($fileType, ["image/jpeg", "image/png", "image/gif"])) {
                    $image = new ImageResize($targetFile);
                    $image->save("uploads/original_" . basename($targetFile));

                    $image->resizeToWidth(400);
                    $image->save("uploads/original_medium_" . basename($targetFile));

                    $image->resizeToWidth(50);
                    $image->save("uploads/original_thumbnail_" . basename($targetFile));
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, GIF, and PDF files are allowed.";
        }
    }

?>

