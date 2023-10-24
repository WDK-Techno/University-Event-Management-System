<?php
session_start();
require_once 'classes/DBConnector.php';
require_once 'classes/Project.php';
require_once 'classes/User.php';
require_once 'classes/PublicFlyer.php';

use classes\DBConnector;
use classes\Project;
use classes\Club;
use classes\Undergraduate;
use classes\PublicFlyer;


$con = DBConnector::getConnection();

if (isset($_SESSION['user_id'])) {


    $clubid = $_SESSION['user_id'];
    $projects = Project::getProjectListFromClubID($con, $clubid);
    $publicFlyers = PublicFlyer::getFlyersListFromClubID($con, $clubid);

    $club = new Club(null, null, null, null);
    $club->setUserId($clubid);
    $loadClubData = $club->loadDataFromUserID($con);


    $undergraduate = new Undergraduate('', '', '', '', '', '');
    $undergraduate->setUserId($clubid);
    $loadUserData = $undergraduate->loadDataFromUserID($con);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $selected_menuNo = 1;
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
        <title>Document</title>

        <!-- ====== CSS Files ==== -->
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- <link rel="stylesheet" href="assests/scss/style.scss"> -->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="assets/css/clubownerdash.css">

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
            <?php

            if ($loadClubData) {
                ?>
                <div id="user-name" class="my-2 " style="font-weight:bold; font-size: 1.5rem;">
                    <span class="d-block w3-text-light-blue"></span>
                    <span class="d-block w3-text-cyan"><?= $club->getClubName() ?></span>
                </div>

                <hr>
                <ul class="nav nav-pills flex-column navbar-text mb-auto">
                    <li id="menu-1" class="sideBar-btn" onclick="showMenuContent(1)">
                        <a href="#" class="nav-link d-flex justify-content-start">
                            <ion-icon name="people-circle-outline"></ion-icon>
                            <span class="sideBar-btn-text my-auto">Projects</span>
                        </a>
                    </li>
                    <li id="menu-2" class="sideBar-btn" onclick="showMenuContent(2)">
                        <a href="#" class="nav-link d-flex justify-content-start">
                            <ion-icon name="calendar-outline"></ion-icon>
                            <span class="sideBar-btn-text my-auto">Club Analysis</span>
                        </a>
                    </li>
                    <li id="menu-3" class="sideBar-btn" onclick="showMenuContent(3)">
                        <a href="#" class="nav-link d-flex justify-content-start">
                            <ion-icon name="walk-outline"></ion-icon>
                            <span class="sideBar-btn-text my-auto">User Tracker</span>
                        </a>
                    </li>
                    <li id="menu-4" class="sideBar-btn" onclick="showMenuContent(4)">
                        <a href="#" class="nav-link d-flex justify-content-start">
                            <ion-icon name="document-text-outline"></ion-icon>
                            <span class="sideBar-btn-text my-auto">Public Flyers</span>
                        </a>
                    </li>
                    <li id="menu-5" class="sideBar-btn" onclick="showMenuContent(5)">
                        <a href="#" class="nav-link d-flex justify-content-start">
                            <ion-icon name="settings-outline"></ion-icon>
                            <span class="sideBar-btn-text my-auto">Settings</span>
                        </a>
                    </li>
                </ul>
                <hr>
            <?php } ?>
        </div>
    </div>
    <!-- ============== main content ===================== -->
    <div id="main" style="height: 100vh; overflow-y: hidden;">

        <!-- ======= Navigation Bar =======    -->
        <div class="">
            <div class="navbar navbar-light bg-light container-fluid px-4 d-flex justify-content-between">
                <a class="navbar-brand text-primary d-none d-sm-block" href="index.html">UWU<span
                            class="text-dark">Event</span><span class="text-warning">z</span></a>
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button> -->
                <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
                <div id="project-name" class="ms-0 me-auto mx-sm-auto"><?= $club->getClubName() ?></div>
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
                            <img class="rounded-circle"
                                 style="width: 40px; height: 40px; object-fit: cover;"
                                 src="assets/images/profile_img/club/<?= $club->getProfileImage() ?>"
                                 alt="">
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


        <div id="menu-content-1" class="main-content hide ms-1" style="height: 100%; overflow-y: hidden;">
            <div class="d-flex mt-3 mb-2 ">
                <button class="btn fw-bold d-flex ms-2 shadow-sm"
                        style=" color: var(--lighter-secondary) !important; background-color: var(--primary);"
                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <ion-icon class="my-auto" name="add-outline"
                              style="font-size: 1.4rem;"></ion-icon>
                    <div class="my-auto ms-1 me-auto">Create New</div>
                </button>

            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-2 px-2"
                             style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                            <!--                                <h5 class="modal-title" id="exampleModalLabel">Project details</h5>-->
                            <div class="ms-2 my-auto fs-4 fw-bold">
                                Create Project
                            </div>
                            <!--                                <button type="button" class="btn-close" data-bs-dismiss="modal"-->
                            <!--                                        aria-label="Close"></button>-->
                        </div>
                        <form action="process/clubownerdashboard/addproject.php" method="POST"
                              enctype="multipart/form-data">
                            <div class="modal-body" style="background-color: var(--lighter-secondary);">

                                <div class="d-flex px-5">
                                    <input class="form-control text-center" type="text"
                                           name="project_name" id="add-project-name-input"
                                           placeholder="Project Name" required/>
                                </div>
                                <div class="mt-3 border border-secondary-subtle rounded bg-body-secondary shadow-sm px-1 py-1 mx-5  d-flex flex-column px-5">
                                    <div class="fw-bold my-2" style="color: var(--primary);">Project Chair</div>
                                    <input class="form-control mb-4 text-center" type="email"
                                           name="username" id="add-project-username-input"
                                           placeholder="Email" required/>
                                </div>

                                <div class="mt-2 text-center" id="add-project-error"
                                     style="color: var(--accent-color3)"></div>

                            </div>
                            <div class="modal-footer" style="background-color: var(--primary);">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                </button>
                                <button type="button"
                                        onclick="createNewProject()"
                                        class="btn fw-bold"
                                        style="background-color: var(--secondary); color: var(--primary);">
                                    ADD
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <hr/>


            <div class="row gy-2 row-cols-1 row-cols-md-2 row-cols-xl-4" style="overflow-y: scroll; height: 80vh">


                <?php
                $i = 1;
                foreach ($projects

                         as $project) {
                    if ($project->getStatus() !== "delete") {


                        ?>

                        <div class="col">

                            <div class="rounded border">
                                <div class="card d-block shadow-sm">
                                    <div class="card-header p-3 text-white"
                                         style="background-color: var(--primary)">
                                        <h5 class="card-title fw-bold"
                                            style="font-size: 1.5rem"><?= $project->getProjectName() ?></h5>
                                        <form action="process/clubownerdashboard/getIntoProject.php" method="post">
                                            <!--==== hidden ======-->
                                            <input type="hidden" name="project_id"
                                                   value="<?= $project->getProjectID() ?>">

                                            <button type="submit" name="submit" class="btn my-2 btn-outline-light">
                                                Access
                                            </button>
                                        </form>
                                    </div>
                                    <div class="card-body py-4 d-flex">
                                        <div class="  flex-row">
                                            <div class="toggle-button-cover">
                                                <div class="button-cover">
                                                    <div class="button shadow-sm r" id="button-3">
                                                        <input type="checkbox" class="checkbox status-toggle"
                                                               name="project-id-<?= $project->getProjectID() ?>"
                                                               checked>
                                                        <div class="knobs"></div>
                                                        <div class="layer"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <form action="process/clubownerdashboard/deleteProject.php"
                                                      method="post">
                                                    <input type="hidden" name="user_id"
                                                           value="<?= $project->getProjectID() ?>">
                                                    <button type="submit" name="submit" class="btn btn-danger"
                                                            style="border: none;width: 96px;height: 38px;">Delete
                                                    </button>
                                                </form>
                                            </div>

                                        </div>


                                        <!-------------------------------------------------->
                                        <div class="d-flex" style="width:200px">
                                            <img class="img-thumbnail shadow-sm"
                                                 style="width: 150px; height: 150px;"
                                                 src="assets/images/profile_img/project/<?= $project->getProfileImage() ?>"
                                                 alt="">
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>
                        <?php
                    }
                    $i++;
                } ?>
            </div>
        </div>


        <div id="menu-content-2" class="main-content hide">

            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-eco">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h4 class="title-text mt-0">Total projects</h4>
                                    <h3 class="font-weight-semibold mb-1">24k</h3>
                                </div>
                                <!--end col-->
                                <div class="col-4 text-center align-self-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="3em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M12.41 148.02l232.94 105.67c6.8 3.09 14.49 3.09 21.29 0l232.94-105.67c16.55-7.51 16.55-32.52 0-40.03L266.65 2.31a25.607 25.607 0 0 0-21.29 0L12.41 107.98c-16.55 7.51-16.55 32.53 0 40.04zm487.18 88.28l-58.09-26.33-161.64 73.27c-7.56 3.43-15.59 5.17-23.86 5.17s-16.29-1.74-23.86-5.17L70.51 209.97l-58.1 26.33c-16.55 7.5-16.55 32.5 0 40l232.94 105.59c6.8 3.08 14.49 3.08 21.29 0L499.59 276.3c16.55-7.5 16.55-32.5 0-40zm0 127.8l-57.87-26.23-161.86 73.37c-7.56 3.43-15.59 5.17-23.86 5.17s-16.29-1.74-23.86-5.17L70.29 337.87 12.41 364.1c-16.55 7.5-16.55 32.5 0 40l232.94 105.59c6.8 3.08 14.49 3.08 21.29 0L499.59 404.1c16.55-7.5 16.55-32.5 0-40z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-eco">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h4 class="title-text mt-0">Total members</h4>
                                    <h3 class="font-weight-semibold mb-1" id="stat-count">1000</h3>
                                </div>
                                <!--end col-->
                                <div class="col-4 text-center align-self-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="3em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-eco">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h4 class="title-text mt-0">Ongoing Pro</h4>
                                    <h3 class="font-weight-semibold mb-1" >3</h3>
                                </div>
                                <!--end col-->
                                <div class="col-4 text-center align-self-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="3em" viewBox="0 0 384 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M0 32C0 14.3 14.3 0 32 0H64 320h32c17.7 0 32 14.3 32 32s-14.3 32-32 32V75c0 42.4-16.9 83.1-46.9 113.1L237.3 256l67.9 67.9c30 30 46.9 70.7 46.9 113.1v11c17.7 0 32 14.3 32 32s-14.3 32-32 32H320 64 32c-17.7 0-32-14.3-32-32s14.3-32 32-32V437c0-42.4 16.9-83.1 46.9-113.1L146.7 256 78.9 188.1C48.9 158.1 32 117.4 32 75V64C14.3 64 0 49.7 0 32zM96 64V75c0 25.5 10.1 49.9 28.1 67.9L192 210.7l67.9-67.9c18-18 28.1-42.4 28.1-67.9V64H96zm0 384H288V437c0-25.5-10.1-49.9-28.1-67.9L192 301.3l-67.9 67.9c-18 18-28.1 42.4-28.1 67.9v11z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <div class="card card-eco">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <h4 class="title-text mt-0">Complete</h4>
                                    <h3 class="font-weight-semibold mb-1">10</h3>
                                </div>
                                <!--end col-->
                                <div class="col-4 text-center align-self-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="3em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div id="menu-content-3" class="main-content hide">
            <h1>Content 3</h1>
        </div>


        <!-- ======= flyer  added area ===== -->
        <div id="menu-content-4" class="main-content hide">

            <div class="d-flex pt-2 mt-3 mb-2 ">
                <button class="btn fw-bold d-flex ms-2 shadow-sm"
                        style=" color: var(--lighter-secondary) !important; background-color: var(--primary);"
                        data-bs-toggle="modal" data-bs-target="#exampleModal2">
                    <ion-icon class="my-auto" name="add-outline"
                              style="font-size: 1.4rem;"></ion-icon>
                    <div class="my-auto ms-1 me-auto">New Flyer</div>
                </button>
            </div>
            <!-- ======= flyer  added area  hidden part===== -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header py-2 px-2"
                             style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                            <!--                                <h5 class="modal-title" id="exampleModalLabel">Project details</h5>-->
                            <div class="ms-2 my-auto fs-4 fw-bold">
                                Create Flyer
                            </div>
                            <!--                                <button type="button" class="btn-close" data-bs-dismiss="modal"-->
                            <!--                                        aria-label="Close"></button>-->
                        </div>
                        <form action="process/clubownerdashboard/addFlyer.php" method="POST"
                              enctype="multipart/form-data">
                            <div class="modal-body" style="background-color: var(--lighter-secondary);">
                                <input type="hidden" name="club_id"
                                       value="<?= $clubid ?>">


                                <div class="fw-bold " style="color: var(--primary);">Topic</div>

                                <input class="form-control text-center" type="text"
                                       name="topic" id="topic"
                                       placeholder="Topic" required/>


                                <div class="fw-bold " style="color: var(--primary);">Caption</div>
                                <div>

                                <textarea  class="form-control"   cols="25"
                                           rows="2"
                                       name="caption" id="caption"
                                           placeholder="caption" required> </textarea>
                                </div>


                                <div class="fw-bold my-2" style="color: var(--primary);">Flyer Image</div>
                                <input type="file" class="form-control custom-file-input" id="fl_image" name="fl_image"
                                       required/>
                                <div class="d-flex mx-auto my-3">
                                    <span class="d-flex">
                                    <div class="fw-bold mx-2" style="color: var(--primary);">Start Date</div>
                                    <input class="form-control w-50" type="date" name="start_date" required>
                                        <div class="fw-bold mx-2" style="color: var(--primary);">Start Time</div>
                                    <input class="form-control w-50" type="time" name="start_time" required>
                                    </span>
                                </div>

                                <div class="d-flex mx-auto my-3">
                                    <span class="d-flex">
                                <div class="fw-bold mx-2" style="color: var(--primary);">End Date</div>
                                <input class="form-control w-50" type="date" name="end_date" required>
                                        <div class="fw-bold mx-2" style="color: var(--primary);">End Time</div>
                                    <input class="form-control w-50" type="time" name="end_time" required>
                                    </span>
                                </div>


                                <div class="fw-bold my-2" style="color: var(--primary);">Link</div>
                                <input type="url" name="url" id="url"
                                       placeholder="https://example.com" pattern="https://.*" size="30" required/>


                                <div class="mt-2 text-center" id="add-flyer-error"
                                     style="color: var(--accent-color3)">
                                </div>

                            </div>
                            <div class="modal-footer" style="background-color: var(--primary);">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                </button>
                                <button
                                        onclick=""
                                        class="btn fw-bold"
                                        type="submit" name="submit"
                                        style="background-color: var(--secondary); color: var(--primary);">
                                    ADD
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <hr/>

            <!--===view flyer part-->


            <div class="ml-1    row-cols-1 row-cols-md-3 row-cols-xl-4 " >

                <?php
                $flyerno = 1;

                foreach ($publicFlyers

                as $publicFlyer){

                $publicFlyerObj =
                    new PublicFlyer($publicFlyer->getFlyerID(), null, null, null, null,
                    null, null, null,null);
                $publicFlyerObj->loadFlyerFromFlyerID($con);

                ?>
                    <!--===view flyer part  card-->

                    <div class="card" style="width: 18rem">

                        <div class="card-header fw-bold"  style=" color: var(--lighter-secondary) !important; background-color: var(--primary);"><?= $publicFlyerObj->getFlyerTopic() ?></div>
                        <img class="card-img-top" src="assets/images/flyer_img/<?= $publicFlyerObj->getFlyerImg() ?>" alt="Card image cap" />
                        <!----------------- card  body ------------------->
                        <div class="card-body">
                            <h5 class="card-title"><?= $publicFlyerObj->getCaption()?></h5>
                        </div>
                        <!----------------- card  footer ------------------->
                        <div class="card-footer">
                            <!----------------- edit button ------------------->
                            <button type="button" class="btn " data-bs-toggle="modal" data-bs-target="#editflyer<?= $flyerno?>">
                                <ion-icon name="create-outline" size="large"></ion-icon>
                            </button>

                            <!----------------- Modal for flyer ------------------>
                            <div class="modal fade" id="editflyer<?= $flyerno?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header" style=" color: var(--lighter-secondary) !important; background-color: var(--primary);">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Flyer  <?= $flyerno?></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="process/clubownerdashboard/editFlyer.php">
                                                <input type="hidden" name="menuNo" value="4">
                                                <input type="hidden" name="flyerId" value="<?= $publicFlyerObj->getFlyerID()?>">

                                                <div class="container">
                                                    <div class="row py-1">
                                                        <input type="text" name="flyerUpdateTopic" class="form-control text-center"  placeholder="<?= $publicFlyerObj->getFlyerTopic()?>">
                                                    </div>
                                                    <div class="row py-1">
                                                        <input type="text" name="flyerUpdateCaption" class="form-control text-center" rows="2" placeholder="<?= $publicFlyerObj->getCaption()?>">
                                                    </div>
                                                    <div class="row py-1">
                                                        <input type="text" name="flyerUpdateLink" class="form-control text-center"  placeholder="<?= $publicFlyerObj->getLink()?>">
                                                    </div>
                                                    <div class="row py-1">
                                                        <input type="datetime-local" name="flyerUpdateStartdate" class="form-control"  placeholder="<?= $publicFlyerObj->getStartDate()?>">
                                                    </div>
                                                    <div class="row py-1">
                                                        <input type="datetime-local" name="flyerUpdateSEnddate" class="form-control"  placeholder="<?= $publicFlyerObj->getEndDate()?>">
                                                    </div>
                                                    <div class="row">
                                                        <?= $publicFlyerObj->getEndDate()?>
                                                    </div>


                                                </div>





                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn" style="color: var(--accent-color2)!important;background-color: var(--primary);">Save changes</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            </div>
                    </div>






            <?php
                    $flyerno++;
            }
            ?>

            </div>




    </div>
    <div id="menu-content-5" class="main-content hide">

        <div class="text-center d-flex">
            <?php
            if ($loadClubData) {
                ?>
                <!-- ======= project image area ===== -->
                <div class="d-flex flex-column mx-auto my-3">
                    <img class="rounded-circle img-thumbnail shadow-sm"
                         style="width: 150px; height: 150px; object-fit: cover;"
                         src="assets/images/profile_img/club/<?= $club->getProfileImage() ?>"
                         alt="">
                    <form action="process/clubownerdashboard/saveProfileImage.php" method="post"
                          enctype="multipart/form-data">
                        <div class="btn fw-bold d-flex mx-4 mt-2 shadow-sm" type="button"
                             onclick="fileUploadBtn()"
                             style="color: var(--lighter-secondary) !important; background-color: var(--primary);">
                            <ion-icon class="my-auto ms-auto me-1" style="font-size: 1.4rem;"
                                      name="cloud-upload-outline"></ion-icon>
                            <div class="my-auto ms-1 me-auto">Upload</div>
                            <input type="file" class="form-control d-none" name="image_upload"
                                   id="image_upload" onchange="saveImgSubmit()"/>

                        </div>
                        <!--======= hidden ==========-->
                        <input type="hidden" name="menuNo" value="5">
                        <input type="hidden" name="club_id"
                               value="<?= $club->getUserId() ?>">
                        <input class="d-none" type="submit" name="image_save_submit"
                               id="image_save_submit"/>
                    </form>
                </div>

            <?php }
            ?>
        </div>

        <div class="card shadow-sm mb-3 mx-4">
            <div class="card-header py-3">
                <p class="m-0 fw-bold" style="color: var(--darker-primary); font-size: 1.3rem;">Club Settings</p>
            </div>
            <div class="card-body">
                <form action="process/clubownerdashboard/editClubDetails.php" method="post">
                    <?php

                    if ($loadClubData){
                    ?>

                    <div class="row" style="color: var(--primary);">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="club_name">
                                    <strong>Club Name</strong>
                                </label>
                                <input id="club_name" class="form-control" type="text"
                                       value="<?= $club->getClubName() ?>" name="club_name"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="contact_no">
                                    <strong>Contact number</strong>
                                </label>
                                <input id="contact_no" class="form-control" type="text"
                                       value="<?= $club->getContactNo() ?>" name="contact_no"/>
                            </div>
                        </div>

                    </div>
                    <div class="row px-2" style="color: var(--primary);">
                        <div class="fw-bold">Description</div>
                        <textarea class="form-control" name="desc" id="" cols="25"
                                  rows="7"><?= $club->getClubDescription() ?></textarea>
                    </div>
                    <!--======= hidden ==========-->
                    <input type="hidden" name="menuNo" value="5">
                    <input type="hidden" name="club_id"
                           value="<?= $club->getUserId() ?>">
                    <button class="btn fw-bold d-flex mt-2 ms-auto me-0"
                            style="width: 127px; color: var(--lighter-secondary) !important; background-color: var(--primary);"
                            type="submit" name="submit">
                        <ion-icon class="my-auto ms-auto me-1" style="font-size: 1.4rem;"
                                  name="save-outline"></ion-icon>
                        <div class="my-auto ms-1 me-auto">Save</div>

                    </button>
                </form>
                <?php
                } else {
                    echo "Club data not found for the given user ID.";
                }
                ?>
            </div>
        </div>


    </div>

    </div>

    <!--=== pre loader ===-->
    <?php include_once "content/preloader.php" ?>
    <!--=== Preloader Script file ===-->
    <?php include_once "content/commonJS.php" ?>

    <script>
        function createNewProject() {
            let projectName = document.getElementById("add-project-name-input").value;
            let chairID = document.getElementById("add-project-username-input").value;

            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'process/clubownerdashboard/addproject.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    let response = JSON.parse(xhr.responseText);

                    // Access the original username and the result from the response object
                    let message = response.message;
                    let success = response.success;

                    if (success) {
                        window.location.href = 'clubowner-dashboard.php';
                    } else {
                        document.getElementById("add-project-error").innerText = message;
                    }


                }
            };

            // Send the username to the PHP script
            xhr.send('project_name=' + encodeURIComponent(projectName) + '&chair_username=' + encodeURIComponent(chairID) +
                '&club_id=' + encodeURIComponent(<?=$clubid ?>));

        }
    </script>
    <!--    =============== execute upload image button ==========-->
    <script>
        function fileUploadBtn() {
            document.getElementById('image_upload').click();

        }

        function saveImgSubmit() {
            document.getElementById('image_save_submit').click();
        }
    </script>

    <!-- ======script button===== --->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const statusToggles = document.querySelectorAll(".status-toggle");


            statusToggles.forEach(function (statusToggle) {
                statusToggle.addEventListener("change", function () {
                    const isChecked = statusToggle.checked;
                    const projectId = statusToggle.getAttribute("project-id");
                    updateStatus(isChecked, projectId);
                });
            });

            function updateStatus(status, projectId) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "process/clubownerdashboard/updateProjectStatus.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = xhr.responseText;
                        // Handle the response if needed
                    }
                };
                xhr.send("status=" + status + "&projectId=" + projectId);
                console.log(status);
                console.log(projectId);
            }
        });
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


    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <!-- ========= Ionicons Scripts ===== -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- ====== Script files ===== -->
    <script src="assets/js/clubownerdashboard.js"></script>

    </body>
    </html>


    <?php
} else {
    header("location: login.php");
}
?>