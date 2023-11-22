<?php

require_once "../../classes/DBConnector.php";
require_once "../../classes/MainTask.php";
require_once "../../classes/SubTask.php";

use classes\DBConnector;
use classes\MainTask;
use classes\SubTask;

$con = DBConnector::getConnection();

if (isset($_POST['edit_sub_task'])) {
    $selectedMenuNo = $_POST['menuNo'];

    if (empty($_POST['main_task']) || empty($_POST['sub_task']) ||
        empty($_POST['selected-team-cat-members']) || empty($_POST['completion_date']) || empty($_POST['completion_time'])) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    } else {
        $subTaskID = $_POST['sub_task_id'];
        $mainTaskID = $_POST['main_task'];
        $subTaskName = $_POST['sub_task'];
        $desc = $_POST['description'];
        $memberID = $_POST['selected-team-cat-members'];
        if ($_POST['sub_task'] == "") {
            $desc = null;
        }
        $completionDate = $_POST['completion_date'];
        $completionTime = $_POST['completion_time'];

        $deadline = $completionDate . " " . $completionTime;

        $subTask = new SubTask($subTaskID,null,null,null,null,null,null,null);
        $subTask->loadSubTaskFromSubTaskID($con);
        $subTask->setMainTaskID($mainTaskID);
        $subTask->setSubTaskName($subTaskName);
        $subTask->setDescription($desc);
        $subTask->setAssignedMemberID($memberID);
        $subTask->setDeadline($deadline);
        $rs = $subTask->savChangesToDatabase($con);
        if ($rs) {
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
        } else {
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
        }
    }

}

if (isset($_POST['sub_task_update_submit'])){
    $selectedMenuNo = $_POST['menuNo'];
    $subTaskID = $_POST['sub_task_id'];
    $completed = 0;

    if ($_POST['is_completed'] == "completed"){
        $completed = 1;
    }

    $subTask = new SubTask($subTaskID,null,null,null,null,null,null,null);
    $subTask->loadSubTaskFromSubTaskID($con);
    $subTask->setIsTaskCompleted($completed);
    $rs = $subTask->savChangesToDatabase($con);

    if ($rs) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
    }

}
