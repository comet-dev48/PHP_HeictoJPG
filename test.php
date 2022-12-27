<?php 

require_once('vendor/autoload.php');

use \ConvertApi\ConvertApi;

// $target_dir = "assets/image/";
// $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
// move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
function convertHEICtoJPG($file_path){
    $imageFileType = strtolower(pathinfo($file_path,PATHINFO_EXTENSION));
    if($imageFileType != "heic") {
        echo "Sorry, only HEIC file is allowed.";
        return;
    }
    ConvertApi::setApiSecret('SagNxe4gkrfDkUxx');
    try {
        $original_name = basename($file_path, ".heic");
        $target_dir = "assets/img/" . $original_name . ".jpg";
        $result = ConvertApi::convert('jpg', ['File' => $file_path,], 'heic');
        if (!file_exists($target_dir)) {
            $result->saveFiles($target_dir);
        }else{
            $date = new DateTime();
            $str_date = $date->format('Y_m_d_H_i_s');
            $target_dir = "assets/img/" . $str_date . ".jpg";
            $result->saveFiles($target_dir);
        }
        return $target_dir;
    } catch (\ConvertApi\Error\Api $error) {
        echo "Got API error code: " . $error->getCode() . "\n";
        echo $error->getMessage();
    }
}
$file_path = "assets/img/image.heic";
$converted_path = convertHEICtoJPG($file_path);
if(file_exists($converted_path)){
    echo "file converted to JPG";
} else {
    echo "ERROR: impossible to convert the file";
}
?>