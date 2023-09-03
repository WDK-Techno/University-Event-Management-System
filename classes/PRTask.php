<?php

namespace classes;

class PRTask
{
    private $prID;
    private $isPublished;
    private $publishDate;
    private $topic;
    private $description;
    private $designerID;
    private $isDesignCompleted;
    private $captionWriterID;
    private $isCaptionCompleted;
    private $designCompletingDeadline;
    private $isVerifyByProjectChair;
    private $projectID;
    private $status;

    public function addNewTask($con){

    }
    public static function getTaskListFromProjectID($con,$projectID){

    }
    public function loadTaskFromTaskID($con){

    }
    public function saveChangesToDatabase($con){

    }

}