<?php
session_start();
require_once "../classes/User.php";
require_once "../classes/DBConnector.php";

use classes\DBConnector;
use classes\User;
use classes\Undergraduate;
use classes\Club;

$con = DBConnector::getConnection();
if(isset($_POST['submit'],$_POST['username'],$_POST['password'])){
    if (empty($_POST['username']) || empty($_POST['password'])){
        header("location: ../login.php?status=1");
    }else{
        $userName = $_POST['username'];
        $passwrod = $_POST['password'];

        $user  = new User($userName,$passwrod);
        if ($user->authenticate($con)){

            $_SESSION['user_id'] = $user->getUserId();
            $_SESSION['role'] = $user->getRole();

            if ($user->getRole() == "ug"){
                if ($user->getStatus() == "active"){

                    $ug = new Undergraduate(null, null, null, null, null, null);
                    $ug->setUserId($user->getUserId());
                    $ug->loadDataFromUserID($con);

                    $_SESSION['profile_img'] = $ug->getProfileImg();

                    header("location: ../ug-dashboard.php");
                }
                if ($user->getStatus() == "deactive"){

                    $ug = new Undergraduate(null, null, null, null, null, null);
                    $ug->setUserId($user->getUserId());
                    $ug->loadDataFromUserID($con);

                    header("location: ../content/restrict.php?fname={$ug->getFirstName()}&lname={$ug->getLastName()}&typ=ug_deactive");
                }

            }
            if ($user->getRole() == "club"){
                if ($user->getStatus() == "active"){

                    $club = new Club(null, null, null, null);
                    $club->setUserId($user->getUserId());
                    $club->loadDataFromUserID($con);

                    $_SESSION['profile_img'] = $club->getProfileImage();

                    header("location: ../clubowner-dashboard.php");
                }
                if($user->getStatus() == "new"){
                    $club = new Club(null, null, null, null);
                    $club->setUserId($user->getUserId());
                    $club->loadDataFromUserID($con);

                    header("location: ../content/restrict.php?name={$club->getClubName()}&typ=new");
                }
                if($user->getStatus() == "deactive"){
                    $club = new Club(null, null, null, null);
                    $club->setUserId($user->getUserId());
                    $club->loadDataFromUserID($con);

                    header("location: ../content/restrict.php?name={$club->getClubName()}&typ=club_deactive");
                }
            }
            if ($user->getRole() == "admin"){
                header("location: ../superadmindashboard.php");
            }

        }else{
            header("location: ../login.php?status=2");
        }

    }
}
