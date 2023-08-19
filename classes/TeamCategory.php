<?php

namespace classes;

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

    public static function getTeamCategoeryListFromProjectID($con, $projectID)
    {
        $teamCategories = array();
        try {

            $query = "SELECT * FROM team_category WHERE project_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $projectID);
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




}