<?php
require_once '../../classes/DBConnector.php';
require_once '../../classes/Project.php';

use classes\DBConnector;
use classes\Project;

$con = DBConnector::getConnection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $status = isset($_POST["status"]) ? $_POST["status"] : false;
    $projectId = isset($_POST["projectId"]) ? $_POST["projectId"] : null;

    if ($status !== false && $projectId !== null) {
        $project = new Project($projectId, '', '', '', '', '', '');
        if ($status == 'active') {
            $newStatus = 'inactive';
        } else {
            $newStatus = 'active';
        }
        $project->setStatus($newStatus);
        if ($project->saveChangesToDataBase($con)) {
            echo "Status updated successfully!";
        } else {
            echo "Failed to update status.";
        }
    }
}
?>


