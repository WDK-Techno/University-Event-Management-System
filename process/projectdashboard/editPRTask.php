<?php

require_once "../../classes/PRTask.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\PRTask;

$con = DBConnector::getConnection();

if (isset($_POST['pr_update_submit'])) {
    $selectedMenuNo = $_POST['menuNo'];
    $prID = $_POST['pr_id'];
    $published = 0;
    $verified = 0;
//    if (isset($_POST['is_published'])) {
//        if ($_POST['is_published'] == 'published') {
//            $published = 1;
//        } else {
//            $published = 0;
//            $verified = 0;
//        }
//    }
    if ($_POST['is_published'] == 'published') {
        $published = 1;
        $verified = 1;
    } else if ($_POST['is_verify'] == 'verified') {
        $published = 0;
        $verified = 1;
    } else {
        $verified =0;
        $published =0;
    }

//if (isset($_POST['is_verify'])) {
//    if ($_POST['is_verify'] == 'verified') {
//        $verified = 1;
//    } else {
//        $verified = 0;
//        $published = 0;
//    }
//}

    $PRTask = new PRTask($prID, null, null, null, null, null, null);
    $PRTask->loadTaskFromPRId($con);
    $PRTask->setisPublished($published);
    $rs = $PRTask->saveChangesToDatabase($con);

    if ($rs) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }
}

if (isset($_POST['pr_edit_submit'])) {
    $selectedMenuNo = $_POST['menuNo'];
    $PRId = $_POST['pr_id'];
    $PRTopic = $_POST['topic'];
    $PRDescription = $_POST['description'];
    $Designer = $_POST['designer_id'];
    $CaptionWritter = $_POST['caption_writer_id'];

    $PRTask = new PRTask($PRId, null, null, null, null, null, null);
    $PRTask->loadTaskFromPRId($con);
    $PRTask->settopic($PRTopic);
    $PRTask->setdescription($PRDescription);
    $PRTask->setdesignerID($PRDescription);
    $PRTask->setcaptionWriterID($PRDescription);


    $result = $PRTask->saveChangesToDatabase($con);

    if ($result) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }

}
