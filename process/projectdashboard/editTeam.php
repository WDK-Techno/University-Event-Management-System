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
        $teamCatID = $_POST['category_id'];
        $teamCat = new TeamCategory($teamCatID,null,null,null);
        $teamCat->loadDataByTeamID($con);
        $teamCat->setCategoryName($teamName);
        $result = $teamCat->updateChanges($con);

        if ($result){
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
        }else{
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
        }


    }
}