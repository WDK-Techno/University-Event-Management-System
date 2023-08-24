<?php
require_once "../../classes/DBConnector.php";
require_once "../../classes/Project.php";
require_once "../../classes/User.php";

use classes\DBConnector;
use classes\Project;
use classes\Undergraduate;
use classes\User;

$con = DBConnector::getConnection();

if (isset($_POST['submit'],$_POST['username'])) {
    $selectedMenuNo = $_POST['menuNo'];
    if (empty($_POST['username'])){
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&changeChairErr=2");
    }else{
        $projectID = $_POST['project_id'];
        $chairUsername = $_POST['username'];

        $projecChair = new User($chairUsername,null);
        $projecChair->setRole("ug");
        $projecChairID = $projecChair->getUserIDFromUsername($con);
        if (!empty($projecChairID)){
            $project  = new Project($projectID,null,null,null,null,null,null);
            $project->loadDataFromProjectID($con);
            $project->setProjectChairID($projecChairID);
            $rs = $project->saveChangesToDataBase($con);

            if ($rs){
                header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
            }else{
                header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&changeChairErr=3");
            }
        }else{
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&changeChairErr=1");
        }
    }
}
