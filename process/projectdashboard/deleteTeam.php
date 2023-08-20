<?php


require_once "../../classes/TeamCategory.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\TeamCategory;

$con = DBConnector::getConnection();
if (isset($_POST['submit'])) {

    $selectedMenuNo = $_POST['menuNo'];
    $teamCatID = $_POST['category_id'];

    $teamCat = new TeamCategory($teamCatID, null, null, null);
    $teamCat->loadDataByTeamID($con);
    $teamCat->setStatus("delete");
    $result = $teamCat->updateChanges($con);

    if ($result) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }

}