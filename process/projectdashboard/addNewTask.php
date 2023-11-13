<?php
require_once "../../classes/PRTask.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\PRTask;

$con = DBConnector::getConnection();

if (isset($_POST['submit'])) {
    $selectedMenuNo = $_POST['menuNo'];
    if (empty($_POST['topic']) || empty($_POST['designer_id']) || empty($_POST['caption_writer_id'])) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }
    $PRTopic = $_POST['topic'];
    $PRDescription = $_POST['description'];
    $DesignerID = $_POST['designer_id'];
    $CaptionWriterID = $_POST['caption_writer_id'];
    $projectId = $_POST['project_id'];

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
    $PRTask = new PRTask(null,$publishedDateTime,$PRTopic,$PRDescription,$DesignerID,$CaptionWriterID,$projectId);
    $PRTask->setdesignCompletingDeadline($designDeadline);
    $result = $PRTask->addNewTask($con);

    if ($result) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
    }
}
