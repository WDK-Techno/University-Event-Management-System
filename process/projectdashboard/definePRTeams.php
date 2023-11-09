<?php

require_once "../../classes/DBConnector.php";
require_once "../../classes/Project.php";

use classes\DBConnector;
use classes\Project;

$con = DBConnector::getConnection();

if (isset($_POST['define_submit'])){
    $selectedMenuNo = $_POST['menuNo'];
    $projectID = $_POST['project_id'];
    $designTeamCategoryID = $_POST['design_team_id'];
    $writingTeamCategoryID = $_POST['sec_team_id'];

    $project = new Project($projectID,null,null,null,null,null,null);
    $project->loadDataFromProjectID($con);
    $project->setDesignTeamID($designTeamCategoryID);
    $project->setWritingTeamID($writingTeamCategoryID);
    $rs = $project->saveChangesToDataBase($con);

    if ($rs){
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    }else{
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }
}
