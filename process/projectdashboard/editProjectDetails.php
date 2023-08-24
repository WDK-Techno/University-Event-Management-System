<?php
require_once "../../classes/DBConnector.php";
require_once "../../classes/Project.php";

use classes\DBConnector;
use classes\Project;

$con = DBConnector::getConnection();
if (isset($_POST['submit_desc'])) {
    $selectedMenuNo = $_POST['menuNo'];
    if (empty($_POST["start_date"])){
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }else{
      $startDate = $_POST['start_date'];
      $endDate = $_POST['end_date'];
      $description = $_POST['desc'];
      $projectID = $_POST['project_id'];

      if (empty($endDate)){
          $endDate = null;
      }

      $project  = new Project($projectID,null,null,null,null,null,null);
      $project->loadDataFromProjectID($con);
      $project->setStartDate($startDate);
      $project->setEndDate($endDate);
      $project->setDescription($description);
      $rs =  $project->saveChangesToDataBase($con);

      if ($rs){
          header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
      }else{
          header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
      }
    }

}else if(isset($_POST['submit_project_name'])){
    $selectedMenuNo = $_POST['menuNo'];
    if (empty($_POST["project_name"])){
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }else{
        $projectName = $_POST['project_name'];
        $projectID = $_POST['project_id'];

        $project  = new Project($projectID,null,null,null,null,null,null);
        $project->loadDataFromProjectID($con);
        $project->setProjectName($projectName);
        $rs =  $project->saveChangesToDataBase($con);

        if ($rs){
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
        }else{
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
        }
    }

}