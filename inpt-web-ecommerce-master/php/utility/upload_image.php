<?php
header("Access-Control-Allow-Origin: *");

// Access the $_FILES global variable for this specific file being uploaded
// and create local PHP variables from the $_FILES array of information
$fileName = $_FILES["file"]["name"]; // The file name
$fileTmpLoc = $_FILES["file"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file"]["type"]; // The type of file it is
$fileSize = $_FILES["file"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file"]["error"]; // 0 for false... and 1 for true
$fileName = preg_replace('#[^a-z.0-9]#i', '', $fileName); // filter the $filename
$kaboom = explode(".", $fileName); // Split file name into an array using the dot
$fileExt = end($kaboom); // Now target the last array element to get the file extension
$id_produit = $_POST["id_produit"]; // Now target the last array element to get the file extension

// START PHP Image Upload Error Handling --------------------------------
if (!$fileTmpLoc) { // if file not chosen
    echo json_encode(array("code" => 701, "message" => "aucun fichier"));
    exit();
} else if ($fileSize > 5242880) { // if file size is larger than 5 Megabytes
    echo json_encode(array("code" => 701, "message" => "file size is larger than 5 Megabytes"));
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
} else if (!preg_match("/.(gif|jpg|png)$/i", $fileName)) {
    // This condition is only if you wish to allow uploading of specific file types    
    echo json_encode(array("code" => 701, "message" => "ONLY JPG/PNG/GIF"));
    unlink($fileTmpLoc); // Remove the uploaded file from the PHP temp folder
    exit();
} else if ($fileErrorMsg == 1) { // if file upload error key is equal to 1
    echo json_encode(array("code" => 701, "message" => "An error occured while processing the file. Try again."));

    exit();
}
$target_file = $_SERVER["DOCUMENT_ROOT"] . "/img/products/$fileName";
// END PHP Image Upload Error Handling ----------------------------------
// Place it into your "uploads" folder mow using the move_uploaded_file() function
$moveResult = move_uploaded_file($fileTmpLoc, $target_file);
// Check to make sure the move result is true before continuing
if ($moveResult != true) {
    echo json_encode(array("code" => 701, "message" => "File not uploaded. Try again."));

    exit();
}
// Include the file that houses all of our custom image functions
require_once "php_img_lib.php";
// ---------- Start Universal Image Resizing Function --------

$resized_file = $_SERVER["DOCUMENT_ROOT"] . "/img/products/$id_produit." . $fileExt;
$wmax = 500;
$hmax = 500;
ak_img_resize($target_file, $resized_file, $wmax, $hmax, $fileExt);
unlink($target_file);

// ----------- End Universal Image Resizing Function ----------
// ---------- Start Convert to JPG Function --------
if (strtolower($fileExt) != "jpg") {
    $target_file2 = $resized_file;
    $new_jpg = $_SERVER["DOCUMENT_ROOT"] . "/img/products/" . $id_produit . ".jpg";
    ak_img_convert_to_jpg($target_file2, $new_jpg, $fileExt);
    unlink($target_file2);
}

// ----------- End Convert to JPG Function -----------
// Display things to the page so you can see what is happening for testing purposes
echo json_encode(array("code" => 200, "message" => "The file named <strong>$fileName</strong> uploaded successfuly.<br /><br />"));
