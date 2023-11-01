<?php

require_once '../../classes/DBConnector.php';
require_once '../../classes/PublicFlyer.php';

use classes\DBConnector;
use classes\PublicFlyer;

$con = DBConnector::getConnection();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['submit'])) {
        $fileError = $_FILES['flyerUpdateImg']['error'];


        if ($fileError == 4) {

            if (!empty($_POST["flyerId"]) && !empty($_POST["clubId"]) && !empty($_POST["flyerUpdateTopic"]) &&
                !empty($_POST["flyerUpdateCaption"]) && !empty($_POST["flyerUpdateLink"]) && !empty($_POST["flyerUpdateStartDate"]) &&
                !empty($_POST["flyerUpdateEndDate"]) && !empty($_POST["flyerUpdateImg2"])) {
                //assign form value
                $flyerId = $_POST["flyerId"];
                $clubId = $_POST["clubId"];
                $flyerUpdateTopic = strip_tags($_POST["flyerUpdateTopic"]);
                $flyerUpdateCaption = strip_tags($_POST["flyerUpdateCaption"]);
                $flyerUpdateLink = strip_tags($_POST["flyerUpdateLink"]);
                $flyerUpdateStartDate = strip_tags($_POST["flyerUpdateStartDate"]);
                $flyerUpdateEndDate = strip_tags($_POST["flyerUpdateEndDate"]);
                $flyerUpdateImage = ($_POST["flyerUpdateImg2"]);
                //call const....
                $updateDate = new PublicFlyer(null, null, null, null, null, null, null, null, null);

                $updateDate->setFlyerID($flyerId);
                $updateDate->setClubID($clubId);
                $updateDate->setFlyerTopic($flyerUpdateTopic);
                $updateDate->setCaption($flyerUpdateCaption);
                $updateDate->setLink($flyerUpdateLink);
                $updateDate->setStartDate($flyerUpdateStartDate);
                $updateDate->setEndDate($flyerUpdateEndDate);
                $updateDate->setFlyerImg($flyerUpdateImage);

                $rs = $updateDate->saveChangesToDatabase($con);
                   if($rs) {
                       header("location: ../../clubowner-dashboard.php?tab=4&error");
                   }else{
                       header("location: ../../clubowner-dashboard.php?tab=4&error");
                   }
            } else {
                //empty fileds
                header("location: ../../clubowner-dashboard.php?tab=4&error");
            }
        } else {
            if (!empty($_POST["flyerId"]) && !empty($_POST["clubId"]) && !empty($_POST["flyerUpdateTopic"]) &&
                !empty($_POST["flyerUpdateCaption"]) && !empty($_POST["flyerUpdateLink"]) && !empty($_POST["flyerUpdateStartDate"]) &&
                !empty($_POST["flyerUpdateEndDate"])) {


                $flyerUpdateImgNew = $_FILES['flyerUpdateImg']['name'];
                $flyerUpdateImgTmpName = $_FILES['flyerUpdateImg']['tmp_name'];
                $flyerUpdateImgSize = $_FILES['flyerUpdateImg']['size'];
                $flyerUpdateImgError = $_FILES['flyerUpdateImg']['error'];
                $flyerUpdateImgType = $_FILES['flyerUpdateImg']['type'];

                $fileExt = explode('.', $flyerUpdateImgNew);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'jpeg', 'png');


                if (in_array($fileActualExt, $allowed)) {
                    if ($flyerUpdateImgError === 0) {
                        if ($flyerUpdateImgSize < 10000000) {
                            $flyerNameNew = uniqid('', true) . "." . $fileActualExt;
                            $fileDestination='../../assets/images/flyer_img/'.$flyerNameNew;
                            if (move_uploaded_file(  $flyerUpdateImgTmpName,$fileDestination)){

                                $flyerId = $_POST["flyerId"];
                                $clubId = $_POST["clubId"];
                                $flyerUpdateTopic = strip_tags($_POST["flyerUpdateTopic"]);
                                $flyerUpdateCaption = strip_tags($_POST["flyerUpdateCaption"]);
                                $flyerUpdateLink = strip_tags($_POST["flyerUpdateLink"]);
                                $flyerUpdateStartDate = strip_tags($_POST["flyerUpdateStartDate"]);
                                $flyerUpdateEndDate = strip_tags($_POST["flyerUpdateEndDate"]);

                                $updateDate2 = new PublicFlyer(null, null, null, null, null, null, null, null, null);


                                $updateDate2->setFlyerID($flyerId);
                                $updateDate2->setClubID($clubId);
                                $updateDate2->setFlyerTopic($flyerUpdateTopic);
                                $updateDate2->setCaption($flyerUpdateCaption);
                                $updateDate2->setLink($flyerUpdateLink);
                                $updateDate2->setStartDate($flyerUpdateStartDate);
                                $updateDate2->setEndDate($flyerUpdateEndDate);
                                $updateDate2->setFlyerImg( $flyerNameNew);
                                $rs2 = $updateDate2->saveChangesToDatabase($con);

                                if($rs2) {
                                    $flyerUpdateImage = ($_POST["flyerUpdateImg2"]);
                                    $filename ='../../assets/images/flyer_img/'.$flyerUpdateImage;
                                    if (file_exists($filename)) {
                                        unlink($filename);
                                    }
                                    header("location: ../../clubowner-dashboard.php?tab=4&error");
                                }else{
                                    header("location: ../../clubowner-dashboard.php?tab=4&error");
                                }
                            }else{
                                //image not upload
                                header("location: ../../clubowner-dashboard.php?tab=4&error");
                            }
                        }else{
                            //image size
                            header("location: ../../clubowner-dashboard.php?tab=4&error");
                        }
                    }else{
                        //image file format
                        header("location: ../../clubowner-dashboard.php?tab=4&error");
                    }
                } else {
                    //image file format
                    header("location: ../../clubowner-dashboard.php?tab=4&error");

                }

                // $flyerId = $_POST["flyerId"];
                // $clubId = $_POST["clubId"];
                // $flyerUpdateTopic = strip_tags($_POST["flyerUpdateTopic"]);
                // $flyerUpdateCaption = strip_tags($_POST["flyerUpdateCaption"]);
                // $flyerUpdateLink = strip_tags($_POST["flyerUpdateLink"]);
                // $flyerUpdateStartDate = strip_tags($_POST["flyerUpdateStartDate"]);
                // $flyerUpdateEndDate = strip_tags($_POST["flyerUpdateEndDate"]);

            } else {
                //empty fileds
                header("location: ../../clubowner-dashboard.php?tab=4&error");
            }
        }


        // $updateDate = new PublicFlyer(null, null, null, null, null, null, null, null, null);

        // $updateDate->setFlyerID($flyerId);
        // $updateDate->setClubID($clubId);
        // $updateDate->setFlyerTopic($flyerUpdateTopic);
        // $updateDate->setCaption($flyerUpdateCaption);
        // $updateDate->setLink($flyerUpdateLink);
        // $updateDate->setStartDate($flyerUpdateStartDate);
        // $updateDate->setEndDate($flyerUpdateEndDate);
        // $rs = $updateDate->saveChangesToDatabase($con);

        // if ($rs) {
        //     header("location: ../../clubowner-dashboard.php?tab=4");
        // } else {
        //     header("location: ../../clubowner-dashboard.php?tab=4&error");
        // }


    } else {
        //is not submit
        header("location: ../../clubowner-dashboard.php?tab=4");
    }

} else {
    //is not post
    header("location: ../../clubowner-dashboard.php?tab=4");
}
