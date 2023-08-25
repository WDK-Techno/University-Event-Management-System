<?php
require_once '../../classes/DBConnector.php';
require_once '../../classes/Project.php';
require_once '../../classes/User.php';


use classes\Project;
use classes\DBConnector;
use classes\User;

$con = DBConnector::getConnection();
$message = "";
$success = false;

if (isset($_POST['project_name'], $_POST['chair_username'])) {
    if (empty($_POST['project_name']) || empty($_POST['chair_username'])) {

        $message = "Input Cannot Be Empty";

    } else {


        $projectName = strip_tags($_POST['project_name']);
        $clubId = $_POST['club_id'];
        $chairUserName = $_POST['chair_username'];

        $projectChair = new User($chairUserName, null);
        $projectChair->setRole("ug");
        $projectChairID = $projectChair->getUserIDFromUsername($con);
        if (!empty($projectChairID)) {
            $project = new Project(null, $projectName, $clubId, $projectChairID, "active", null, null);
            $rs = $project->addProject($con);
            if ($rs) {
                $success = true;
                $message = "success";
            } else {
                $message = "Error";
            }

        } else {
            $message = "Invalid User";
        }

    }
}else{
    $message = "Input Cannot Be Empty";
}


// Create an array to hold varibales values
$response = array(
    'message' => $message,
    'success' => $success
);

// Convert the array to JSON and send it as the response
echo json_encode($response);

