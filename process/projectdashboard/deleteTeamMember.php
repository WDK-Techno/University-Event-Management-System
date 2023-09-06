<?php
require_once "../../classes/DBConnector.php";
require_once "../../classes/TeamMember.php";

use classes\DBConnector;
use classes\TeamMember;

$con = DBConnector::getConnection();
if (isset($_POST['submit'])) {

    $selectedMenuNo = $_POST['menuNo'];
    $userID = $_POST['ug_id'];
    $categoryID = $_POST['cat_id'];

    $member = new TeamMember($categoryID,$userID);
    $result = $member->deleteUserFromProjectTeam($con);

    if ($result) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }

}