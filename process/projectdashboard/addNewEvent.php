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
        $eventName = $_POST['name'];
        $eventId = $_POST['event_id'];

        $event = new Event(null,$eventName,$eventId,"active");
        $result = $event->addEvent($con);

        if ($result){
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
        }else{
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
        }


    }
}
