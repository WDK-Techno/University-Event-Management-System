<?php
require_once '../../classes/DBConnector.php';
require_once '../../classes/Project.php';

use classes\Project;
use classes\DBConnector;

$con = DBConnector::getConnection();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (isset($_POST["submit"])) {



            $projectId = $_POST['user_id'];
            $status = "deactive";
            $project = new Project(null, null, null, null, null, null, null);
            $project->setProjectID($projectId);
            $project->loadDataFromProjectID($con);
            $project->setStatus($status);
            $rs=$project->saveChangesToDataBase($con);

            if($rs){
                header("Location:../../clubowner-dashboard.php?tab=1");
            }


    }
}
