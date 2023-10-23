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

    public function addUserToProject($con)
    {
        try {

            $query = "INSERT INTO project_team (category_id, ug_id) VALUES (?,?)";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->categoryID);
            $pstmt->bindValue(2, $this->ugID);
            $pstmt->execute();

            return $pstmt->rowCount() > 0;

        } catch (PDOException $exc) {
            return false;
        }

    }

    public function deleteUserFromProjectTeam($con)
    {
        try {

            $query = "DELETE FROM project_team WHERE ug_id=? AND category_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->ugID);
            $pstmt->bindValue(2, $this->categoryID);
            $pstmt->execute();

            return $pstmt->rowCount() > 0;

        } catch (PDOException $exc) {
            die("Error in deleting member from project team " . $exc->getMessage());
        }
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

    public static function getTeamMembersByCategoryID($con, $categoryID)
    {
        $teamMembers = array();
        try {
            $query = "SELECT u.* FROM undergraduate u JOIN project_team pt ON u.user_id = pt.ug_id WHERE pt.category_id = ?;";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $categoryID);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_ASSOC);

            $teamMembers[] = $rs;

        } catch
        (PDOException $exc) {
            die("Error in Member Data Loading " . $exc->getMessage());
        }
        return $teamMembers;
    }
    public static function getSecrataryMembersByCategoryID($con, $categoryID)
    {
        $teamMembers = array();
        try {
            $query = "SELECT u.* FROM undergraduate u JOIN project_team pt ON u.user_id = pt.ug_id WHERE pt.category_id = ?;";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $categoryID);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_ASSOC);

            $teamMembers[] = $rs;

        } catch
        (PDOException $exc) {
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