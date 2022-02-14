<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


/* Get the name of the uploaded file */
$filename = $_FILES['file']['name'];
function uploadFile($fileObj)
{
    $exceptedTypes = array("jpg", "png", "jpeg", "x-matroska");
    $fileType = strtolower(explode("/", $fileObj["type"])[1]);
    if (in_array($fileType, $exceptedTypes)) {
        if ($fileType != "x-matroska") {
            $fileName = uniqid("", true) . "." . $fileType;
            $fileDestination = "../media/img/" . $fileName;
            $responce = array(
                "url" => "http://localhost/chat/media/img/$fileName",
                "isUploaded" => true,
                "format" => "img"
            );

            echo json_encode($responce);
        } else {
            $fileName = uniqid("", true) . "." . "mp4";
            $fileDestination = "../media/video/" . $fileName;
            $responce = array(
                "url" => "http://localhost/chat/media/video/$fileName",
                "isUploaded" => true,
                "format" => "video"
            );
            echo json_encode($responce);
        }
        move_uploaded_file($fileObj["tmp_name"], $fileDestination);
        return $fileName;
    } else {
        echo json_encode(array("message" => "Invalid file type", "error" => true));
        die();
    }
}
/* Choose where to save the uploaded file */
try {
    $fileName = uploadFile($_FILES["file"]);
} catch (Exception $e) {
    echo json_encode(array("error" => true, "message" => "Invalid file type"));
    die();
}