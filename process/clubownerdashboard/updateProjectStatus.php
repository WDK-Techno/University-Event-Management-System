<?php
require_once '../../classes/DBConnector.php';
require_once '../../classes/Project.php';

use classes\DBConnector;
use classes\Project;

$con = DBConnector::getConnection();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST["project_status_submit"])) {

        $status = $_POST["is_verify"];
        $projectId = $_POST["prId"];
        $projectChairId = $_POST["prChairId"];
        $tab = $_POST["tab"];

        if ($status == "verified") {
            $project = new Project(null, null, null, null, null, null, null);
            $newStatus = "active";

            $project->setProjectID($projectId);
            $project->loadDataFromProjectID($con);
            $project->setStatus($newStatus);
            $project->setProjectChairID($projectChairId);
            if ($project->saveChangesToDataBase($con)) {
                echo "Status updated successfully!";
                header("location: ../../clubowner-dashboard.php?tab=$tab");
            } else {
                header("location: ../../clubowner-dashboard.php?tab=$tab&status=1");
            }

        } else {
            $project = new Project(null, null, null, null, null, null, null);
            $newStatus = "deactive";

            $project->setProjectID($projectId);
            $project->loadDataFromProjectID($con);
            $project->setStatus($newStatus);
            $project->setProjectChairID($projectChairId);
            if ($project->saveChangesToDataBase($con)) {
                echo "Status updated successfully!";
                header("location: ../../clubowner-dashboard.php?tab=$tab");
            } else {
                header("location: ../../clubowner-dashboard.php?tab=$tab&status=2");
            }
        }
    } else {
        echo "1.1.1.1";
    }
}
?>


