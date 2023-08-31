<?php




namespace classes;

use PDO;
use PDOException;
class SubTask
{
    private $subTaskID;
    private $subTaskName;
    private $description;
    private $deadline;
    private $assignedMemberID;
    private $isTaskCompleted;
    private $mainTaskID;
    private $status;


    public function __construct($subTaskID, $subTaskName, $description, $deadline, $assignedMemberID, $isTaskCompleted, $mainTaskID, $status)
    {
        $this->subTaskID = $subTaskID;
        $this->subTaskName = $subTaskName;
        $this->description = $description;
        $this->deadline = $deadline;
        $this->assignedMemberID = $assignedMemberID;
        $this->isTaskCompleted = $isTaskCompleted;
        $this->mainTaskID = $mainTaskID;
        $this->status = $status;
    }


    public function addNewSubTask($con)
    {

    }

    public static function getSubTasksListFromProjectID($con, $projectID)

    {
        try {

            $subTasks = array();
//            $con = DBConnector::getConnection();
            $query = "SELECT * FROM sub_task WHERE main_task_id in 
                             (SELECT main_task_id FROM main_task WHERE project_id = ?)";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1,$projectID);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($rs)){
                foreach ($rs as $row){
                    $subTask = new SubTask($row->sub_task_id,$row->sub_task_name,$row->description,
                        $row->deadline,$row->asign_member_id,$row->task_complete,
                        $row->main_task_id,$row->status);
                    $subTasks[] = $subTask;

                }
            }
        }catch (PDOException $exc){
            die("Error In Get Sub Tasks List From Project ID " . $exc->getMessage());
        }

        return $subTasks;
    }

    public function loadSubTaskFromSubTaskID($con)
    {

    }
    public function savChangesToDatabase($con)
    {

    }
    public static function getSubTaskListFromUserID($con,$userID){

    }

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
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }



}