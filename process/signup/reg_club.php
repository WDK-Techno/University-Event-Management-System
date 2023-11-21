<?php
require_once "../../classes/User.php";
require_once "../../classes/DBConnector.php";

use classes\Club;
use classes\DBConnector;

$con = DBConnector::getConnection();

if (isset($_POST["submit"],$_POST["username"],$_POST["password"],
    $_POST["club_name"],$_POST["contact_no"])){

    if (empty($_POST["username"]) || empty($_POST["password"]) ||
        empty($_POST["club_name"]) || empty($_POST["contact_no"])){

        header("location: ../../content/club_signup.php?status=1");
    }else{

        $userName = $_POST["username"];
        $password = password_hash($_POST["password"],PASSWORD_BCRYPT);
        $clubName = $_POST["club_name"];
        $contactNo = $_POST["contact_no"];
        $targetDirectory = "../../assets/upload/";
        $filename = basename($_FILES["pdfFile"]["name"]);
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        $targetFilePath = $targetDirectory.$filename;

        if(strtolower($filetype) === "pdf"){
            if(move_uploaded_file($_FILES["pdfFile"]["tmp_name"], $targetFilePath)){
                $club = new Club($userName,$password,$clubName,$contactNo);

                if ($club->checkDuplicateEmail($con)){
                    header("location: ../../content/club_signup.php?status=3");
                }else{
                    $result = $club->registerClub($con, $filename);
                    if ($result){
                        header("location: ../../login.php");
                    }else{
                        header("location: ../../content/club_signup.php?status=2");
                    }
                }
            }
        }
       


    }

}else{
    header("location: ../../content/club_signup.php?status=1");
}