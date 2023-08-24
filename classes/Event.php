<?php

namespace classes;

use PDOException;
use PDO;


class Event
{
    private $eventId;
    private $eventName;
    private $eventDescription;
    private $eventDate;
    private $projectID;
    private $status;

    public function geteventId()
    {
        return $this->eventId;
    }
    public function seteventId($eventId)
    {
        $this->eventId=$eventId;
    }
    public function geteventName()
    {
        return $this->eventName;
    }
    public function seteventName($eventName)
    {
        $this->eventName=$eventName;
    }
    public function geteventDescription()
    {
        return $this->eventDescription;
    }
    public function seteventDescription($eventDescription)
    {
        $this->eventDescription=$eventDescription;
    }
    public function geteventDate()
    {
        return $this->eventDate;
    }
    public function seteventDate($eventDate)
    {
        $this->eventDate=$eventDate;
    }
    public function getprojectID()
    {
        return $this->projectID;
    }
    public function setprojectID($projectID)
    {
        $this->projectID=$projectID;
    }
    public function getstatus()
    {
        return $this->status;
    }
    public function setstatus($status)
    {
        $this->status=$status;
    }

    public function __construct($eventId,$eventName,$eventDescription,$eventDate,$projectID,$status)
    {
        $this->eventId=$eventId;
        $this->eventName=$eventName;
        $this->eventDescription=$eventDescription;
        $this->eventDate=$eventDate;
        $this->projectID=$projectID;
        $this->status=$status;

    }
    public function addEvent($con)
    {
        try {
            $query = "INSERT INTO event (name,description,event_date,project_id,status) VALUES (?,?,?,?,?)";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->eventName);
            $pstmt->bindValue(2, $this->eventDescription);
            $pstmt->bindValue(3, $this->eventDate);
            $pstmt->bindValue(4, $this->projectID);
            $pstmt->bindValue(5, "active");
            $pstmt->execute();

            if ($pstmt->rowCount() > 0){
                $this->eventId = $con->lastInsertId();
                $this->loadDataFromeventId($con);
            }
            else{
                return false;
            }
        }
        catch (PDOException $exc){
            die("Error in Event Adding" . $exc->getMessage());
        }
    }
    public function loadDataFromeventId($con)
    {
        try {
            $query = "SELECT * FROM event WHERE  event_id = ?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->eventId);
            $pstmt->execute();

            $rs = $pstmt->fetch(PDO::FETCH_OBJ);
            if (!empty($rs)){
                $this->eventId = $rs->event_id;
                $this->eventName = $rs->name;
                $this->eventDescription = $rs->description;
                $this->eventDate = $rs->event_date;
                $this->projectID = $rs->project_id;
                $this->status = $rs->status;

                return true;
            }
            else{
                return false;
            }
        }
        catch (PDOException $exc){
            die("Error in Event details loading" . $exc->getMessage());
        }
    }
    public function saveChangesToDataBase($con)
    {
        try {
            $query = "UPDATE event SET name=?,description=?,event_date=?,status=? WHERE event_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->eventName);
            $pstmt->bindValue(2, $this->eventDescription);
            $pstmt->bindValue(3, $this->eventDate);
            $pstmt->bindValue(4, $this->status);
            $pstmt->bindValue(5, $this->eventId);
            $pstmt->execute();

            return $pstmt->rowCount() > 0;
        }
        catch (PDOException $exc){
            die("Error in Update Database" . $exc->getMessage());
        }
    }
    public static function getEventListFromProjectID($con,$project_id){
        $events = array();
        try {
            $query = "SELECT * FROM event WHERE status = 'active' AND project_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $project_id);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($rs)){
                foreach ($rs as $row){
                    $event = new Event($row->event_id, $row->name,
                        $row->description, $row->event_date, $row->project_id,$row->status);
                    $events[] = $event;
                }
            }
        }catch (PDOException $exc){
            die("Error in Database Loading" . $exc->getMessage());
        }
        return $events;
    }
}