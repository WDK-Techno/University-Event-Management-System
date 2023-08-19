<?php
namespace classes;
use PDO;
use PDOException;
class DBConnector
{
    private static $host = "localhost";
    private static $db_name = "uwueventz_db";
    private static $db_user = "root";
    private static $db_password = "";
    public static function getConnection(){

        try {
            $dsn = "mysql:host=".self::$host.";dbname=".self::$db_name ;
            $con = new PDO($dsn,self::$db_user,self::$db_password);
            return $con;
        }catch (PDOException $exc){
            die("Error in database connection: ".$exc->getMessage());
        }
    }
}