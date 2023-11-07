<?php

namespace classes;

use PDOException;
use PDO;


class Event
{
    private $eventId;
    private $eventName;
    private $eventDescription;
    private $eventStartDate;
    private $eventEndDate;
    private $projectID;
    private $status;


    public function getEventId()
    {
        return $this->eventId;
    }


    public function setEventId($eventId)
    {
        $this->eventId = $eventId;
    }


    public function getEventName()
    {
        return $this->eventName;
    }


    public function setEventName($eventName)
    {
        $this->eventName = $eventName;
    }

    public function getEventDescription()
    {
        return $this->eventDescription;
    }


    public function setEventDescription($eventDescription)
    {
        $this->eventDescription = $eventDescription;
    }


    public function getEventStartDate()
    {
        return $this->eventStartDate;
    }


    public function setEventStartDate($eventStartDate)
    {
        $this->eventStartDate = $eventStartDate;
    }


    public function getEventEndDate()
    {
        return $this->eventEndDate;
    }


    public function setEventEndDate($eventEndDate)
    {
        $this->eventEndDate = $eventEndDate;
    }

    public function getProjectID()
    {
        return $this->projectID;
    }


    public function setProjectID($projectID)
    {
        $this->projectID = $projectID;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }


    public function __construct($eventId, $eventName, $eventDescription, $eventStartDate,$eventEndDate, $projectID, $status)
    {
        $this->eventId = $eventId;
        $this->eventName = $eventName;
        $this->eventDescription = $eventDescription;
        $this->eventStartDate = $eventStartDate;
        $this->eventEndDate = $eventEndDate;
        $this->projectID = $projectID;
        $this->status = $status;

    }

    public function addEvent($con)
    {
        try {
            $query = "INSERT INTO event (name,description,start_date,end_date,project_id,status) VALUES (?,?,?,?,?,?)";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->eventName);
            $pstmt->bindValue(2, $this->eventDescription);
            $pstmt->bindValue(3, $this->eventStartDate);
            $pstmt->bindValue(4, $this->eventEndDate);
            $pstmt->bindValue(5, $this->projectID);
            $pstmt->bindValue(6, "active");
            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $this->eventId = $con->lastInsertId();
                $this->loadDataFromeventId($con);
            } else {
                return false;
            }
        } catch (PDOException $exc) {
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
            if (!empty($rs)) {
                $this->eventId = $rs->event_id;
                $this->eventName = $rs->name;
                $this->eventDescription = $rs->description;
                $this->eventStartDate = $rs->start_date;
                $this->eventEndDate = $rs->end_date;
                $this->projectID = $rs->project_id;
                $this->status = $rs->status;

                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            die("Error in Event details loading" . $exc->getMessage());
        }
    }

    public function saveChangesToDataBase($con)
    {
        try {
            $query = "UPDATE event SET name=?,description=?,start_date=?,end_date=?,status=? WHERE event_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->eventName);
            $pstmt->bindValue(2, $this->eventDescription);
            $pstmt->bindValue(3, $this->eventStartDate);
            $pstmt->bindValue(4, $this->eventEndDate);
            $pstmt->bindValue(5, $this->status);
            $pstmt->bindValue(6, $this->eventId);
            $pstmt->execute();

            return $pstmt->rowCount() > 0;
        } catch (PDOException $exc) {
            die("Error in Update Database" . $exc->getMessage());
        }
    }

    public static function getEventListFromProjectID($con, $project_id)
    {
        $events = array();
        try {
            $query = "SELECT * FROM event WHERE status = 'active' AND project_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $project_id);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($rs)) {
                foreach ($rs as $row) {
                    $event = new Event($row->event_id, $row->name,
                        $row->description, $row->start_date,$row->end_date, $row->project_id, $row->status);
                    $events[] = $event;
                }
            }
        } catch (PDOException $exc) {
            die("Error in Database Loading" . $exc->getMessage());
        }
        return $events;
    }

    public function deleteEvenet($con){
        try {
            $query = "DELETE FROM event WHERE event_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->eventId);
            $pstmt->execute();
            return $pstmt->rowCount() > 0;
        } catch (PDOException $exc) {
            die("Error in Update Database" . $exc->getMessage());
        }
    }

}

