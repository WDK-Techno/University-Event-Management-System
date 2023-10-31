<?php


require_once "../../classes/User.php";
require_once "../../classes/DBConnector.php";

use classes\DBConnector;
use classes\Club;

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['submit'])) {
        $selectedMenuNo = $_POST['menuNo'];
        if (empty($_POST['club_name']) || empty($_POST['contact_no'])) {
            header("location: ../../clubowner-dashboard.php?tab={$selectedMenuNo}&saveEditErr=2");
        } else {
            $clubName = $_POST['club_name'];
            $contactNo = $_POST['contact_no'];
            $desc = $_POST['desc'];
            $club_id = $_POST['club_id'];

            $con = DBConnector::getConnection();
//            echo "work";
            $club = new Club(null,null,null,null);
            $club->setUserId($club_id);
            $club->loadDataFromUserID($con);
            $club->setClubName($clubName);
            $club->setContactNo($contactNo);
            $club->setClubDescription($desc);
            $rs = $club->saveChangesToDatabase($con);

            if ($rs) {
                header("location: ../../clubowner-dashboard.php?tab={$selectedMenuNo}");
            } else {
                header("location: ../../clubowner-dashboard.php?tab={$selectedMenuNo}&saveEditErr=1");
            }

        }
    }
}