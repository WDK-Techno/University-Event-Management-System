<?php
require_once "../../classes/DBConnector.php";
require_once "../../classes/TeamMember.php";
require_once "../../classes/User.php";

use classes\DBConnector;
use classes\TeamMember;
use classes\Undergraduate;

$con = DBConnector::getConnection();
$message = "";
$success = false;
$members = array();
if(isset($_POST['team_cat_id'])){
    if (empty($_POST['team_cat_id'])) {
        $message = "Input Cannot Be Empty";
    }else{
        $teamCatID = $_POST['team_cat_id'];
        $teamMembers = TeamMember::getMemberListFromCategoryID($con, $teamCatID);

        foreach ($teamMembers as $teamMember){
            $member = new Undergraduate(null, null, null, null, null, null);
            $member->setUserId($teamMember->getUgID());
            $member->loadDataFromUserID($con);
            $members[$member->getUserId()] = $member->getFirstName()." ".$member->getLastName();
        }
        $success = true;
    }
}

// Create an array to hold varibales values
$response = array(
    'message' => $message,
    'success'=>$success,
    'members'=>$members
);

// Convert the array to JSON and send it as the response
echo json_encode($response);
