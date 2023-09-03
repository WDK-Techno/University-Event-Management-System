<?php

require_once "../../classes/DBConnector.php";
require_once "../../classes/User.php";

use classes\DBConnector;
use classes\Club;


$con = DBConnector::getConnection();

$message = "";

if(isset($_POST['image_save_submit'])){
    $file = $_FILES['image_upload'];
    $selectedMenuNo = $_POST['menuNo'];
    $clubID = $_POST['club_id'];
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
                $fileDestination = '../../assets/images/profile_img/club/'.$fileNameNew;
                if (move_uploaded_file($fileTmpName,$fileDestination)){

                    $club = new Club(null,null,null,null);
                    $club->setUserId($clubID);
                    $club->loadDataFromUserID($con);
                    $club->setProfileImage($fileNameNew);
                    $rs =  $club->saveChangesToDatabase($con);
                    if ($rs){
                        header("location: ../../clubowner-dashboard.php?tab={$selectedMenuNo}");
                    }else{
                        header("location: ../../clubowner-dashboard.php?tab={$selectedMenuNo}&imgUploadErr=1");
                    }

                }else{

                    header("location: ../../clubowner-dashboard.php?tab={$selectedMenuNo}&imgUploadErr=2");
                }
            }else{
                header("location: ../../clubowner-dashboard.php?tab={$selectedMenuNo}&imgUploadErr=3");
            }
        }else{
            header("location: ../../clubowner-dashboard.php?tab={$selectedMenuNo}&imgUploadErr=4");
        }
    }else{
        header("location: ../../clubowner-dashboard.php?tab={$selectedMenuNo}&imgUploadErr=5");
    }
}
