<?php

namespace classes;
use PDO;
use PDOException;

class TeamCategory
{
    private $categoryID;
    private $categoryName;
    private $projectID;
    private $status;

    public function getCategoryID()
    {
        return $this->categoryID;
    }

    public function setCategoryID($categoryID)
    {
        $this->categoryID = $categoryID;
    }


    public function getCategoryName()
    {
        return $this->categoryName;
    }


    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
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

    public function __construct($categoryID, $categoryName, $projectID, $status)
    {
        $this->categoryID = $categoryID;
        $this->categoryName = $categoryName;
        $this->projectID = $projectID;
        $this->status = $status;
    }

    public function loadDataByTeamID($con){
        try {

            $query = "SELECT * FROM team_category WHERE category_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->categoryID);
            $pstmt->execute();
            $rs = $pstmt->fetch(\PDO::FETCH_OBJ);
            if (!empty($rs)){
                $this->categoryID = $rs->category_id;
                $this->categoryName = $rs->category_name;
                $this->projectID = $rs->project_id;
                $this->status = $rs->status;

                return true;
            }else{
                return false;
            }

        } catch (PDOException $exc) {
            die("Error in Team Category Loading " . $exc->getMessage());
        }


    }

    public function addNewTeam($con)
    {
        try {


            $query = "INSERT INTO team_category (category_name, project_id, status) 
                    VALUES (?,?,?)";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->categoryName);
            $pstmt->bindValue(2, $this->projectID);
            $pstmt->bindValue(3, $this->status);
            $pstmt->execute();

            return $pstmt->rowCount() > 0;

        } catch (PDOException $exc) {
            die("Error in Team Category Inserting " . $exc->getMessage());
        }

    }
    public function deleteTeamCategory($con){
        try {

            $query = "DELETE FROM team_category WHERE category_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1,$this->categoryID);
            $pstmt->execute();

            return $pstmt->rowCount()>0;

        }catch (PDOException $exc){
            die("Error in deleting Team Category ". $exc->getMessage());
        }
    }
    public static function getTeamCategoeryListFromProjectID($con, $projectID)
    {
        $teamCategories = array();
        try {

            $query = "SELECT * FROM team_category WHERE project_id=? AND status=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $projectID);
            $pstmt->bindValue(2, "active");
            $pstmt->execute();
            $rs = $pstmt->fetchAll(\PDO::FETCH_OBJ);
            if (!empty($rs)) {
                foreach ($rs as $row) {
                    $teamCategory = new TeamCategory($row->category_id, $row->category_name,
                        $row->project_id, $row->status);
                    $teamCategories[] = $teamCategory;
                }
            }

        } catch (PDOException $exc) {
            die("Error in Team Category Loading " . $exc->getMessage());
        }
        return $teamCategories;
    }

    public function updateChanges($con)
    {

        try {

            $query = "UPDATE team_category SET category_name=?,status=? WHERE category_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->getCategoryName());
            $pstmt->bindValue(2, $this->getStatus());
            $pstmt->bindValue(3, $this->getCategoryID());
            $pstmt->execute();

            return $pstmt->rowCount() > 0;
        } catch (PDOException $exc) {
            die("Error in Team Category Changes Updating " . $exc->getMessage());
        }

    }


    public static function getTeamCategoryFromUgId($con, $clubId, $ugId)
    {
        try {
            $query = "SELECT tc.*
                           FROM undergraduate ug
                           JOIN project_team pt ON ug.user_id = pt.ug_id
                           JOIN team_category tc ON pt.category_id = tc.category_id
                           JOIN project p ON tc.project_id = p.project_id
                           WHERE ug.user_id = ?
                             AND p.club_id = ? AND p.status='active';

                ";
            $pstmt = $con->prepare($query);
            $pstmt->bindvalue(1, $ugId);
            $pstmt->bindvalue(2, $clubId);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if($rs){
                $teamDetails=array();
                foreach ($rs as $use ){
                    $pr=new TeamCategory(null,null,null,null);
                    $pr->setCategoryID($use->category_id);
                    $pr->setCategoryName($use->category_name);
                     $teamDetails[]=$teamDetails;
                }
                return $teamDetails;
            }

        } catch (PDOException $exc) {
            die("Error in load count of Project" . $exc->getMessage());
        }

    }






}