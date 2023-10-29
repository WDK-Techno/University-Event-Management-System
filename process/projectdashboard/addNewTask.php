<?php
require_once "../../classes/PRTask.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\PRTask;



$con = DBConnector::getConnection();
if (isset($_POST['submit'])){
    print_r('23ds');
        $PRTopic = $_POST['topic'];
        $PRDescription = $_POST['description'];
        $DesignerID = $_POST['designer_id'];
        $CaptionWriterID = $_POST['caption_writer_id'];
        $projectId = $_POST['project_id'];




    $PRTask = new PRTask(null,null,null,$PRTopic, $PRDescription, $DesignerID,null, $CaptionWriterID,null,null,null,$projectId,null);
        $result = $PRTask->addNewTask($con);

}
