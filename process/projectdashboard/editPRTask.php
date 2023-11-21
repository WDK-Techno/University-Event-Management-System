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
    if (empty($_POST['topic']) || empty($_POST['designer_id']) || empty($_POST['caption_writer_id'])) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }
    $PRTopic = $_POST['topic'];
    $PRDescription = $_POST['description'];
    $DesignerID = $_POST['designer_id'];
    $CaptionWriterID = $_POST['caption_writer_id'];
    $PRId = $_POST['pr_id'];
    $publishDate =$_POST['publish_date'];
    $publishTime =$_POST['publish_time'];


    $publishedDateTime = $publishDate." ".$publishTime;
    //    reduce two days from publish date
    $temp_date = date_create(strval($publishedDateTime));
    date_sub($temp_date,date_interval_create_from_date_string("2 days"));
    $designDeadline = date_format($temp_date,"Y-m-d H:i:s");

    if ($_POST['description'] == "") {
        $PRDescription = null;
    }
    $PRTask = new PRTask($PRId, null, null, null, null, null, null);
    $PRTask->loadTaskFromPRId($con);
    $PRTask->settopic($PRTopic);
    $PRTask->setdescription($PRDescription);
    $PRTask->setdesignerID($DesignerID);
    $PRTask->setcaptionWriterID($CaptionWriterID);
    $PRTask->setpublishDate($publishedDateTime);
    $PRTask->setdesignCompletingDeadline($designDeadline);

    $result = $PRTask->saveChangesToDatabase($con);

    if ($result) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }

}
