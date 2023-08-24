<?php

require_once "../../classes/DBConnector.php";
require_once "../../classes/Project.php";

use classes\DBConnector;
use classes\Project;


$con = DBConnector::getConnection();

$message = "";

if(isset($_POST['image_save_submit'])){
    $file = $_FILES['image_upload'];
    $selectedMenuNo = $_POST['menuNo'];
    $projectID = $_POST['project_id'];
//    echo "<pre>";
//    print_r($file);
//    echo "</pre>";
    $fileName = $_FILES['image_upload']['name'];
    $fileTmpName = $_FILES['image_upload']['tmp_name'];
    $fileSize = $_FILES['image_upload']['size'];
    $fileError = $_FILES['image_upload']['error'];
    $fileType = $_FILES['image_upload']['type'];

    $fileExt = explode('.',$fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg','jpeg','png');

    if (in_array($fileActualExt,$allowed)){
        if ($fileError === 0){
            if ($fileSize<10000000){
                $fileNameNew = uniqid('',true).".".$fileActualExt;
                $fileDestination = '../../assets/images/profile_img/project/'.$fileNameNew;
                if (move_uploaded_file($fileTmpName,$fileDestination)){

                    $project  = new Project($projectID,null,null,null,null,null,null);
                    $project->loadDataFromProjectID($con);
                    $project->setProfileImage($fileNameNew);
                    $rs =  $project->saveChangesToDataBase($con);
                    if ($rs){
                        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
                    }else{
                        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&imgUploadErr=1");
                    }

                }else{

                    header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&imgUploadErr=2");
                }
            }else{
                header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&imgUploadErr=3");
            }
        }else{
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&imgUploadErr=4");
        }
    }else{
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&imgUploadErr=5");
    }
}
