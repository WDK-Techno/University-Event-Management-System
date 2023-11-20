<?php
require_once "../../classes/DBConnector.php";
require_once "../../classes/MainTask.php";

require_once '../../classes/SubTask.php';

use classes\DBConnector;


use classes\SubTask;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['removeTask'])) {
        $subTaskID = $_POST['subTaskID'];
        $con = DBConnector::getConnection();
        $selectedMenuNo = 2;
        $subTaskIDobj = new SubTask($subTaskID, null, null, null, null, null, null, null);
        $subTaskIDobj->loadSubTaskFromSubTaskID($con);
        $subTaskIDobj->setIsTaskCompleted(0);
        $rs = $subTaskIDobj->savChangesToDatabase($con);




        if ($rs){
            header("location: ../../ug-dashboard.php?tab={$selectedMenuNo}");
        }else{
            header("location: ../../ug-dashboard.php?tab={$selectedMenuNo}&saveEditErr=1");
        }


    }
}