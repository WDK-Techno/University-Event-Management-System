<?php

require_once "../../classes/User.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\Undergraduate;

if($_SERVER['REQUEST_METHOD']==="POST"){
    if(isset($_POST['submit'])){
        $selectedMenuNo = $_POST['menuNo'];
        if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['contact_no']) || empty($_POST['ug_id'])){
            header("location: ../../ug-dashboard.php?tab={$selectedMenuNo}&saveEditErr=2");
        }else{
            $fname = $_POST['first_name'];
            $lname = $_POST['last_name'];
            $contact_no = $_POST['contact_no'];
            $ug_id = $_POST['ug_id'];

            $con = DBConnector::getConnection();

            $ug = new Undergraduate(null,null,null,null,null,null);
            $ug->loadDataFromUserID($ug_id);
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
}