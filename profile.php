<?php
session_start();

require_once "classes/User.php";
require_once "classes/DBConnector.php";

use classes\Undergraduate;
use classes\DBConnector;

if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}
$userID = $_SESSION['user_id'];

$con = DBConnector::getConnection();
$user = new Undergraduate(null, null, null, null, null, null);
$user->setUserId($userID);
$user->loadDataFromUserID($con);

?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">
<head>

    <!-- ====== CSS Files ==== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="assets/css/profile.css" rel="stylesheet">

    <!-- ===== Boostrap CSS ==== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
          crossorigin="anonymous">
</head>
<!------ Include the above in your HEAD tag ---------->
<body>
<div class="container emp-profile">
    <form method="post">
        <div class="row">
            <div class="col-md-2">
                <div class="d-flex flex-column">
                    <img class="rounded-circle shadow-sm mx-auto"
                         style="width: 150px; height: 150px; object-fit: cover;"
                         src="assets/images/profile_img/ug/<?= $user->getProfileImg() ?>"
                         alt=""/>
                    <form action="" method="post"
                          enctype="multipart/form-data">
                        <div class="btn fw-bold d-flex mx-auto mt-2 shadow-sm" type="button"
                             onclick="fileUploadBtn()"
                             style="color: var(--lighter-secondary) !important; background-color: var(--primary);">
                            <ion-icon class="my-auto ms-auto me-1" style="font-size: 1.4rem;"
                                      name="cloud-upload-outline"></ion-icon>
                            <div class="my-auto ms-1 me-auto">Upload</div>
                            <input type="file" class="form-control d-none" name="image_upload"
                                   id="image_upload" onchange="saveImgSubmit()"/>

                        </div>
                        <!--======= hidden ==========-->
                        <input type="hidden" name="menuNo" value="7">
                        <input type="hidden" name="project_id"
                               value="<?= $user->getUserId() ?>">
                        <input class="d-none" type="submit" name="image_save_submit"
                               id="image_save_submit"/>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="profile-head">
                    <h5>
                        <?= $user->getFirstName() ?> <?= $user->getLastName() ?>
                    </h5>
<!--                    <h6>-->
<!--                        UWU Undergraduate-->
<!--                    </h6>-->

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                               aria-controls="home" aria-selected="true">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                               aria-controls="profile" aria-selected="false">Timeline</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-2">
                <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile"/>
            </div>
        </div>
        <div class="row">
            <!-- <div class="col-md-4">
                <div class="profile-work">
                    <p>WORK LINK</p>
                    <a href="">Website Link</a><br/>
                    <a href="">Bootsnipp Profile</a><br/>
                    <a href="">Bootply Profile</a>
                    <p>SKILLS</p>
                    <a href="">Web Designer</a><br/>
                    <a href="">Web Developer</a><br/>
                    <a href="">WordPress</a><br/>
                    <a href="">WooCommerce</a><br/>
                    <a href="">PHP, .Net</a><br/>
                </div>
            </div> -->
            <div class="col-md-6">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Name</label>
                            </div>
                            <div class="col-md-6">
                                <p><?= $user->getFirstName() ?> <?= $user->getLastName() ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Email</label>
                            </div>
                            <div class="col-md-6">
                                <p><?= $user->getUsername() ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Phone</label>
                            </div>
                            <div class="col-md-6">
                                <p><?= $user->getContactNo() ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Experience</label>
                            </div>
                            <div class="col-md-6">
                                <p>Expert</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Hourly Rate</label>
                            </div>
                            <div class="col-md-6">
                                <p>10$/hr</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Total Projects</label>
                            </div>
                            <div class="col-md-6">
                                <p>230</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>English Level</label>
                            </div>
                            <div class="col-md-6">
                                <p>Expert</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Availability</label>
                            </div>
                            <div class="col-md-6">
                                <p>6 months</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Your Bio</label><br/>
                                <p>Your detail description</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- ==== Boostrap Script ==== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>

<!-- ========= Ionicons Scripts ===== -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


</body>
</html>