<?php
require_once '../../classes/User.php';
require_once '../../classes/DBConnector.php';
use classes\DBConnector;
use classes\Club;


if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if(isset($_POST["user_id"])){
    $user_id = $_POST["user_id"];
    $con = DBConnector::getConnection();
    
    // echo $user_id;
    $club = new Club('','','','');
    $club->setUserId($user_id);
    // $undergraduate->ugdelete($con);
    $club->loadDataFromUserID($con);
    $club->setStatus("delete");
    $rs = $club->saveUserChangesToDataBase($con);
    header("Location:../../superadmindashboard.php?tab=2");
    }
}