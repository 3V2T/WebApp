<?php
// Error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Define upload path
$upload_dir_pdf = '../uploads/books/';
$upload_dir_img = '../uploads/books-cover/';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file has been uploaded
    if (isset($_FILES['file-pdf']) && $_FILES['file-pdf']['error'] == 0) {
        $file_name = $_FILES['file-pdf']['name'];
        $file_tmp = $_FILES['file-pdf']['tmp_name'];

        // Validate file type
        $allowed_types = ['application/pdf'];
        if (!in_array($_FILES['file-pdf']['type'], $allowed_types)) {
            die('Only PDF files are allowed!');
        }

        // Generate a unique filename to prevent overwrites
        $new_filename = $file_name;

        // Move the uploaded file to the uploads directory
        if (move_uploaded_file($file_tmp, $upload_dir_pdf . $new_filename)) {
            // File uploaded successfully
            echo 'PDF file uploaded successfully!';
            // You can now store the file path in your database or process it further
        } else {
            die('Error uploading file!');
        }
    } else {
        echo "false";
    }

    // Repeat the same process for the image file
    if (isset($_FILES['file-anh']) && $_FILES['file-anh']['error'] == 0) {
        $file_name = $_FILES['file-anh']['name'];
        $file_tmp = $_FILES['file-anh']['tmp_name'];

        // Validate image type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['file-anh']['type'], $allowed_types)) {
            die('Only image files are allowed!');
        }

        $new_filename = $file_name;

        if (move_uploaded_file($file_tmp, $upload_dir_img . $new_filename)) {
            echo 'Image file uploaded successfully!';
            // Store the image path in your database or use it for display
        } else {
            die('Error uploading image file!');
        }
    }
}
