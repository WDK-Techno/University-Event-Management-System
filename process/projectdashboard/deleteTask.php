<?php


require_once "../../classes/PRTask.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\PRTask;

$con = DBConnector::getConnection();
if (isset($_POST['submit'])) {

    $selectedMenuNo = $_POST['menuNo'];
    $prID = $_POST['pr_id'];

    $task = new PRTask($prID,null,null ,null, null, null,null);
    $task->loadTaskFromPRId($con);
    $result = $task->deleteTask($con);

    if ($result) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }

}
