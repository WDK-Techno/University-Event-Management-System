<?php

namespace classes;



use PDOException;
use PDO;

class clubownerDashGetCount
{
    private $clubId;
    private $userCount;

    /**
     * @param $clubId
     */
    public function __construct($clubId, $userCount)
    {
        $this->clubId = $clubId;
        $this->userCount = $userCount;
    }

    /**
     * @param mixed $clubId
     */
    public function setClubId($clubId): void
    {
        $this->clubId = $clubId;
    }

    /**
     * @return mixed
     */
    public function getUserCount()
    {
        return $this->userCount;
    }

    public function loadCountToClubOwnerDashboard($con)
    {

        try {
            $query = "SELECT COUNT(ug.user_id) AS user_count
                         FROM undergraduate ug
                           JOIN project_team pt ON ug.user_id = pt.ug_id
                            JOIN team_category tc ON pt.category_id = tc.category_id
                             JOIN project p ON tc.project_id = p.project_id 
                              WHERE club_id=?";

            $pstmt=$con->prepare($query);
            $pstmt->bindValue(1, $this->clubId);
            $pstmt->execute();

            $rs=$pstmt->fetch(PDO::FETCH_OBJ);
            if($rs){
                $this->userCount = $rs->user_count;
            }
            else {

                $this->userCount = 0;
            }

        } catch (PDOException $exc) {
            die("Error in load count of User" . $exc->getMessage());

        }
    }


}