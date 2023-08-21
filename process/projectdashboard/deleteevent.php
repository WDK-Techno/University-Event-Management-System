<?php


require_once "../../classes/Event.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\Event;

$con = DBConnector::getConnection();
if (isset($_POST['submit'])) {

    $selectedMenuNo = $_POST['menuNo'];
    $teamCatID = $_POST['event_id'];

    $event = new Event(null,$eventId,"active");
    $event->loadDataFromeventId($con);
    $event->setStatus("delete");
    $result = $event->saveChangesToDataBase($con);

    if ($result) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }

}