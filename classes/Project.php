<?php

namespace classes;

use PDOException;
use PDO;

class Project
{
    private $projectID;
    private $projectName;
    private $clubID;
    private $projectChairID;
    private $status;


    public function getProjectID()
    {
        return $this->projectID;
    }


    public function setProjectID($projectID)
    {
        $this->projectID = $projectID;
    }


    public function getProjectName()
    {
        return $this->projectName;
    }


    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
    }


    public function getClubID()
    {
        return $this->clubID;
    }


    public function setClubID($clubID)
    {
        $this->clubID = $clubID;
    }


    public function getProjectChairID()
    {
        return $this->projectChairID;
    }


    public function setProjectChairID($projectChairID)
    {
        $this->projectChairID = $projectChairID;
    }


    public function getStatus()
    {
        return $this->status;
    }


    public function setStatus($status)
    {
        $this->status = $status;
    }


    public function __construct($projectID, $projectName, $clubID, $projectChairID, $status)
    {
        $this->projectID = $projectID;
        $this->projectName = $projectName;
        $this->clubID = $clubID;
        $this->projectChairID = $projectChairID;
        $this->status = $status;
    }

    public function addProject($con)
    {
        try {

            $query = "INSERT INTO project (name,club_id,project_chair_id,status) VALUES (?,?,?,?)";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->projectName);
            $pstmt->bindValue(2, $this->clubID);
            $pstmt->bindValue(3, $this->projectChairID);
            $pstmt->bindValue(4, "active");
            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $this->projectID = $con->lastInsertId();
                $this->loadDataFromProectID($con);
            } else {

                return false;
            }
        } catch (PDOException $exc) {
            die("Error in Project Adding" . $exc->getMessage());
        }
    }

    public function loadDataFromProectID($con)
    {

        try {

            $con = DBConnector::getConnection();
            $query = "SELECT * FROM project WHERE project_id = ?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->projectID);
            $pstmt->execute();

            $rs = $pstmt->fetch(PDO::FETCH_OBJ);
            if (!empty($rs)) {
                $this->projectID = $rs->project_id;
                $this->projectName = $rs->name;
                $this->clubID = $rs->club_id;
                $this->projectChairID = $rs->project_chair_id;
                $this->status = $rs->status;

                return true;
            } else {
                return false;
            }


        } catch (PDOException $exc) {
            die("Error in Project details loading" . $exc->getMessage());
        }

    }

}