<?php
use classes\Admin;

require_once '../../classes/admin.php';
require_once '../../classes/DBConnector.php';

if ($_SERVER["REQUEST_METHOD"] === "GET"){
    $user_id = $_GET["user_id"];
    $status = $_GET["status"];
    $userObj = new \classes\Admin();
    $userObj->status($user_id, $status);
    header("Location:../../superadmindashboard.php");
}