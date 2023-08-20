<?php
namespace classes;

use classes\DBConnector;
use PDO;

class admin{

    public function getUsers(){
        $dbuser = new DBConnector();
        $con = $dbuser->getConnection();
        $query = "SELECT u.user_name,ug.first_name,ug.last_name,ug.contact_no FROM user u JOIN undergraduate ug ON u.user_id = ug.user_id";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
        return $rs;
    }
}