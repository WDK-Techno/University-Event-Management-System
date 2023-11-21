<?php
require_once "../classes/User.php";
require_once "../classes/DBConnector.php";
require_once "../classes/Mail.php";

use classes\DBConnector;
use classes\User;
use classes\Undergraduate;
use classes\Club;
use classes\Mail;

$con = DBConnector::getConnection();

if (isset($_POST['submit'], $_POST['username'])) {
    if (empty($_POST['username'])) {
        header("location: ../login.php?status=1");
    } else {
        $userName = $_POST['username'];

        $mailObj = new Mail();
        $mailObj->sendMail("EMS user", $userName);
        header("Location:../login.php?status=3");
        // $mailObj->updateUserPassword($con, $email);
    }
}
?>