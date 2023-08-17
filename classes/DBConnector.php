<?php

class DBConnector
{
    private $host = "localhost";
    private $db_name = "uwueventz_db";
    private $db_user = "root";
    private $db_password = "";
    public function getConnection(){
        $dsn = "mysql:host=$this->host;dbname=$this->db_name;";

        try {
            $con = new PDO($dsn,$this->db_user,$this->db_password);
            return $con;
        }catch (PDOException $exc){
            die("Error: ".$exc->getMessage());
        }
    }
}