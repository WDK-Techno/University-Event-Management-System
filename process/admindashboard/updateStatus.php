<?php
require '../../core/init.php';

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    if (isset($_POST["user_id"])) {
        $user_id = $_POST["user_id"];
       $userObj->updateStatus($user_id);
       header("Location:../../superadmindashboard.php");
      
    }

    

}