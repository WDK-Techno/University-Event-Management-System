<?php
require_once "../../classes/DBConnector.php";

use classes\DBConnector;

if($_SERVER['REQUEST_METHOD']==="POST"){
    if(isset($_POST['update'])){
        $all_task = $_POST['checkTask'];
        $extract_id = implode(',',$all_task);
        //echo $extract_id;
        $con = DBConnector::getConnection();

        $query = "UPDATE sub_task SET task_compleat WHERE sub_task_id IN($extract_id)";
        $query_run = mysqli_query($con,$query);


    }
}
