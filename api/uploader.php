<?php
$ds = DIRECTORY_SEPARATOR;  //1

$storeFolder = "wp-content{$ds}video_files";   //2

if (isset($_GET['delete'])) {

    $file = $_GET['delete'];
    $filePath = $_SERVER['DOCUMENT_ROOT'] . $ds . $storeFolder . $ds . $file;

    if(file_exists($filePath)) {
        unlink($filePath);
    }

    header('Location: /videos-admin/');
    exit;

} else if (!empty($_FILES)) {

    $tempFile = $_FILES['file']['tmp_name'];          //3

    $targetPath = $_SERVER['DOCUMENT_ROOT'] . $ds . $storeFolder . $ds;  //4

    $targetFile = $targetPath . $_FILES['file']['name'];  //5

    move_uploaded_file($tempFile, $targetFile); //6

    echo json_encode([
        "success" => '/' . $storeFolder . '/' . $_FILES['file']['name'],
    ]);

}