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
    if ($_POST['description'] == "") {
        $PRDescription = null;
    }
    $PRTask = new PRTask(null, null, null, $PRTopic, $PRDescription, $DesignerID, null, $CaptionWriterID, null, null, null, $projectId, null);
    $result = $PRTask->addNewTask($con);

    if ($result) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
    }
}
