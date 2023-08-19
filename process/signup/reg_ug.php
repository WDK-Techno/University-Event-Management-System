<?php

require_once "../../classes/User.php";
require_once "../../classes/DBConnector.php";

use classes\Undergraduate;
use classes\DBConnector;

$con = DBConnector::getConnection();

if (isset($_POST["submit"], $_POST["username"], $_POST["password"],
    $_POST["first_name"], $_POST["last_name"], $_POST["contact_no"])) {

    if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["first_name"]) ||
        empty($_POST["last_name"]) || empty($_POST["contact_no"])) {

        header("location: ../../content/ug_signup.php?status=1");

    } else {


        $userName = $_POST["username"];
        $password = password_hash($_POST["password"],PASSWORD_BCRYPT);
        $firstName = $_POST["first_name"];
        $lastName = $_POST["last_name"];
        $contactNo = $_POST["contact_no"];

        $ug = new Undergraduate($userName, $password, $firstName,
            $lastName, $contactNo);
    if ($ug->checkDuplicateEmail($con)){
        header("location: ../../content/ug_signup.php?status=3");
    }else{

        $result =  $ug->register($con);
        if ($result){
            header("location: ../../login.php");
        }else{
            header("location: ../../content/ug_signup.php?status=2");
        }
    }
    }
} else {
    header("location: ../../content/ug_signup.php?status=1");
}


