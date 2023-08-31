<?php
use classes\Admin;

require_once '../../classes/admin.php';
require_once '../../classes/DBConnector.php';

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (isset($_POST["user_id"])) {
        $user_id = $_POST["user_id"];
        $userObj = new \classes\Admin();
        $userObj->updateStatus($user_id);
        header("Location:../../superadmindashboard.php");
      
    }

    

}