<?php

require_once '../../classes/DBConnector.php';
require_once '../../classes/PublicFlyer.php';

use classes\DBConnector;
use classes\PublicFlyer;

$con=DBConnector::getConnection();

if($_SERVER['REQUEST_METHOD']==="POST"){
    if(isset($_POST['submit'])){
      if( $_FILES['fl_image']['error'] === UPLOAD_ERR_OK){
          if (pathinfo($_FILES['fl_image']['name'])['extension'] == "jpg" ||
              pathinfo($_FILES['fl_image']['name'])['extension'] == "jpeg" ||
              pathinfo($_FILES['fl_image']['name'])['extension'] == "jpg" ||
              pathinfo($_FILES['fl_image']['name'])['extension'] == "png") {
              $fl_caption=strip_tags($_POST['caption']);
              $fl_StartDate = $_POST['start_date'];
              $fl_EndDate = $_POST['end_date'];
              $club_id=$_POST['club_id'];
              $fl_link=$_POST['url'];


              $filename = $_FILES['fl_image']['name'];
              $tempname = $_FILES['fl_image']['tmp_name'];
              $folder = "../../assets/images/flyer_img/" . $filename;

              if (move_uploaded_file($tempname, $folder)) {
                  $publicFlyer=new PublicFlyer(null,$fl_StartDate,$fl_EndDate,$fl_caption,$fl_link,$filename,$club_id,"active");
                  $rs=$publicFlyer->addNewFlyer($con);

                  if ($rs){
                      header("location: ../../clubowner-dashboard.php?tab=4");
                  }else{
                      header("location: ../../clubowner-dashboard.php?tab=4&err=3");
                  }
              }
          }
      }

    }
}

