<?php

function downloadFile($file_name)
{
    // Set the appropriate headers
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $file_name);
    header('Content-Length: ' . filesize("../uploads/books/" . $file_name));

    // Output the file contents
    readfile("../uploads/books/" . $file_name);
}

$file_name = $_GET["file"];
echo $file_name;
downloadFile($file_name);
