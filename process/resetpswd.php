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
if (isset($_POST['submit'], $_POST['password'], $_POST['rpassword'])) {
    if (empty($_POST['password'] || $_POST['rpassword'])) {
        header("location: ../resetPassword.php?status=1");
    } else {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $rpassword = $_POST['rpassword'];
        if ($rpassword != $password) {
            header("location: ../resetPassword.php?email=$email");
        } else {
            $newpassword = password_hash($password,PASSWORD_BCRYPT);
            $mailObj = new Mail();
            $mailObj->updateUserPassword($con, $email, $newpassword);
            header("location: ../login.php?status=4");
        }
        // echo $password." ".$rpassword." ".$email;

    }
}
?>