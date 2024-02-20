<?php

function downloadFile($file_path, $file_name)
{
    // Set the appropriate headers
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Content-Length: ' . filesize($file_path));

    // Output the file contents
    readfile($file_path);
}

$file_path = $_GET("path");
$file_name = $_GET("name");
downloadFile($file_path, $file_name);
