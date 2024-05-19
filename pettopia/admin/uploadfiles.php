<?php

function uploadFile($file, $title){
    // Folder to upload
    $folderUpload = "../uploads";
    $filename = basename($file["name"]);
    $filetype = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    $fileNameTarget = str_replace(" ", "_", $title);
    // File destination path
    $fileDestination = $folderUpload . "/" . $fileNameTarget . "." . $filetype; // uploads/anh_san_pham_1.png
    
    // Check if the file type is jpg
    if ($filetype != "jpg") {
        return false;
    }
    // Limit file size to 2MB: 1000 * 1024 * 2
    if ($file["size"] > (1000 * 1024 * 2)) {
        return false;
    }
    
    // Upload file
    if (move_uploaded_file($file["tmp_name"], $fileDestination)) {
        // Return the path to the uploaded file
        return $fileDestination;
    } else {
        return false;
    }
}
