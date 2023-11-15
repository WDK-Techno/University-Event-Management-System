<?php


namespace classes;

use PDO;
use PDOException;

class SubTask extends MainTask
{
    private $subTaskID;
    private $subTaskName;
    private $description;
    private $deadline;
    private $assignedMemberID;
    private $isTaskCompleted;
    private $subTaskStatus;


    public function __construct($subTaskID, $subTaskName, $description, $deadline, $assignedMemberID, $isTaskCompleted, $mainTaskID, $status)
    {
        parent::__construct($mainTaskID);

        $this->subTaskID = $subTaskID;
        $this->subTaskName = $subTaskName;
        $this->description = $description;
        $this->deadline = $deadline;
        $this->assignedMemberID = $assignedMemberID;
        $this->isTaskCompleted = $isTaskCompleted;
        $this->subTaskStatus = $status;
    }


    public function addNewSubTask($con)
    {
        try {

            $query = "INSERT INTO sub_task (sub_task_name, description, deadline, asign_member_id, main_task_id)
            VALUES (?,?,?,?,?)";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->subTaskName);
            $pstmt->bindValue(2, $this->description);
            $pstmt->bindValue(3, $this->deadline);
            $pstmt->bindValue(4, $this->assignedMemberID);
            $pstmt->bindValue(5, $this->mainTaskID);
            $pstmt->execute();

            return $pstmt->rowCount() > 0;
        } catch (PDOException $exc) {
            die("Error In adding subTask " . $exc->getMessage());
        }
    }


    public static function getSubTasksListFromProjectID($con, $projectID)

    {
        try {

            $subTasks = array();

            $query = "SELECT * FROM sub_task WHERE main_task_id in
                             (SELECT main_task_id FROM main_task WHERE project_id = ?) ORDER BY main_task_id";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $projectID);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($rs)) {
                foreach ($rs as $row) {
                    $subTask = new SubTask($row->sub_task_id, $row->sub_task_name, $row->description,
                        $row->deadline, $row->asign_member_id, $row->task_complete,
                        $row->main_task_id, $row->status);
                    $subTasks[] = $subTask;

                }
            }
        } catch (PDOException $exc) {
            die("Error In Get Sub Tasks List From Project ID " . $exc->getMessage());
        }

        return $subTasks;
    }

    public function loadCompeatSubTaskFromSubTaskID($con)
    {
        $query = "SELECT * FROM sub_task WHERE task_complete = 1 and sub_task_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->subTaskID);
        $pstmt->execute();
        $rs = $pstmt->fetch(\PDO::FETCH_OBJ);
        if (!empty($rs)) {
            $this->subTaskID = $rs->sub_task_id;
            $this->subTaskName = $rs->sub_task_name;
            $this->description = $rs->description;
            $this->deadline = $rs->deadline;
            $this->assignedMemberID = $rs->asign_member_id;
            $this->isTaskCompleted = $rs->task_complete;
            $this->mainTaskID = $rs->main_task_id;
            $this->subTaskStatus = $rs->status;

            $rs1 = parent::loadMainTaskFromTaskID($con);
            if ($rs1) {
                return true;
            } else {
                return true;
            }
        } else {
            return false;
        }

    }


    public function loadSubTaskFromSubTaskID($con)
    {

        $query = "SELECT * FROM sub_task WHERE sub_task_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->subTaskID);
        $pstmt->execute();
        $rs = $pstmt->fetch(\PDO::FETCH_OBJ);
        if (!empty($rs)) {
            $this->subTaskID = $rs->sub_task_id;
            $this->subTaskName = $rs->sub_task_name;
            $this->description = $rs->description;
            $this->deadline = $rs->deadline;
            $this->assignedMemberID = $rs->asign_member_id;
            $this->isTaskCompleted = $rs->task_complete;
            $this->mainTaskID = $rs->main_task_id;
            $this->subTaskStatus = $rs->status;

            $rs1 = parent::loadMainTaskFromTaskID($con);
            if ($rs1) {
                return true;
            } else {
                return true;
            }
        } else {
            return false;
        }

    }

    public function savChangesToDatabase($con)
    {
        try {
            $query = "UPDATE sub_task SET sub_task_name=?,description=?,deadline=?,
                    asign_member_id=?,task_complete=?,main_task_id=?,status=? WHERE sub_task_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1,$this->subTaskName);
            $pstmt->bindValue(2,$this->description);
            $pstmt->bindValue(3,$this->deadline);
            $pstmt->bindValue(4,$this->assignedMemberID);
            $pstmt->bindValue(5,$this->isTaskCompleted);
            $pstmt->bindValue(6,$this->mainTaskID);
            $pstmt->bindValue(7,$this->subTaskStatus);
            $pstmt->bindValue(8,$this->subTaskID);
            $pstmt->execute();
            return $pstmt->rowCount()>0;
        }catch (PDOException $exc){
            die("Error in Subtask Save changes to DB ".$exc->getMessage());
        }
    }

//    public static function getSubTaskListFromUserID($con, $userID)
//    {
//        try {
//
//            $subTasks = array();
//
//            $query = "SELECT * FROM sub_task WHERE asign_member_id=?";
//
//            $pstmt = $con->prepare($query);
//            $pstmt->bindValue(1, $userID);
//            $pstmt->execute();
//            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
//
//            if (!empty($rs)) {
//                foreach ($rs as $row) {
//                    $subTask = new SubTask($row->sub_task_id, $row->sub_task_name, $row->description,
//                        $row->deadline, $row->asign_member_id, $row->task_complete,
//                        $row->main_task_id, $row->status);
//                    $subTasks[] = $subTask;
//
//                }
//            }
//        } catch (PDOException $exc) {
//            die("Error In Get Sub Tasks List From Project ID " . $exc->getMessage());
//        }
//
//        return $subTasks;
//    }

    /**
     * @return mixed
     */
    public function getSubTaskID()
    {
        return $this->subTaskID;
    }

    /**
     * @param mixed $subTaskID
     */
    public function setSubTaskID($subTaskID)
    {
        $this->subTaskID = $subTaskID;
    }

    /**
     * @return mixed
     */
    public function getSubTaskName()
    {
        return $this->subTaskName;
    }

    /**
     * @param mixed $subTaskName
     */
    public function setSubTaskName($subTaskName)
    {
        $this->subTaskName = $subTaskName;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * @param mixed $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * @return mixed
     */
    public function getAssignedMemberID()
    {
        return $this->assignedMemberID;
    }

    /**
     * @param mixed $assignedMemberID
     */
    public function setAssignedMemberID($assignedMemberID)
    {
        $this->assignedMemberID = $assignedMemberID;
    }

    /**
     * @return mixed
     */
    public function getIsTaskCompleted()
    {
        return $this->isTaskCompleted;
    }

    /**
     * @param mixed $isTaskCompleted
     */
    public function setIsTaskCompleted($isTaskCompleted)
    {
        $this->isTaskCompleted = $isTaskCompleted;
    }

    /**
     * @return mixed
     */
    public function getSubTaskStatus()
    {
        return $this->subTaskStatus;
    }

    /**
     * @param mixed $subTaskStatus
     */
    public function setSubTaskStatus($subTaskStatus)
    {
        $this->subTaskStatus = $subTaskStatus;
    }


}