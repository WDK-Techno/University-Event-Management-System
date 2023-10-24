<?php
require_once '../../classes/User.php';
require_once '../../classes/DBConnector.php';

use classes\DBConnector;
use classes\Undergraduate;

if ($_SERVER["REQUEST_METHOD"] === "GET"){
    if(isset($_GET["user_id"])){
        $user_id = $_GET["user_id"];
        $con = DBConnector::getConnection();
        $status = $_GET["status"];
        echo $status;
        $undergraduate = new Undergraduate('','','','','','');
        $undergraduate->setUserId($user_id);
        $undergraduate->loadDataFromUserID($con);
        if($status=="deactive"){
    
        $undergraduate->setStatus(status:'deactive');
       
    
        }elseif($status=="active"){
            $undergraduate->setStatus(status:'active');
    
        }
        
       
        
        $rs = $undergraduate->saveUserChangesToDataBase($con);
    header("Location:../../superadmindashboard.php?tab=1");
    }
}