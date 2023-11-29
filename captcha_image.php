<?php
session_start();

// Function to generate a random CAPTCHA code
function generateCaptchaCode($length = 5) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $code;
}

// Generate a new CAPTCHA code and store it in the session
$captchaCode = generateCaptchaCode();
$_SESSION['captcha'] = strtoupper($captchaCode); // Store in uppercase for case-insensitive comparison

// Set the content type to PNG image
header('Content-type: image/png');

// Create a blank image with a white background
$image = imagecreatetruecolor(120, 40);
$background_color = imagecolorallocate($image, 255, 255, 255);
imagefill($image, 0, 0, $background_color);

// Add random lines to the image for noise
for ($i = 0; $i < 5; $i++) {
    $line_color = imagecolorallocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
    imageline($image, rand(0, 120), rand(0, 40), rand(0, 120), rand(0, 40), $line_color);
}

// Add the CAPTCHA text to the image
$text_color = imagecolorallocate($image, 0, 0, 0);
imagettftext($image, 20, 0, 10, 30, $text_color, 'C:\Users\jason\Downloads\sixty\SIXTY.TTF', $captchaCode);

// Output the image as PNG
imagepng($image);

// Free up memory
imagedestroy($image);
?>
