<?php
session_start();
require_once 'classes/DBConnector.php';
require_once 'classes/Project.php';
require_once 'classes/User.php';

use classes\DBConnector;
use classes\Project;
use classes\Club;


$con = DBConnector::getConnection();

if (isset($_SESSION['user_id'])) {


    $clubid = $_SESSION['user_id'];
    $projects = Project::getProjectListFromClubID($con, $clubid);

    $club = new Club(null, null, null, null);
    $club->setUserId($clubid);
    $club->loadDataFromUserID($con);

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

            <div id="project-details" class="my-2" style="font-weight:bold; font-size: 1.5rem;">
                <span class="d-block w3-text-light-blue"></span>
                <span class="d-block w3-text-cyan"><?= $club->getClubName() ?></span>
            </div>

            <hr>
            <ul class="nav nav-pills flex-column navbar-text mb-auto">
                <li id="menu-1" class="sideBar-btn activate" onclick="showMenuContent(1)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="people-circle-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Projects</span>
                    </a>
                </li>
                <li id="menu-2" class="sideBar-btn" onclick="showMenuContent(2)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="calendar-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Grantt Chart</span>
                    </a>
                </li>
                <li id="menu-3" class="sideBar-btn" onclick="showMenuContent(3)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="walk-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Activitty Plan</span>
                    </a>
                </li>
                <li id="menu-4" class="sideBar-btn" onclick="showMenuContent(4)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="document-text-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">PR Plan</span>
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

        </div>
    </div>
    </div>
    <!-- ============== main content ===================== -->
    <div id="main" style="height: 100vh;">

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


        <div id="menu-content-1" class="main-content show ms-1">
            <div class="d flex flex-column mt-3">
                <div class="d-flex  ">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Create Projects
                    </button>
                </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Project details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form action="process/clubownerdashboard/addproject.php" method="POST"
                                  enctype="multipart/form-data">
                                <div class="modal-body">

                                    <label for="prName" class="form-label h5">Name</label>
                                    <br/>
                                    <input type="text" class="form-control" id="prName" name="projectName" required/>
                                    <br/>


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                                        </button>
                                        <button type="submit" class="btn btn-primary" name="addProject">Add</button>
                                    </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <hr/>


            <div class="row gy-2 row-cols-1 row-cols-md-2 row-cols-xl-3">
                <?php
                $i = 1;


                foreach ($projects as $project) {
                    ?>

                    <div class="col">
                        <form action="process/clubownerdashboard/getIntoProject.php" method="post">
                            <div class="rounded border">
                                <div class="card d-block shadow-sm h-80">
                                    <div class="card-header p-3 text-white" style="background-color: var(--primary)">
                                        <h5 class="card-title fw-bold"
                                            style="font-size: 1.5rem"><?= $project->getProjectName() ?></h5>
                                        <!--==== hidden ======-->
                                        <input type="hidden" name="project_id" value="<?= $project->getProjectID() ?>">

                                        <button type="submit" name="submit" class="btn my-2 btn-outline-light">More
                                        </button>
                                    </div>
                                    <div class="card-body py-4 d-flex">
                                        <div class="toggle-button-cover">
                                            <div class="button-cover">
                                                <div class="button shadow-sm r" id="button-3">
                                                    <input type="checkbox" class="checkbox" checked/>
                                                    <div class="knobs"></div>
                                                    <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="">
                                            <img class="img-thumbnail shadow-sm"
                                                 style="width: 150px; height: 150px;"
                                                 src="assets/images/profile_img/project/<?= $project->getProfileImage() ?>"
                                                 alt="">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                    $i++;
                } ?>
            </div>
        </div>
    </div>
    <div id="menu-content-2" class="main-content hide">
        <h1>Content 2</h1>
    </div>
    <div id="menu-content-3" class="main-content hide">
        <h1>Content 3</h1>
    </div>
    <div id="menu-content-4" class="main-content hide">
        <h1>Content 4</h1>
    </div>
    <div id="menu-content-5" class="main-content hide">

        <div class="card-body text-center shadow">
            <img class="rounded-circle mb-3 mt-4" src="" width="160" height="160"/>
            <div class="mb-3">
                <button class="btn btn-primary btn-sm" type="button">Change Photo</button>
            </div>
        </div>

        <div class="card shadow mb-3">
            <div class="card-header py-3">
                <p class="text-primary m-0 fw-bold">Club Settings</p>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="username">
                                    <strong>Username</strong>
                                </label>
                                <input id="username" class="form-control" type="text" placeholder="user.name"
                                       name="username"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="email">
                                    <strong>Email Address</strong>
                                </label>
                                <input id="email" class="form-control" type="email" placeholder="clubId@.com"
                                       name="email"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="first_name">
                                    <strong>club Name</strong>
                                </label>
                                <input id="first_name" class="form-control" type="text" placeholder="IEEE"
                                       name="first_name"/>
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label class="form-label" for="first_name">
                                    <strong>Contact number</strong>
                                </label>
                                <input id="first_name" class="form-control" type="text" placeholder="0123456789"
                                       name="first_name"/>
                            </div>
                        </div>

                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary btn-sm" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>


    </div>

    </div>

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