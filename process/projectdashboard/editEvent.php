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
        $eventDescription = $_POST['description'];
        $eventStartDate = $_POST['event_start_date'];
        $eventEndDate = $_POST['event_end_date'];

        $event = new Event($eventId,null,null,null,null, null, null);
        $event->loadDataFromeventId($con);
        $event->setEventName($eventName);
        $event->setEventDescription($eventDescription);
        $event->setEventStartDate($eventStartDate);
        $event->setEventEndDate($eventEndDate);

        $result = $event->saveChangesToDataBase($con);

        if ($result){
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
        }else{
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
        }


    }
}