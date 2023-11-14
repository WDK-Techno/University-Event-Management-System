<?php
echo "0";
require_once "../../classes/DBConnector.php";
require_once "../../classes/SubTask.php";
echo "1";

use classes\DBConnector;
use classes\SubTask;

$con = DBConnector::getConnection();

if(isset($_POST['add_new_sub_task'])){
    $selectedMenuNo = $_POST['menuNo'];
    echo "2";
    if (empty($_POST['main_task']) || empty($_POST['sub_task']) ||
        empty($_POST['selected-team-cat-members']) || empty($_POST['completion_date']) || empty($_POST['completion_time'])){
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }else{
        echo "3";
        $mainTaskID = $_POST['main_task'];
        $subTaskName = $_POST['sub_task'];
        $desc = $_POST['description'];
        $memberID = $_POST['selected-team-cat-members'];
        if (empty($_POST['sub_task'] == "")){
            $desc = null;
        }
        $completionDate = $_POST['completion_date'];
        $completionTime = $_POST['completion_time'];

        $deadline = $completionDate." ".$completionTime;

        $subTask = new SubTask(null,$subTaskName,$desc,$deadline,$memberID,null,$mainTaskID,'active');
        $rs = $subTask->addNewSubTask($con);
        if ($rs) {
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
        } else {
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
        }
    }

//    main_task
//    sub_task
//    description
//    team_category
//    selected-team-cat-members
//    completion_date
//    completion_time
}