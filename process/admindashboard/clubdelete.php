<?php

require_once '../../classes/Admin.php';
require_once '../../classes/DBConnector.php';
use classes\Admin;
if (isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];
    $userObj = new Admin();
    $userObj->clubdelete($user_id);
    header("Location:../../superadmindashboard.php?tab=2");
}