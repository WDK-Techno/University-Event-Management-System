<?php

namespace classes;

use PDOException;
use PDO;

class TeamMember
{
    private $categoryID;
    private $ugID;


    public function __construct($categoryID, $ugID)
    {
        $this->categoryID = $categoryID;
        $this->ugID = $ugID;
    }

    public static function getMemberListFromCategoryID($con, $categoryID)
    {
        $teamMembers = array();
        try {
            $query = "SELECT * FROM project_team WHERE category_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $categoryID);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(\PDO::FETCH_OBJ);
            if (!empty($rs)) {
                foreach ($rs as $row) {
                    $teamMember = new TeamMember($row->category_id, $row->ug_id);
                    $teamMembers[] = $teamMember;
                }
            }

        } catch (PDOException $exc) {
            die("Error in Member Data Loading " . $exc->getMessage());
        }
        return $teamMembers;
    }

    public static function getMemberListFromProjectID($con, $projectID)
    {
        $teamMembers = array();
        try {

            $query = "SELECT * FROM project_team WHERE category_id IN 
                                 (SELECT category_id FROM team_category WHERE project_id=?)";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $projectID);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(\PDO::FETCH_OBJ);
            if (!empty($rs)) {
                foreach ($rs as $row) {
                    $teamMember = new TeamMember($row->category_id, $row->ug_id);
                    $teamMembers[] = $teamMember;
                }
            }

        } catch (PDOException $exc) {
            die("Error in Member Data Loading " . $exc->getMessage());
        }
        return $teamMembers;
    }

    public function getCategoryID()
    {
        return $this->categoryID;
    }


    public function setCategoryID($categoryID)
    {
        $this->categoryID = $categoryID;
    }


    public function getUgID()
    {
        return $this->ugID;
    }


    public function setUgID($ugID)
    {
        $this->ugID = $ugID;
    }


}