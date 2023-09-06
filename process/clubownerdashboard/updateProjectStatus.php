<?php
require_once '../../classes/DBConnector.php';
require_once '../../classes/Project.php';

use classes\DBConnector;
use classes\Project;

$con = DBConnector::getConnection();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if(isset($_POST["status"],$_POST["projectId"])){

            $status = $_POST["status"];
            $projectId = $_POST["projectId"];
            echo $status;
            echo $projectId;
            var_dump($status, $projectId);
            $project = new Project('', '', '', '', '', '', '');
            if ($status == 'false') {
                $newStatus = 'inactive';
            } else {
                $newStatus = 'active';
            }
            $project->setStatus($newStatus);
            $project->setProjectID($projectId);
            if ($project->saveChangesToDataBase($con)) {
                echo "Status updated successfully!";
            } else {
                echo "Failed to update status.";
            }

    }
}
?>


