<?php
require_once '../../classes/DBConnector.php';
require_once '../../classes/Project.php';

use classes\Project;
use classes\DBConnector;

$con =  DBConnector::getConnection();

if($_SERVER['REQUEST_METHOD']==="POST"){
 if(isset($_POST['addProject'])) {
     if (!empty($_POST['projectName'])) {
         $projectName = strip_tags($_POST['projectName']);
         $clubId = 11;
         $chairId = 5;
         $project = new Project(null, $projectName, $clubId, $chairId, "active", null, null);
         $result=$project->addProject($con);
         if($result){
             header("Location: ../../clubowner-dashboard.php");
         }else{
             header("Location: ../../clubowner-dashboard.php?status=4");
         }

     }else{
         header("Location: ../../clubowner-dashboard.php?status=2"); //empty fields
     }
 }
 else {
         header("Location: ../../clubowner-dashboard.php?status=1"); //not submit
     }
 }else{
    header("Location: ../../clubowner-dashboard.php?status=1");
}