<?php

require_once "../../classes/PRTask.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\PRTask;

$con = DBConnector::getConnection();

if (isset($_POST['pr_update_submit_1'])) {
    $selectedMenuNo = $_POST['menuNo'];
    $prID = $_POST['pr_id'];
    $published = 0;
    if ($_POST['is_published'] == 'published') {
        $published = 1;
    }

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
if (isset($_POST['pr_update_submit_2'])) {
    $selectedMenuNo = $_POST['menuNo'];
    $prID = $_POST['pr_id'];
    $verified = 0;
    if ($_POST['is_verify'] == 'verified') {
        $verified = 1;
    }

    $PRTask = new PRTask($prID, null, null, null, null, null, null);
    $PRTask->loadTaskFromPRId($con);
    $PRTask->setisVerifyByProjectChair($verified);
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
