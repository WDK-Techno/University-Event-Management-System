<?php

require_once '../../classes/User.php';
require_once '../../classes/DBConnector.php';
use classes\DBConnector;
use classes\Club;

if ($_SERVER["REQUEST_METHOD"] === "GET"){
    if(isset($_GET["user_id"])){
    $user_id = $_GET["user_id"];
    $con = DBConnector::getConnection();
    $status = $_GET["status"];
    echo $status;
    $club = new Club('','','','');
    $club->setUserId($user_id);
    $club->loadDataFromUserID($con);
    if($status=="deactive"){

    $club->setStatus(status:'deactive');
   

    }elseif($status=="active"){
        $club->setStatus(status:'active');

    }
    
    $rs = $club->saveUserChangesToDataBase($con);
    header("Location:../../superadmindashboard.php?tab=2");
}
}