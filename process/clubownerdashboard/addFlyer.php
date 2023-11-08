<?php

require_once '../../classes/DBConnector.php';
require_once '../../classes/PublicFlyer.php';

use classes\DBConnector;
use classes\PublicFlyer;

$con = DBConnector::getConnection();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['submit'])) {
        if ($_FILES['fl_image']['error'] === UPLOAD_ERR_OK) {
            echo "Form submitted successfully.<br>";
            if (pathinfo($_FILES['fl_image']['name'])['extension'] == "jpg" ||
                pathinfo($_FILES['fl_image']['name'])['extension'] == "jpeg" ||
                pathinfo($_FILES['fl_image']['name'])['extension'] == "JPG" ||
                pathinfo($_FILES['fl_image']['name'])['extension'] == "png") {
                $fl_topic = strip_tags($_POST['topic']);
                $fl_caption = strip_tags($_POST['caption']);
                $startDate = $_POST['start_date'];
                $start_time = $_POST['start_time'];
                $endDate = $_POST['end_date'];
                $end_time = $_POST['end_time'];
                $club_id = $_POST['club_id'];
                $fl_link = $_POST['url'];


                $fl_StartDate = $startDate . " " . $start_time;
                $fl_EndDate = $endDate . " " . $end_time;

                // echo $fl_StartDate;
                //echo $fl_EndDate;
                $filename = $_FILES['fl_image']['name'];
                $tempname = $_FILES['fl_image']['tmp_name'];
                $fImgSize = $_FILES['fl_image']['size'];
                $ImgError = $_FILES['fl_image']['error'];
                $ImgType = $_FILES['fl_image']['type'];

                $fileExt = explode('.', $filename);
                $fileActualExt = strtolower(end($fileExt));

                $allowed = array('jpg', 'jpeg', 'png');


                if (in_array($fileActualExt, $allowed)) {
                    if ($ImgError === 0) {
                        if ($fImgSize < 10000000) {
                            $flyerNameNew = uniqid('', true) . "." . $fileActualExt;
                            $folder = "../../assets/images/flyer_img/" . $flyerNameNew;
                            if (move_uploaded_file($tempname, $folder)) {
                                echo "File moved successfully.<br>";
                                $publicFlyer = new PublicFlyer(null, $fl_StartDate, $fl_EndDate, $fl_caption, $fl_link, $flyerNameNew, $club_id, "active", $fl_topic);
                                $rs = $publicFlyer->addNewFlyer($con);

                                if ($rs) {
                                    header("location: ../../clubowner-dashboard.php?tab=4");
                                } else {
                                    header("location: ../../clubowner-dashboard.php?tab=4&err=3");
                                }
                            }
                        }
                    }
                }
            }
        }

    }
}

