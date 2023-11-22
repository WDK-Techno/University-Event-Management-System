<?php
require_once "../../classes/DBConnector.php";
require_once "../../classes/MainTask.php";
require_once "../../classes/SubTask.php";

use classes\DBConnector;
use classes\MainTask;
use classes\SubTask;

$con = DBConnector::getConnection();

if (isset($_POST['submit'])) {
    $selectedMenuNo = $_POST['menuNo'];
    $subTaskID = $_POST['sub_task_id'];

    $subTask = new SubTask($subTaskID,null,null,null,null,null,null,null);
    $subTask->loadSubTaskFromSubTaskID($con);
    $rs = $subTask->deleteSubTask($con);

    if ($rs) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
    }
}

