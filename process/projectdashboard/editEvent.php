<?php

require_once "../../classes/Event.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\Event;

$con = DBConnector::getConnection();
if (isset($_POST['submit'],$_POST['name'])){
    $selectedMenuNo = $_POST['menuNo'];
    if (empty($_POST['name'])){
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=2");
    }else{
        $teamName = $_POST['name'];
        $teamCatID = $_POST['event_id'];

        $event = new Event($eventName,null,null,null);
        $event->loadDataFromeventId($con);
        $event->seteventName($eventName);
        $result = $event->saveChangesToDataBase($con);

        if ($result){
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
        }else{
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
        }


    }
}