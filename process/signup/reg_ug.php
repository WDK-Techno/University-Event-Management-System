<?php

require "../../classes/User.php";
require "../../classes/DBConnector.php";

use classes\Undergraduate;
use classes\DBConnector;

$con = DBConnector::getConnection();

$ug = new Undergraduate("suvi@gmail.com","suvi@123","Ishara",
    "Suvini","0771235650");
if ($ug->checkDuplicateEmail($con)){
    echo "You have already registerd";
}else{

    $result =  $ug->register($con);
    if ($result){
        echo "Reg SUccess fill";
    }else{
        echo "Not Success";
    }
}

