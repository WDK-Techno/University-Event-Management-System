<?php
require_once '../../classes/User.php';
require_once '../../classes/DBConnector.php';
use classes\DBConnector;
use classes\Undergraduate;


if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["user_id"])){
    $user_id = $_POST["user_id"];
    $con = DBConnector::getConnection();
    
    // echo $user_id;
    $undergraduate = new Undergraduate('','','','','','');
    $undergraduate->setUserId($user_id);
    // $undergraduate->ugdelete($con);
    $undergraduate->loadDataFromUserID($con);
    $undergraduate->setStatus("delete");
    $rs = $undergraduate->saveUserChangesToDataBase($con);
    if($rs){
        header("Location:../../superadmindashboard.php?tab=1");
    }else{
        header("Location:../../superadmindashboard.php?tab=1&errDelete=1");
    }


    }
}