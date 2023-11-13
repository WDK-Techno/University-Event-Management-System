<?php

require_once "../../classes/PRTask.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\PRTask;

$con = DBConnector::getConnection();

if (isset($_POST['pr_update_submit'])){
    $selectedMenuNo = $_POST['menuNo'];
    $prID = $_POST['pr_id'];
    echo "pr id ".$prID;
    $published = 0;
    $verified = 0;
//    $publishedDate = null;
//    $designDeadline = null;

    if ($_POST['is_published'] == 'published'){
        $published = 1;
    }
    if ($_POST['is_verify'] == 'verified'){
        $verified = 1;
    }


    $PRTask = new PRTask($prID,null,null,null,null,null,null);
    $PRTask->loadTaskFromPRId($con);
    echo "publish date : ". $PRTask->getpublishDate();
    echo "topic ". $PRTask->gettopic();
    $PRTask->setisPublished($published);
    $PRTask->setisVerifyByProjectChair($verified);
//    $PRTask->setpublishDate($publishedDate);
//    $PRTask->setdesignCompletingDeadline($designDeadline);
    if ($PRTask->getdescription() == ""){
        $PRTask->setdescription(null);
    }
    $rs = $PRTask->saveChangesToDatabase($con);

    if ($rs) {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}");
    } else {
        header("location: ../../projectdashboard.php?tab={$selectedMenuNo}&err=1");
    }
}
