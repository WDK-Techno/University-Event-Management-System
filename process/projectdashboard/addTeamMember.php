<?php
require_once "../../classes/DBConnector.php";
require_once "../../classes/TeamMember.php";

use classes\DBConnector;
use classes\TeamMember;

$con = DBConnector::getConnection();

if (isset($_POST['submit'], $_POST['username'], $_POST['project_team_id'])) {
    $selectedMenuNo = $_POST['menuNo'];
    if (empty($_POST['username']) || empty($_POST['project_team_id'])) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
    } else {
        $userName = $_POST['username'];
        $teamCatID = $_POST['project_team_id'];

        $member = new TeamMember($teamCatID,$userName);

    }
}