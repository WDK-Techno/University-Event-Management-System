
<?php

require_once '../../classes/DBConnector.php';
require_once '../../classes/PublicFlyer.php';

use classes\DBConnector;
use classes\PublicFlyer;

$con=DBConnector::getConnection();

if($_SERVER['REQUEST_METHOD']==="POST"){
    if(isset($_POST['submit'])){
        if(!empty($_POST["flyerId"])&&!empty($_POST["clubId"])&&!empty($_POST["flyerUpdateTopic"])&&
            !empty($_POST["flyerUpdateCaption"])&&!empty($_POST["flyerUpdateLink"])&&!empty($_POST["flyerUpdateStartDate"])&&
            !empty($_POST["flyerUpdateEndDate"])){
            $flyerId=$_POST["flyerId"];
            $clubId=$_POST["clubId"];
            $flyerUpdateTopic=strip_tags($_POST["flyerUpdateTopic"]);
            $flyerUpdateCaption=strip_tags($_POST["flyerUpdateCaption"]);
            $flyerUpdateLink=strip_tags($_POST["flyerUpdateLink"]);
            $flyerUpdateStartDate=strip_tags($_POST["flyerUpdateStartDate"]);
            $flyerUpdateEndDate=strip_tags($_POST["flyerUpdateEndDate"]);

            $updateDate=new PublicFlyer(null,null,null,null,null,null,null,null,null);

            $updateDate->setClubID($clubId);


        }else{
            //is empty
            header("location: ../../clubowner-dashboard.php?tab=4");
        }


    }else{
        //is not submit
        header("location: ../../clubowner-dashboard.php?tab=4");
    }

}else{
    //is not post
    header("location: ../../clubowner-dashboard.php?tab=4");
}
