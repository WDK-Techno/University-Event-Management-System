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
        $eventDescription = $_POST['description'];
        $eventDate = $_POST['event_date'];
        $eventStartTime = $_POST['event_start_time'];
        $eventEndTime = $_POST['event_end_time'];
        $projectId = $_POST['project_id'];

        $eventStartDate = $eventDate." ".$eventStartTime;
        $eventEndDate = $eventDate." ".$eventEndTime;

        $event = new Event(null,$eventName, $eventDescription, $eventStartDate, $eventEndDate,
            $projectId,"active");
        $result = $event->addEvent($con);

        if ($result){
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
        }else{
            header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
        }


    }
}
