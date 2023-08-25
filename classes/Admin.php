<?php
namespace classes;

use classes\DBConnector;
use PDO;

class Admin{

    public function getUsers(){
        $dbuser = new DBConnector();
        $con = $dbuser->getConnection();
        $query = "SELECT u.user_name,ug.first_name,ug.last_name,ug.contact_no FROM user u JOIN undergraduate ug ON u.user_id = ug.user_id";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }

    public function getClubs(){
        $dbuser = new DBConnector();
        $con = $dbuser->getConnection();
        $query = "SELECT u.user_name,club.name,club.contact_no FROM user u JOIN club club ON u.user_id = club.user_id WHERE status = 'active'";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs; 
    }

    public function getRequests(){
        $dbuser = new DBConnector();
        $con = $dbuser->getConnection();
        $query = "SELECT u.user_id,u.user_name,club.name,club.contact_no FROM user u JOIN club club ON u.user_id = club.user_id WHERE status = 'new'";
    $pstmt = $con->prepare($query);
    $pstmt->execute();
    $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
    return $rs;
    }
    
    public function updateStatus($user_id){
        $dbuser = new DBConnector();
        $con = $dbuser->getConnection();
        $query = "UPDATE `user` SET status = 'active' WHERE user_id = ?" ;
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $user_id);
        $pstmt->execute();

    }

    public function declineRequest($user_id){
        $dbuser = new DBConnector();
        $con = $dbuser->getConnection();
        $query1 = "DELETE FROM `user` WHERE user_id = ?";
        $query2 = "DELETE FROM club WHERE user_id = ?";

        $pstmt2 = $con->prepare($query2);
        $pstmt2->bindValue(1,$user_id);
        $pstmt2->execute();

        $pstmt1 = $con->prepare($query1);
        $pstmt1->bindValue(1,$user_id);
        $pstmt1->execute();

    
    
    
    }
}