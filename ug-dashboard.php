<?php
session_start();
require_once 'classes/DBConnector.php';
require_once 'classes/Project.php';
require_once 'classes/User.php';
require_once 'classes/MainTask.php';
require_once 'classes/SubTask.php';

use classes\DBConnector;
use classes\Project;
use classes\Club;
use classes\Undergraduate;
use classes\MainTask;
use classes\SubTask;

$con = DBConnector::getConnection();

if (isset($_SESSION['user_id'])) {




    $ugID = $_SESSION['user_id'];

    //    $club = new Club(null, null, null, null);
    //    $club->setUserId($clubid);
    //    $loadClubData = $club->loadDataFromUserID($con);


    $ug = new Undergraduate(null, null, null, null, null, null);
    $ug->setUserId($ugID);
    $ug->loadDataFromUserID($con);
    $ug->saveChangesToDatabase($con);

    $subTasks = SubTask::getSubTaskListFromUserID($con, $ugID);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $selected_menuNo = 2;
        if (isset($_GET['tab'])) {
            $selected_menuNo = $_GET['tab'];
        }
    }

    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Undergraduate Dashboard</title>

        <!-- ====== CSS Files ==== -->
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- <link rel="stylesheet" href="assests/scss/style.scss"> -->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="assets/css/clubownerdash.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

        <!-- ===== Boostrap CSS ==== -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
              crossorigin="anonymous">


    </head>

    <body style="box-sizing: border-box;">

    <!-- =======  side bar ======= -->
    <div class="sideBar w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:block;" id="mySidebar">


        <!-- ======== side bar content ======= -->
        <div class="d-flex flex-column flex-shrink-0 p-3">

            <ion-icon id="openNav" class="d-block m-2" onclick="sideBarControl()"
                      name="chevron-back-circle-outline"></ion-icon>

            <!-- <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-4 m-2">Sidebar</span>
        </a> -->

            <div id="user-name" class="my-2 " style="font-weight:bold; font-size: 1.5rem;">
                <span class="d-block w3-text-light-blue"></span>
                <span class="d-block w3-text-cyan"><?= $ug->getFirstName() ?></span>
                <span class="d-block w3-text-cyan"><?= $ug->getLastName() ?></span>
            </div>

            <hr>
            <ul class="nav nav-pills flex-column navbar-text mb-auto">
                <!-- <li id="menu-1" class="sideBar-btn" onclick="showMenuContent(1)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="people-circle-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Projects</span>
                    </a>
                </li> -->
                <li id="menu-2" class="sideBar-btn" onclick="showMenuContent(2)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="calendar-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Task</span>
                    </a>
                </li>
                <!-- <li id="menu-3" class="sideBar-btn" onclick="showMenuContent(3)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="walk-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">User Tracker</span>
                    </a>
                </li> -->
                <!-- <li id="menu-4" class="sideBar-btn" onclick="showMenuContent(4)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="document-text-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Progress</span>
                    </a>
                </li> -->
                <li id="menu-5" class="sideBar-btn" onclick="showMenuContent(5)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="settings-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Settings</span>
                    </a>
                </li>
            </ul>
            <hr>
        </div>
    </div>

    <!-- ============== main content ===================== -->
    <div id="main" style="height: 100vh;">

        <!-- ======= Navigation Bar =======    -->
        <div class="">
            <div class="navbar navbar-light bg-light container-fluid px-4 d-flex justify-content-between">
                <a class="navbar-brand text-primary d-none d-sm-block" href="index.html">UWU<span class="text-dark">Event</span><span
                            class="text-warning">z</span></a>
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button> -->
                <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
                <div id="project-name" class="ms-0 me-auto mx-sm-auto">
                    <!--                    --><?php //= $ug->getFirstName()
                    ?>
                </div>
                <div class="d-flex" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li> -->
                    </ul>

                    <div class="btn-group ms-auto me-0">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <!--                            <img id="user-img" src="https://github.com/mdo.png" alt="" width="40" class="rounded-circle">-->
                            <img class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;"
                                 src="assets/images/profile_img/ug/<?= $ug->getProfileImg() ?>" alt="">
                        </a>
                        <ul class="dropdown-menu shadow dropdown-menu-end">
                            <!-- <li class="dropdown-item d-flex justify-content-start px-4"><ion-icon name="person-outline" style="font-size: 1.2rem;" class="me-2"></ion-icon><span>Profile</span></li>
                        <li class="dropdown-item d-flex justify-content-start px-4"><ion-icon name="arrow-undo-outline" style="font-size: 1.2rem;" class="me-2"></ion-icon><span>Userboard</span></li> -->
                            <!--                            <li class="dropdown-item d-flex justify-content-start px-4"><span>Userboard</span><ion-icon name="arrow-undo-outline" class="ms-auto" style="font-size: 1.2rem;"></ion-icon>-->
                            <!--                            </li>-->
                            <!--                            <li class="dropdown-item d-flex justify-content-start px-4"><span>Profile</span><ion-icon name="person-outline" class="ms-auto" style="font-size: 1.2rem;"></ion-icon></li>-->
                            <!--                            <li>-->
                            <!--                                <hr class="dropdown-divider">-->
                            <!--                            </li>-->
                            <form action="process/logout.php" method="post">
                                <button class="dropdown-item d-flex justify-content-start px-4" type="submit"
                                        name="submit1">
                                    <span>Logout</span>
                                    <ion-icon name="log-out-outline" class="ms-auto"
                                              style="font-size: 1.2rem;"></ion-icon>
                                </button>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>
        </div>


        <div id="menu-content-1" class="main-content hide ms-1">
        </div>
        <div id="menu-content-2" class="main-content hide">
            <div class="m-4">
                <h1>Task </h1>
            </div>


            <div class="card mx-4" style="">
                <div class="card-header team-member-table pb-0"
                     style="background-color: var(--darker-primary); color: var(--lighter-secondary);">

                    <div class="row p-0 fw-bold">
                        <div class="col-1"></div>
                        <div class="col-3 text-center py-2 rounded-top-3"
                             style="background-color: var(--primary);">Project Name
                        </div>
                        <div class="col-3 text-center py-2 rounded-top-3"
                             style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                            Task
                        </div>
                        <div class="col-2 text-center py-2 rounded-top-3"
                             style="background-color: var(--primary);">DeadLine
                        </div>
                        <div class="col-2 text-center py-2 rounded-top-3"
                             style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                            Task Complete
                        </div>

                        <div class="col-1">

                        </div>
                    </div>

                </div>

                <div class="card-body pt-0 bg-dark-subtle scrollable-div Flipped"
                     style="background-color: var(--secondary);">
                    <div class="container p-0 scrollable-div-inside">

                        <?php
                        foreach ($subTasks as $subTask) {
                            $subTaskObj = new SubTask($subTask->getSubTaskID(), null, null, null, null, null, null, null);
                            $subTaskObj->loadSubTaskFromSubTaskID($con);
                            $project = new Project($subTaskObj->getProjectID(), null, null, null, null, null, null);
                            $project->loadDataFromProjectID($con);
                            ?>

                            <form action="process/ug-dashboard/editTask_compleat.php" method="post">
                            <div class="row mb-2 shadow-sm set-border" style="height: 50px;">
                                <div class="col-1 d-flex tabel-column-type-2">
                                    <div class="my-auto">
                                        <img class="rounded-circle"
                                             style="width: 40px; height: 40px; object-fit: cover;"
                                             src="assets/images/profile_img/project/<?=$project->getProfileImage()?>"
                                             alt="">
                                    </div>
                                </div>
                                <div class="col-3 tabel-column-type-1 d-flex">
                                    <div class="my-auto"><?= $project->getProjectName() ?></div>
                                </div>
                                <div class="col-3 d-flex tabel-column-type-2">
                                    <div class="my-auto mx-auto"><?=$subTaskObj->getSubTaskName() ?></div>
                                </div>
                                <div class="col-2 d-flex tabel-column-type-1">
                                    <div class="my-auto mx-auto"><?=$subTaskObj->getDeadline() ?></div>
                                </div>
                                <div class="col-2 d-flex tabel-column-type-2">
                                    <div class="my-auto mx-auto">
                                        <input type="checkbox" id="cheak" name='checkTask[]' value="<?=$subTaskObj->getSubTaskID() ?>"></div>
                                </div>
                                <div class="col-1 tabel-column-type-1 d-flex">
                                    <div class="d-flex my-auto mx-auto" style="font-size: 1.5rem;">


                                        <ion-icon class="my-auto" type="button"
                                                  data-bs-toggle="modal"
                                                  data-bs-target=""
                                                  name="trash-outline"></ion-icon>
                                    </div>
                                </div>
                            </div>

                            <?php

                        }
                        ?>
                                <div>
                                    <button class="update-button" type="submit" name="update">Update</button>
                                </div>
                            </form>
                        <!--                                        <div class="row mb-2 shadow-sm set-border" style="height: 50px; background-color:#A3A2EC;">-->
                        <!--                                            <div class="col-1 d-flex tabel-column-type-2">-->
                        <!--                                                <div class="my-auto">-->
                        <!--                                                    <img class="rounded-circle"-->
                        <!--                                                         style="width: 40px; height: 40px; object-fit: cover;"-->
                        <!--                                                         src="assets/images/profile_img/project/64e77ce044cd33.38133607.png"-->
                        <!--                                                         alt="">-->
                        <!--                                                </div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-3 tabel-column-type-1 d-flex">-->
                        <!--                                                <div class="my-auto">JamborIEEE23</div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-3 d-flex tabel-column-type-2">-->
                        <!--                                                <div class="my-auto mx-auto">Design flyer</div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-2 d-flex tabel-column-type-1">-->
                        <!--                                                <div class="my-auto mx-auto">2023/10/20</div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-2 d-flex tabel-column-type-2">-->
                        <!--                                                <div class="my-auto mx-auto"><input type="checkbox" id="cheak" name="vehicle1" value="finished"></i></div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-1 tabel-column-type-1 d-flex">-->
                        <!--                                                <div class="d-flex my-auto mx-auto" style="font-size: 1.5rem;">-->
                        <!---->
                        <!--                                                   -->
                        <!--                                                    <ion-icon class="my-auto" type="button"-->
                        <!--                                                              data-bs-toggle="modal"-->
                        <!--                                                              data-bs-target=""-->
                        <!--                                                              name="trash-outline"></ion-icon>-->
                        <!--                                                </div>-->
                        <!--                                            </div>-->
                        <!--                                        </div>-->
                        <!--                                        <div class="row mb-2 shadow-sm set-border" style="height: 50px;">-->
                        <!--                                            <div class="col-1 d-flex tabel-column-type-2">-->
                        <!--                                                <div class="my-auto">-->
                        <!--                                                    <img class="rounded-circle"-->
                        <!--                                                         style="width: 40px; height: 40px; object-fit: cover;"-->
                        <!--                                                         src="assets/images/profile_img/project/64e87d4ab4ca82.40177324.png"-->
                        <!--                                                         alt="">-->
                        <!--                                                </div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-3 tabel-column-type-1 d-flex">-->
                        <!--                                                <div class="my-auto">IEEE INNAVATION NATION SRI LANKA</div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-3 d-flex tabel-column-type-2">-->
                        <!--                                                <div class="my-auto mx-auto">Create Logo</div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-2 d-flex tabel-column-type-1">-->
                        <!--                                                <div class="my-auto mx-auto">2023/11/10</div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-2 d-flex tabel-column-type-2">-->
                        <!--                                                <div class="my-auto mx-auto"><input type="checkbox" id="cheak" name="vehicle1" value="finished"></div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-1 tabel-column-type-1 d-flex">-->
                        <!--                                                <div class="d-flex my-auto mx-auto" style="font-size: 1.5rem;">-->
                        <!---->
                        <!--                                                   -->
                        <!--                                                    <ion-icon class="my-auto" type="button"-->
                        <!--                                                              data-bs-toggle="modal"-->
                        <!--                                                              data-bs-target=""-->
                        <!--                                                              name="trash-outline"></ion-icon>-->
                        <!--                                                </div>-->
                        <!--                                            </div>-->
                        <!--                                        </div>-->
                        <!--                                        <div class="row mb-2 shadow-sm set-border" style="height: 50px; background-color:#A3A2EC;" >-->
                        <!--                                            <div class="col-1 d-flex tabel-column-type-2">-->
                        <!--                                                <div class="my-auto">-->
                        <!--                                                    <img class="rounded-circle"-->
                        <!--                                                         style="width: 40px; height: 40px; object-fit: cover;"-->
                        <!--                                                         src="assets/images/profile_img/project/64e87d4ab4ca82.40177324.png"-->
                        <!--                                                         alt="">-->
                        <!--                                                </div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-3 tabel-column-type-1 d-flex">-->
                        <!--                                                <div class="my-auto">IEEE INNAVATION NATION SRI LANKA</div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-3 d-flex tabel-column-type-2">-->
                        <!--                                                <div class="my-auto mx-auto">Design flyer</div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-2 d-flex tabel-column-type-1">-->
                        <!--                                                <div class="my-auto mx-auto">2023/11/23</div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-2 d-flex tabel-column-type-2">-->
                        <!--                                                <div class="my-auto mx-auto"><input type="checkbox" id="cheak" name="vehicle1" value="finished"></i></div>-->
                        <!--                                            </div>-->
                        <!--                                            <div class="col-1 tabel-column-type-1 d-flex">-->
                        <!--                                                <div class="d-flex my-auto mx-auto" style="font-size: 1.5rem;">-->
                        <!---->
                        <!--                                                   -->
                        <!--                                                    <ion-icon class="my-auto" type="button"-->
                        <!--                                                              data-bs-toggle="modal"-->
                        <!--                                                              data-bs-target=""-->
                        <!--                                                              name="trash-outline"></ion-icon>-->
                        <!--                                                </div>-->
                        <!--                                            </div>-->
                        <!--                                        </div>-->

                    </div>
                </div>
            </div>

        </div>
        <div id="menu-content-3" class="main-content hide">
            <h1>Content 3</h1>
        </div>
        <div id="menu-content-4" class="main-content hide">
            <h1>Content 4</h1>
        </div>
        <div id="menu-content-5" class="main-content hide">

            <div class="text-center d-flex">

                <!-- ======= project image area ===== -->
                <div class="d-flex flex-column mx-auto my-3">
                    <img class="rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;"
                         src="assets/images/profile_img/ug/<?= $ug->getProfileImg() ?>" alt="">
                    <form action="process/ug-dashboard/saveProfileImage.php" method="post"
                          enctype="multipart/form-data">
                        <div class="btn fw-bold d-flex mx-4 mt-2 shadow-sm" type="button" onclick="fileUploadBtn()"
                             style="color: var(--lighter-secondary) !important; background-color: var(--primary);">
                            <ion-icon class="my-auto ms-auto me-1" style="font-size: 1.4rem;"
                                      name="cloud-upload-outline"></ion-icon>
                            <div class="my-auto ms-1 me-auto">Upload</div>
                            <input type="file" class="form-control d-none" name="image_upload" id="image_upload"
                                   onchange="saveImgSubmit()"/>

                        </div>
                        <!--======= hidden ==========-->
                        <input type="hidden" name="menuNo" value="5">
                        <input type="hidden" name="ug_id" value="<?= $ug->getUserId() ?>">
                        <input class="d-none" type="submit" name="image_save_submit" id="image_save_submit"/>
                    </form>
                </div>

            </div>

            <div class="card shadow-sm mb-3 mx-auto w-50">
                <div class="card-header py-3">
                    <p class="m-0 fw-bold" style="color: var(--darker-primary); font-size: 1.3rem;">Undergraduate
                        Settings</p>
                </div>
                <div class="card-body">
                    <form action="process/ug-dashboard/edtUgDetails.php" method="POST">
                        <div class="d-flex flex-column" style="color: var(--primary);">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="first_name">
                                        <strong>First Name</strong>
                                    </label>
                                    <input id="first_name" class="form-control" type="text"
                                           value="<?= $ug->getFirstName() ?>" name="first_name"/>
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label" for="last_name">
                                        <strong>Last Name</strong>
                                    </label>
                                    <input id="last_name" class="form-control" type="text"
                                           value="<?= $ug->getLastName() ?>" name="last_name"/>
                                </div>
                            </div>
                            <div class="fw-bold">Contact Number</div>
                            <input id="contact_no" class="form-control" type="text" value="<?= $ug->getContactNo() ?>"
                                   name="contact_no"/>
                        </div>
                        <!--======= hidden ==========-->
                        <input type="hidden" name="menuNo" value="5">
                        <input type="hidden" name="ug_id" value="<?= $ug->getUserId() ?>">

                        <button class="btn fw-bold d-flex mt-2 ms-auto me-0"
                                style="width: 127px; color: var(--lighter-secondary) !important; background-color: var(--primary);"
                                type="submit" name="submit">
                            <ion-icon class="my-auto ms-auto me-1" style="font-size: 1.4rem;"
                                      name="save-outline"></ion-icon>
                            <div class="my-auto ms-1 me-auto">Save</div>

                        </button>
                    </form>
                </div>
            </div>


        </div>

    </div>
    <!--=== pre loader ===-->
    <?php include_once "content/preloader.php" ?>
    <!--=== Preloader Script file ===-->
    <?php include_once "content/commonJS.php" ?>

    <!--    =============== execute upload image button ==========-->
    <script>
        function fileUploadBtn() {
            document.getElementById('image_upload').click();

        }

        function saveImgSubmit() {
            document.getElementById('image_save_submit').click();
        }
    </script>

    <!--=========== Selected Menu change when loading ============-->
    <script>
        document.getElementById("menu-<?php echo $selected_menuNo ?>").classList.add("activate");
        document.getElementById("menu-content-<?php echo $selected_menuNo ?>").classList.remove("hide");
        document.getElementById("menu-content-<?php echo $selected_menuNo ?>").classList.add("show");
    </script>

    <!-- ==== Boostrap Script ==== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
            crossorigin="anonymous"></script>
    <!-- ========= Ionicons Scripts ===== -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- ====== Script files ===== -->
    <script src="assets/js/ug-dashboard.js"></script>

    </body>

    </html>


    <?php
} else {
    header("location: login.php");
}
?>