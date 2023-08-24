<?php
require_once "../../classes/TeamCategory.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\TeamCategory;

$con = DBConnector::getConnection();
if (isset($_POST['submit'],$_POST['team_name'])){
    $selectedMenuNo = $_POST['menuNo'];
    if (empty($_POST['team_name'])){
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
    }else{
        $teamName = $_POST['team_name'];
        $projectID = $_POST['project_id'];

        $teamCat = new TeamCategory(null,$teamName,$projectID,"active");
        $result = $teamCat->addNewTeam($con);

        if ($result){
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
        }else{
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
        }


    }
}