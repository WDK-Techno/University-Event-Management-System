<?php
require_once '../../classes/DBConnector.php';
require_once '../../classes/Project.php';

use classes\Project;
use classes\DBConnector;

$con = DBConnector::getConnection();
$message = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['project_name'], $_POST['chair_username'])) {
        if (empty($_POST['project_name']) || empty($_POST['chair_username'])) {

            $projectName = strip_tags($_POST['project_name']);
            $clubId = $_POST['club_id'];
            $chairUserName = $_POST['chair_username'] ;


            $project = new Project(null, $projectName, $clubId, $chairId, "active", null, null);
            $result = $project->addProject($con);
            if ($result) {

            } else {

            }

        } else {

        }
    } else {
        $message = "Input Cannot Be Empty";
    }

}

// Create an array to hold varibales values
$response = array(
    'message' => $message,
    'success' => $success
);

// Convert the array to JSON and send it as the response
echo json_encode($response);