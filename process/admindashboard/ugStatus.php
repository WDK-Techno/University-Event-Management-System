<?php

require_once '../../classes/Admin.php';
require_once '../../classes/DBConnector.php';
use classes\Admin;

if ($_SERVER["REQUEST_METHOD"] === "GET"){
    $user_id = $_GET["user_id"];
    $status = $_GET["status"];
    $userObj = new Admin();
    $userObj->status($user_id, $status);
    header("Location:../../superadmindashboard.php?tab=1");
}