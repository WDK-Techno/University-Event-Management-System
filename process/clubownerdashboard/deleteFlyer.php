<?php

require_once '../../classes/DBConnector.php';
require_once '../../classes/PublicFlyer.php';

use classes\PublicFlyer;
use classes\DBConnector;

$con = DBConnector::getConnection();

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    if (isset($_POST["submit"])) {

        $flyer_Id = $_POST['flyer_id'];
        $publicflyer=new PublicFlyer(null,null,null,null,null,null,null,null,null);
        $publicflyer->setFlyerID($flyer_Id);
        $publicflyer->loadFlyerFromFlyerID($con);
        $publicflyer->setStatus("delete");
        $rs = $publicflyer->saveChangesToDatabase($con);

        if ($rs) {
            header("Location:../../clubowner-dashboard.php?tab=4");
        } else {
            header("Location:../../clubowner-dashboard.php?tab=4&errDelete=1");
        }
    }
}
