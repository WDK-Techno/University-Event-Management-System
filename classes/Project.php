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
    private $startDate;
    private $profileImage;
    private $endDate;
    private $description;
    private $designTeamID;
    private $writingTeamID;


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


    public function getStartDate()
    {
        return $this->startDate;
    }


    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    public function getProfileImage()
    {
        return $this->profileImage;
    }

    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;
    }


    public function getEndDate()
    {
        return $this->endDate;
    }


    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }


    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getDesignTeamID()
    {
        return $this->designTeamID;
    }

    public function setDesignTeamID($designTeamID): void
    {
        $this->designTeamID = $designTeamID;
    }

    public function getWritingTeamID()
    {
        return $this->writingTeamID;
    }

    public function setWritingTeamID($writingTeamID): void
    {
        $this->writingTeamID = $writingTeamID;
    }

    public function __construct($projectID, $projectName, $clubID, $projectChairID, $status, $startDate, $profileImage)
    {
        $this->projectID = $projectID;
        $this->projectName = $projectName;
        $this->clubID = $clubID;
        $this->projectChairID = $projectChairID;
        $this->status = $status;
        $this->startDate = $startDate;
        $this->profileImage = $profileImage;
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
                $this->loadDataFromProjectID($con);
                return true;
            } else {

                return false;
            }
        } catch (PDOException $exc) {
            die("Error in Project Adding" . $exc->getMessage());
        }
    }

    public function loadDataFromProjectID($con)
    {

        try {


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
                $this->startDate = $rs->start_date;
                $this->profileImage = $rs->profile_image;
                $this->endDate = $rs->end_date;
                $this->description = $rs->description;
                $this->designTeamID = $rs->design_team_id;
                $this->writingTeamID = $rs->writing_team_id;

                return true;
            } else {
                return false;
            }


        } catch (PDOException $exc) {
            die("Error in Project details loading" . $exc->getMessage());
        }

    }

    public function saveChangesToDataBase($con)
    {
        try {

            $query = "UPDATE project SET name=?,project_chair_id=?,status=?,start_date=?,
                   end_date=?,description=?,profile_image=?,design_team_id=?,writing_team_id=? WHERE project_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->projectName);
            $pstmt->bindValue(2, $this->projectChairID);
            $pstmt->bindValue(3, $this->status);
            $pstmt->bindValue(4, $this->startDate);
            $pstmt->bindValue(5, $this->endDate);
            $pstmt->bindValue(6, $this->description);
            $pstmt->bindValue(7, $this->profileImage);
            $pstmt->bindValue(8, $this->designTeamID);
            $pstmt->bindValue(9, $this->writingTeamID);
            $pstmt->bindValue(10, $this->projectID);
            $pstmt->execute();

            return $pstmt->rowCount() > 0;

        } catch (PDOException $exc) {
            die("Error in Update Database" . $exc->getMessage());
        }
    }


    public static function getProjectListFromClubID($con, $clubId)
    {

        $projects = array();
        try {

            $query = "SELECT * FROM project WHERE club_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $clubId);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($rs)) {

                foreach ($rs as $row) {
                    $project = new Project($row->project_id, $row->name,
                        $row->club_id, $row->project_chair_id, $row->status, $row->start_date, $row->profile_image);
                    $projects[] = $project;
                }

            }
        } catch (PDOException $exc) {
            die("Error in Database Loading" . $exc->getMessage());
        }

        return $projects;
    }

    public static function getProjectList($con)
    {

        $projects = array();
        try {

            $query = "SELECT * FROM project";
            $pstmt = $con->prepare($query);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($rs)) {

                foreach ($rs as $row) {
                    $project = new Project($row->project_id, $row->name,
                        $row->club_id, $row->project_chair_id, $row->status, $row->start_date, $row->profile_image);
                    $projects[] = $project;
                }

            }
        } catch (PDOException $exc) {
            die("Error in Database Loading" . $exc->getMessage());
        }

        return $projects;
    }


    public static function getProjectListFromUgId($con, $clubId, $ugId)
    {
        try {
            $query = "SELECT DISTINCT project.project_id
                   FROM project
                   JOIN team_category tc ON project.project_id = tc.project_id
                   JOIN project_team pt ON tc.category_id = pt.category_id
                   JOIN undergraduate ug ON pt.ug_id = ug.user_id
                   WHERE ug.user_id = ?
                     AND project.club_id = ?
                     AND project.status = 'active';

                ";
            $pstmt = $con->prepare($query);
            $pstmt->bindvalue(1, $ugId);
            $pstmt->bindvalue(2, $clubId);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if($rs){
                $projectDetails=array();
                foreach ($rs as $use ){
                    $pr=new Project(null,null,null,null,null,null,null);
                    $pr->setProjectID($use->project_id);
                    $projectDetails[]=$projectDetails;
                }
                return $projectDetails;
            }

        } catch (PDOException $exc) {
            die("Error in load count of Project" . $exc->getMessage());
        }

    }


}
