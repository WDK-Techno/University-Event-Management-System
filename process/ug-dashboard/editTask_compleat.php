<?php
require_once "../../classes/DBConnector.php";

require_once 'classes/Project.php';
require_once 'classes/User.php';
require_once 'classes/MainTask.php';
require_once 'classes/SubTask.php';

use classes\DBConnector;


use classes\Project;
use classes\Club;
use classes\Undergraduate;
use classes\MainTask;
use classes\SubTask;

if (isset($_POST['completeTask'])) {
    $subTaskID = $_POST['subTaskID'];
    $con = DBConnector::getConnection();
    $query = "UPDATE your_table_name SET task_complete = 1 WHERE SubTaskID = ?";

    // Using prepared statement to prevent SQL injection
    $stmt = $con->prepare($query);
    $stmt->bindParam(':subTaskID', $subTaskID, PDO::PARAM_INT);

    // Execute the query
    $stmt->execute();

    // Redirect or display a success message as needed
    header("Location: your_success_page.php");
    exit();
}

if($_SERVER['REQUEST_METHOD']==="POST"){
    if(isset($_POST['completeTask'])){
        $subTaskID = $_POST['subTaskID'];
        $con = DBConnector::getConnection();

        $subTaskIDobj = new SubTask(null,null,null,null,null,null,null,null,);


        if($subTaskIDobj->getIsTaskCompleted() == 0){
            
        }


//            echo "work";
            $ug = new Undergraduate(null,null,null,null,null,null);
            $ug->setUserId($ug_id);
            $ug->loadDataFromUserID($con);
            $ug->setFirstName($fname);
            $ug->setLastName($lname);
            $ug->setContactNo($contact_no);
            $rs = $ug->saveChangesToDatabase($con);

            if ($rs){
                header("location: ../../ug-dashboard.php?tab={$selectedMenuNo}");
            }else{
                header("location: ../../ug-dashboard.php?tab={$selectedMenuNo}&saveEditErr=1");
            }


    }
}


//if($_SERVER['REQUEST_METHOD']==="POST"){
//
//    if (isset($_POST['checkTask']) && !empty($_POST['checkTask'])) {
//        $all_id = $_POST['checkTask'];
//        $checkedTasks = implode(',', $all_id);
//
//        $con = DBConnector::getConnection();
//
//        $query = "UPDATE sub_task SET task_complete = 1 WHERE sub_task_id IN ($checkedTasks)";
//        $stmt = $con->prepare($query);
//
//        if ($stmt) {
//            $stmt->execute();
//        } else {
//
//        }
//
//    }
//    if(isset($_POST['update'])){
//        $all_task = $_POST['checkTask'];
//        $extract_id = implode(',',$all_task);
//        //echo $extract_id;
//        $con = DBConnector::getConnection();
//
//        $query = "UPDATE sub_task SET task_compleat WHERE sub_task_id IN($extract_id)";
//        $query_run = mysqli_query($con,$query);
//
//
//    }
//}
