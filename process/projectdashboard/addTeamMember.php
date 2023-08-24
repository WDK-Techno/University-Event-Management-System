<?php
require_once "../../classes/DBConnector.php";
require_once "../../classes/TeamMember.php";
require_once "../../classes/User.php";

use classes\DBConnector;
use classes\TeamMember;
use classes\User;

$con = DBConnector::getConnection();
$message = "";
$success = false;
if (isset($_POST['username'], $_POST['project_team_id'])) {

    if (empty($_POST['username']) || empty($_POST['project_team_id'])) {
        $message = "Input Cannot Be Empty";
    } else {
        $userName = $_POST['username'];
        $teamCatID = $_POST['project_team_id'];

        $ug = new User($userName,null);
        $ug->setRole("ug");
        $userID =  $ug->getUserIDFromUsername($con);
        if (!empty($userID)){
            $member = new TeamMember($teamCatID,$userID);
            $complete = $member->addUserToProject($con);
            if ($complete){
                $message = "success";
                $success = true;
            }else{
                $message = "Already Added";
            }
        }else{
            $message= "Invalid Username";
        }

    }
}else{
    $message = "Input Cannot Be Empty";
}

// Create an array to hold varibales values
$response = array(
    'message' => $message,
    'success'=>$success
);

// Convert the array to JSON and send it as the response
echo json_encode($response);
