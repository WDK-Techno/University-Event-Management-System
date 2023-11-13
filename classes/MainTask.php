<?php

namespace classes;

use PDO;
use PDOException;

class MainTask
{
    protected $mainTaskID;
    protected $mainTaskName;
    protected $startDate;
    protected $endDate;
    protected $projectID;
    protected $mainTaskStatus;

    /**
     * @param $mainTaskID
     * @param $mainTaskName
     * @param $startDate
     * @param $endDate
     * @param $projectID
     * @param $status
     */
    public function __construct($mainTaskID)
    {
        $this->mainTaskID = $mainTaskID;
//        $this->mainTaskName = $mainTaskName;
//        $this->startDate = $startDate;
//        $this->endDate = $endDate;
//        $this->projectID = $projectID;
//        $this->mainTaskStatus = $mainTaskStatus;
    }

    public function addMainTask($con)
    {

    }

    public function saveChangesToDatabase($con)
    {

    }

    public function loadMainTaskFromTaskID($con)
    {

        $query = "SELECT * FROM main_task WHERE main_task_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->mainTaskID);
        $pstmt->execute();
        $rs = $pstmt->fetch(PDO::FETCH_OBJ);
        if (!empty($rs)) {
            $this->mainTaskID = $rs->main_task_id;
            $this->mainTaskName = $rs->main_task_name;
            $this->startDate = $rs->start_date;
            $this->endDate = $rs->end_date;
            $this->projectID = $rs->project_id;
            $this->mainTaskStatus = $rs->status;
            return true;
        } else {
            return false;
        }
    }

    public static function getMainTaskListFromProjectID($con, $projectID)
    {
        $mainTasks = array();

        try {
            $query = "SELECT * from main_task WHERE project_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $projectID);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($rs)) {
                foreach ($rs as $row) {
                    $mainTask = new MainTask($row->main_task_id);
                    $mainTasks[] = $mainTask;
                }
            }
        }catch (PDOException $exc){
            die("Error in loading main taks list by project ID ". $exc->getMessage());
        }

        return $mainTasks;
    }

    /**
     * @return mixed
     */
    public function getMainTaskID()
    {
        return $this->mainTaskID;
    }

    /**
     * @param mixed $mainTaskID
     */
    public function setMainTaskID($mainTaskID)
    {
        $this->mainTaskID = $mainTaskID;
    }

    /**
     * @return mixed
     */
    public function getMainTaskName()
    {
        return $this->mainTaskName;
    }

    /**
     * @param mixed $mainTaskName
     */
    public function setMainTaskName($mainTaskName)
    {
        $this->mainTaskName = $mainTaskName;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getProjectID()
    {
        return $this->projectID;
    }

    /**
     * @param mixed $projectID
     */
    public function setProjectID($projectID)
    {
        $this->projectID = $projectID;
    }

    /**
     * @return mixed
     */
    public function getMainTaskStatus()
    {
        return $this->mainTaskStatus;
    }

    /**
     * @param mixed $mainTaskStatus
     */
    public function setMainTaskStatus($mainTaskStatus)
    {
        $this->mainTaskStatus = $mainTaskStatus;
    }


}
