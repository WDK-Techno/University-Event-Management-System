<?php


require_once '../../classes/Admin.php';
require_once '../../classes/DBConnector.php';
use classes\Admin;
if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (isset($_POST["user_id"])) {
        $user_id = $_POST["user_id"];
        $userObj = new Admin();
        $userObj->updateStatus($user_id);
        header("Location:../../superadmindashboard.php?tab=3");
      
    }

    

}