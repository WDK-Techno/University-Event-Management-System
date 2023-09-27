<?php
session_start();
require_once "classes/DBConnector.php";
require_once "classes/Project.php";
require_once "classes/User.php";
require_once "classes/TeamCategory.php";
require_once "classes/TeamMember.php";
require_once "classes/Event.php";


use classes\Event;
use classes\Project;
use classes\DBConnector;
use classes\Club;
use classes\Undergraduate;
use classes\TeamCategory;
use classes\TeamMember;


if (!isset($_SESSION['project_id'])) {
    header("location: clubowner-dashboard.php");
}
$projectIDFromSession = $_SESSION['project_id'];

$loggedUserID = $_SESSION['user_id'];
$loggedUserRole = $_SESSION['role'];
$loggedUserImg = $_SESSION['profile_img'];
if ($loggedUserRole == "ug") {
    $loggedUserImg = "ug/" . $loggedUserImg;
}
if ($loggedUserRole == "club") {
    $loggedUserImg = "club/" . $loggedUserImg;
}

$con = DBConnector::getConnection();

//Load Project Details to object
$project = new Project($projectIDFromSession, null, null, null, null, null, null);

if (!$project->loadDataFromProjectID($con)) {
    die("Cannot Load From Database");
} else {

    //Get Club Details
    $club = new Club(null, null, null, null);
    $club->setUserId($project->getClubID());
    $club->loadDataFromUserID($con);

    //Get Project Chair Details
    $projectChair = new Undergraduate(null, null, null, null, null, null);
    $projectChair->setUserId($project->getProjectChairID());
    $projectChair->loadDataFromUserID($con);

    //Get Team Category List
    $teamCategories = TeamCategory::getTeamCategoeryListFromProjectID($con, $project->getProjectID());

    //Get Events List
    $events = Event::getEventListFromProjectID($con, $project->getProjectID());

    $teamMembers = TeamMember::getMemberListFromProjectID($con, $project->getProjectID());

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $selected_menuNo = 7;
        if (isset($_GET['tab'])) {
            $selected_menuNo = $_GET['tab'];
        }

//        ====== change project chair GET ======
        $errorMessage_settings = "";
        if (isset($_GET['changeChairErr'])) {
            $error_changeChair = $_GET['changeChairErr'];

            if ($error_changeChair == 1) {
                $errorMessage_settings = "Invalid Email";
            }
            if ($error_changeChair == 2) {
                $errorMessage_settings = "Email Cannot Be Empty";
            }
            if ($error_changeChair == 3) {
                $errorMessage_settings = "Already Added";
            }
        }
        if (isset($_GET['imgUploadErr'])) {
            $error_imgUpload = $_GET['imgUploadErr'];

            if ($error_imgUpload == 1) {
                $errorMessage_settings = "Database Error";
            }
            if ($error_imgUpload == 2) {
                $errorMessage_settings = "Error in Moving File";
            }
            if ($error_imgUpload == 3) {
                $errorMessage_settings = "File Size larger than 10mb";
            }
            if ($error_imgUpload == 4) {
                $errorMessage_settings = "Error in File Uploading";
            }
            if ($error_imgUpload == 5) {
                $errorMessage_settings = "Invalid file format";
            }
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en" xmlns="http://www.w3.org/1999/html">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <!-- ====== CSS Files ==== -->
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="assets/css/projectdashboard.css">
        <link rel="stylesheet" href="assets/css/event.css">

        <!-- ===== Boostrap CSS ==== -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
              crossorigin="anonymous">


    </head>

    <body>

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
                <span class="d-block w3-text-light-blue"><?= $project->getProjectName() ?></span>
                <span class="d-block w3-text-cyan"><?= $club->getClubName() ?></span>
            </div>

            <hr>
            <ul class="nav nav-pills flex-column navbar-text mb-auto">
                <li id="menu-1" class="sideBar-btn" onclick="showMenuContent(1)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="desktop-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Project Details</span>
                    </a>
                </li>
                <li id="menu-2" class="sideBar-btn" onclick="showMenuContent(2)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="people-circle-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Team Members</span>
                    </a>
                </li>
                <li id="menu-3" class="sideBar-btn" onclick="showMenuContent(3)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="calendar-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Grantt Chart</span>
                    </a>
                </li>
                <li id="menu-4" class="sideBar-btn" onclick="showMenuContent(4)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="pulse-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Activitty Plan</span>
                    </a>
                </li>
                <li id="menu-5" class="sideBar-btn" onclick="showMenuContent(5)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="megaphone-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">PR Plan</span>
                    </a>
                </li>
                <li id="menu-6" class="sideBar-btn" onclick="showMenuContent(6)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="rocket-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Events</span>
                    </a>
                </li>
                <li id="menu-7" class="sideBar-btn" onclick="showMenuContent(7)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="settings-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Settings</span>
                    </a>
                </li>
            </ul>
            <hr>
            <!--            <div id="user-name">-->
            <!--                <div class="d-flex justify-content-start">-->
            <!--                    <ion-icon name="person-circle-outline" class="d-block my-auto w3-text-lime"-->
            <!--                              style="font-size:2.8rem;"></ion-icon>-->
            <!--                    <span class="ms-2 w3-text-light-green">-->
            <!--                        <strong class="d-block">Kavindra</strong>-->
            <!--                        <strong class="d-block">Weerasinghe</strong>-->
            <!--                    </span>-->
            <!--                </div>-->
            <!--            </div>-->
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
                <div id="project-name" class="ms-0 me-auto mx-sm-auto"><?= $project->getProjectName() ?></div>
                <div class="d-flex" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li> -->
                    </ul>

                    <div class="btn-group ms-auto me-0">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle"
                                 style="width: 40px; height: 40px; object-fit: cover;"
                                 src="assets/images/profile_img/<?= $loggedUserImg ?>"
                                 alt="">
                        </a>
                        <ul class="dropdown-menu shadow dropdown-menu-end">
                            <!-- <li class="dropdown-item d-flex justify-content-start px-4"><ion-icon name="person-outline" style="font-size: 1.2rem;" class="me-2"></ion-icon><span>Profile</span></li>
                            <li class="dropdown-item d-flex justify-content-start px-4"><ion-icon name="arrow-undo-outline" style="font-size: 1.2rem;" class="me-2"></ion-icon><span>Userboard</span></li> -->
                            <form action="process/logout.php" method="post">
                                <button class="dropdown-item d-flex justify-content-start px-4"
                                        type="submit" name="submit3"><span>Userboard</span>
                                    <ion-icon
                                            name="arrow-undo-outline" class="ms-auto"
                                            style="font-size: 1.2rem;"></ion-icon>
                                </button>
                            </form>
                            <li class="dropdown-item d-flex justify-content-start px-4"><span>Profile</span>
                                <ion-icon
                                        name="person-outline" class="ms-auto" style="font-size: 1.2rem;"></ion-icon>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <form action="process/logout.php" method="post">
                                <button class="dropdown-item d-flex justify-content-start px-4" type="submit"
                                        name="submit2">
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


        <div id="menu-content-1" class="main-content w-100 h-100 hide">
            <h1>Content 1</h1>
        </div>
        <!--======== Content 2 - Team Members ======-->
        <div id="menu-content-2" class="main-content hide">

            <div class="container-fluid">
                <div class="row d-flex">
                    <div class="col-11 mx-auto">

                        <!-- ======= add member button ======== -->
                        <div class="d-flex mt-3 mb-2">
                            <div class="btn fw-bold my-auto me-0 ms-auto d-flex"
                                 style="color: var(--lighter-secondary) !important; background-color: var(--primary);"
                                 type="button" data-bs-toggle="modal"
                                 data-bs-target="#add-new-team-member">
                                <ion-icon class="my-auto" name="add-outline"></ion-icon>
                                <div class="my-auto">Member</div>
                            </div>
                        </div>

                        <!-- ========= add member button model ========== -->
                        <div class="modal fade"
                             id="add-new-team-member"
                             tabindex="-1"
                             role="dialog"
                             aria-labelledby="exampleModalCenterTitle"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"
                                 role="document">
                                <div class="modal-content">
                                    <!--=== form =====-->
                                    <form>
                                        <div class="modal-header py-2 px-2"
                                             style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                            <div class="d-flex flex-row w-100 justify-content-between">

                                                <div class="ms-2 my-auto fs-4 fw-bold">
                                                    Team Member
                                                </div>

                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                     style="font-size: 1.3rem; color: var(--accent-color2);">
                                                    New
                                                </div>
                                            </div>

                                            <!--======= hidden ==========-->
                                            <input type="hidden" name="menuNo" value="2">
                                        </div>

                                        <div class="modal-body"
                                             style="background-color: var(--lighter-secondary);">
                                            <!-- ====== input username ====== -->
                                            <div class="d-flex px-5">
                                                <input class="form-control text-center" type="email"
                                                       name="username" id="add-member-username-input"
                                                       placeholder="Email" required/>
                                            </div>
                                            <!-- ===== select team ======= -->
                                            <div class="d-flex mt-2 px-5">
                                                <select id="add-member-team-select" class="form-select ms-auto me-0"
                                                        style="width: 50%;"
                                                        name="project_team_id" id="" required>
                                                    <option class="text-center" value="" selected>-- Select Team --
                                                    </option>
                                                    <?php
                                                    foreach ($teamCategories as $teamCategory) {
                                                        ?>
                                                        <option value="<?= $teamCategory->getCategoryID() ?>"><?= $teamCategory->getCategoryName() ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mt-2 text-center" id="add-member-team-error"
                                                 style="color: var(--accent-color3)"></div>

                                        </div>
                                        <div class="modal-footer" style="background-color: var(--primary);">
                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="button"
                                                    onclick="addMemberToProject()"
                                                    class="btn fw-bold"
                                                    style="background-color: var(--secondary); color: var(--primary);">
                                                ADD
                                            </button>

                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>


                        <!-- ========== member table ============ -->
                        <div class="card" style="">
                            <div class="card-header team-member-table pb-0"
                                 style="background-color: var(--darker-primary); color: var(--lighter-secondary);">

                                <div class="row p-0 fw-bold">
                                    <div class="col-1"></div>
                                    <div class="col-3 text-center py-2 rounded-top-3"
                                         style="background-color: var(--primary);">Name
                                    </div>
                                    <div class="col-3 text-center py-2 rounded-top-3"
                                         style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                        Email
                                    </div>
                                    <div class="col-2 text-center py-2 rounded-top-3"
                                         style="background-color: var(--primary);">Contact No
                                    </div>
                                    <div class="col-2 text-center py-2 rounded-top-3"
                                         style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                        Team
                                    </div>
                                    <div class="col-1">

                                    </div>
                                </div>

                            </div>

                            <div class="card-body pt-0 bg-dark-subtle scrollable-div Flipped"
                                 style="background-color: var(--secondary);">
                                <div class="container p-0 scrollable-div-inside">

                                    <?php
                                    $teamMemberNo = 1;
                                    foreach ($teamMembers as $teamMember) {

                                        $projectMember = new Undergraduate(null, null, null, null, null, null);
                                        $projectMember->setUserId($teamMember->getUgID());
                                        $projectMember->loadDataFromUserID($con);

                                        $projectMemberTeam = new TeamCategory($teamMember->getCategoryID(), null, null, null);
                                        $projectMemberTeam->loadDataByTeamID($con);

                                        ?>
                                        <div class="row mb-2 shadow-sm set-border" style="height: 50px;">
                                            <div class="col-1 d-flex tabel-column-type-2">
                                                <div class="my-auto">
                                                    <img class="rounded-circle"
                                                         style="width: 40px; height: 40px; object-fit: cover;"
                                                         src="assets/images/profile_img/ug/<?= $projectMember->getProfileImg() ?>"
                                                         alt="">
                                                </div>
                                            </div>
                                            <div class="col-3 tabel-column-type-1 d-flex">
                                                <div class="my-auto"><?= $projectMember->getFirstName() ?> <?= $projectMember->getLastName() ?></div>
                                            </div>
                                            <div class="col-3 d-flex tabel-column-type-2">
                                                <div class="my-auto mx-auto"><?= $projectMember->getUsername() ?></div>
                                            </div>
                                            <div class="col-2 d-flex tabel-column-type-1">
                                                <div class="my-auto mx-auto"><?= $projectMember->getContactNo() ?></div>
                                            </div>
                                            <div class="col-2 d-flex tabel-column-type-2">
                                                <div class="my-auto mx-auto"><?= $projectMemberTeam->getCategoryName() ?></div>
                                            </div>
                                            <div class="col-1 tabel-column-type-1 d-flex">
                                                <div class="d-flex my-auto mx-auto" style="font-size: 1.5rem;">

                                                    <!--========== Delete team Member button =========-->
                                                    <ion-icon class="my-auto" type="button"
                                                              data-bs-toggle="modal"
                                                              data-bs-target="#delete-project-member-<?= $teamMemberNo ?>"
                                                              name="trash-outline"></ion-icon>
                                                </div>

                                                <!-- =========== Delete team Member button model =========== -->
                                                <div class="modal fade"
                                                     id="delete-project-member-<?= $teamMemberNo ?>"
                                                     tabindex="-1"
                                                     role="dialog"
                                                     aria-labelledby="exampleModalCenterTitle"
                                                     aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered"
                                                         role="document">
                                                        <div class="modal-content">
                                                            <!--=== form =====-->
                                                            <form action="process/projectdashboard/deleteTeamMember.php"
                                                                  method="post">
                                                                <div class="modal-header py-2 px-2"
                                                                     style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                                    <div class="d-flex flex-row w-100 justify-content-between">

                                                                        <div class="ms-2 my-auto fs-4 fw-bold">Team
                                                                            Member
                                                                        </div>

                                                                        <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                                        <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                                        <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                             style="font-size: 1.3rem; color: var(--accent-color3);">
                                                                            Delete
                                                                        </div>
                                                                    </div>

                                                                    <!--======= hidden ==========-->
                                                                    <input type="hidden" name="menuNo"
                                                                           value="2">
                                                                    <input type="hidden" name="ug_id"
                                                                           value="<?= $projectMember->getUserId() ?>">
                                                                    <input type="hidden" name="cat_id"
                                                                           value="<?= $projectMemberTeam->getCategoryID() ?>">
                                                                </div>

                                                                <div class="modal-body"
                                                                     style="background-color: var(--lighter-secondary);">
                                                                    <div class="d-flex flex-column fw-normal fs-5">
                                                                        <div class="fw-bold">
                                                                            Do you want to Delete this Team Member ?
                                                                        </div>
                                                                        <div class="fw-bold"
                                                                             style="color: var(--primary); font-size: 1.1rem;">
                                                                            <?= $projectMember->getFirstName() ?> <?= $projectMember->getLastName() ?>
                                                                        </div>
                                                                        <div class="fw-bold"
                                                                             style="color: var(--accent-color); font-size: 1.1rem;">
                                                                            <?= $projectMemberTeam->getCategoryName() ?>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer"
                                                                     style="background-color: var(--primary);">
                                                                    <button type="button"
                                                                            class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                    <button type="submit"
                                                                            name="submit"
                                                                            class="btn fw-bold"
                                                                            style="background-color: var(--accent-color3); color: var(--primary);">
                                                                        Delete
                                                                    </button>

                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                        $teamMemberNo++;
                                    }
                                    ?>

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
        <div id="menu-content-4" class="main-content hide">
            <h1>Content 4</h1>
        </div>
        <div id="menu-content-5" class="main-content hide">
            <h1>Content 5</h1>
            <div id="menu-content-2" class="main-content hide">

                <div class="container-fluid">
                    <div class="row d-flex">
                        <div class="col-11 mx-auto">

                            <!-- ======= add member button ======== -->
                            <div class="d-flex mt-3 mb-2">
                                <div class="btn fw-bold my-auto me-0 ms-auto d-flex"
                                     style="color: var(--lighter-secondary) !important; background-color: var(--primary);"
                                     type="button" data-bs-toggle="modal"
                                     data-bs-target="#add-new-team-member">
                                    <ion-icon class="my-auto" name="add-outline"></ion-icon>
                                    <div class="my-auto">Member</div>
                                </div>
                            </div>

                            <!-- ========= add member button model ========== -->
                            <div class="modal fade"
                                 id="add-new-team-member"
                                 tabindex="-1"
                                 role="dialog"
                                 aria-labelledby="exampleModalCenterTitle"
                                 aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered"
                                     role="document">
                                    <div class="modal-content">
                                        <!--=== form =====-->
                                        <form>
                                            <div class="modal-header py-2 px-2"
                                                 style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                <div class="d-flex flex-row w-100 justify-content-between">

                                                    <div class="ms-2 my-auto fs-4 fw-bold">
                                                        Team Member
                                                    </div>

                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                    <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                    <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                         style="font-size: 1.3rem; color: var(--accent-color2);">
                                                        New
                                                    </div>
                                                </div>

                                                <!--======= hidden ==========-->
                                                <input type="hidden" name="menuNo" value="2">
                                            </div>

                                            <div class="modal-body"
                                                 style="background-color: var(--lighter-secondary);">
                                                <!-- ====== input username ====== -->
                                                <div class="d-flex px-5">
                                                    <input class="form-control text-center" type="email"
                                                           name="username" id="add-member-username-input"
                                                           placeholder="Email" required/>
                                                </div>
                                                <!-- ===== select team ======= -->
                                                <div class="d-flex mt-2 px-5">
                                                    <select id="add-member-team-select" class="form-select ms-auto me-0"
                                                            style="width: 50%;"
                                                            name="project_team_id" id="" required>
                                                        <option class="text-center" value="" selected>-- Select Team --
                                                        </option>
<!--                                                        --><?php
//                                                        foreach ($teamCategories as $teamCategory) {
//                                                            ?>
<!--                                                            <option value="--><?//= $teamCategory->getCategoryID() ?><!--">--><?//= $teamCategory->getCategoryName() ?><!--</option>-->
<!--                                                            --><?php
                                                        }
//                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mt-2 text-center" id="add-member-team-error"
                                                     style="color: var(--accent-color3)"></div>

                                            </div>
                                            <div class="modal-footer" style="background-color: var(--primary);">
                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Close
                                                </button>
                                                <button type="button"
                                                        onclick="addMemberToProject()"
                                                        class="btn fw-bold"
                                                        style="background-color: var(--secondary); color: var(--primary);">
                                                    ADD
                                                </button>

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>


                            <!-- ========== member table ============ -->
                            <div class="card" style="">
                                <div class="card-header team-member-table pb-0"
                                     style="background-color: var(--darker-primary); color: var(--lighter-secondary);">

                                    <div class="row p-0 fw-bold">
                                        <div class="col-1"></div>
                                        <div class="col-3 text-center py-2 rounded-top-3"
                                             style="background-color: var(--primary);">Name
                                        </div>
                                        <div class="col-3 text-center py-2 rounded-top-3"
                                             style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                            Email
                                        </div>
                                        <div class="col-2 text-center py-2 rounded-top-3"
                                             style="background-color: var(--primary);">Contact No
                                        </div>
                                        <div class="col-2 text-center py-2 rounded-top-3"
                                             style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                            Team
                                        </div>
                                        <div class="col-1">

                                        </div>
                                    </div>

                                </div>

                                <div class="card-body pt-0 bg-dark-subtle scrollable-div Flipped"
                                     style="background-color: var(--secondary);">
                                    <div class="container p-0 scrollable-div-inside">

<!--                                        --><?php
//                                        $teamMemberNo = 1;
//                                        foreach ($teamMembers as $teamMember) {
//
//                                            $projectMember = new Undergraduate(null, null, null, null, null, null);
//                                            $projectMember->setUserId($teamMember->getUgID());
//                                            $projectMember->loadDataFromUserID($con);
//
//                                            $projectMemberTeam = new TeamCategory($teamMember->getCategoryID(), null, null, null);
//                                            $projectMemberTeam->loadDataByTeamID($con);
//
//                                            ?>
                                            <div class="row mb-2 shadow-sm set-border" style="height: 50px;">
                                                <div class="col-1 d-flex tabel-column-type-2">
                                                    <div class="my-auto">
                                                        <img class="rounded-circle"
                                                             style="width: 40px; height: 40px; object-fit: cover;"
<!--                                                             src="assets/images/profile_img/ug/--><?//= $projectMember->getProfileImg() ?><!--"-->
                                                             alt="">
                                                    </div>
                                                </div>
                                                <div class="col-3 tabel-column-type-1 d-flex">
<!--                                                    <div class="my-auto">--><?//= $projectMember->getFirstName() ?><!-- --><?//= $projectMember->getLastName() ?><!--</div>-->
                                                </div>
                                                <div class="col-3 d-flex tabel-column-type-2">
<!--                                                    <div class="my-auto mx-auto">--><?//= $projectMember->getUsername() ?><!--</div>-->
                                                </div>
                                                <div class="col-2 d-flex tabel-column-type-1">
<!--                                                    <div class="my-auto mx-auto">--><?//= $projectMember->getContactNo() ?><!--</div>-->
                                                </div>
                                                <div class="col-2 d-flex tabel-column-type-2">
<!--                                                    <div class="my-auto mx-auto">--><?//= $projectMemberTeam->getCategoryName() ?><!--</div>-->
                                                </div>
                                                <div class="col-1 tabel-column-type-1 d-flex">
                                                    <div class="d-flex my-auto mx-auto" style="font-size: 1.5rem;">

                                                        <!--========== Delete team Member button =========-->
                                                        <ion-icon class="my-auto" type="button"
                                                                  data-bs-toggle="modal"
<!--                                                                  data-bs-target="#delete-project-member---><?//= $teamMemberNo ?><!--"-->
                                                                  name="trash-outline"></ion-icon>
                                                    </div>

                                                    <!-- =========== Delete team Member button model =========== -->
                                                    <div class="modal fade"
<!--                                                         id="delete-project-member---><?//= $teamMemberNo ?><!--"-->
                                                         tabindex="-1"
                                                         role="dialog"
                                                         aria-labelledby="exampleModalCenterTitle"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered"
                                                             role="document">
                                                            <div class="modal-content">
                                                                <!--=== form =====-->
                                                                <form action="process/projectdashboard/deleteTeamMember.php"
                                                                      method="post">
                                                                    <div class="modal-header py-2 px-2"
                                                                         style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                                        <div class="d-flex flex-row w-100 justify-content-between">

                                                                            <div class="ms-2 my-auto fs-4 fw-bold">Team
                                                                                Member
                                                                            </div>

                                                                            <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                                            <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                                            <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                                 style="font-size: 1.3rem; color: var(--accent-color3);">
                                                                                Delete
                                                                            </div>
                                                                        </div>

                                                                        <!--======= hidden ==========-->
                                                                        <input type="hidden" name="menuNo"
                                                                               value="2">
                                                                        <input type="hidden" name="ug_id"
<!--                                                                               value="--><?//= $projectMember->getUserId() ?><!--">-->
                                                                        <input type="hidden" name="cat_id"
<!--                                                                               value="--><?//= $projectMemberTeam->getCategoryID() ?><!--">-->
                                                                    </div>

                                                                    <div class="modal-body"
                                                                         style="background-color: var(--lighter-secondary);">
                                                                        <div class="d-flex flex-column fw-normal fs-5">
                                                                            <div class="fw-bold">
                                                                                Do you want to Delete this Team Member ?
                                                                            </div>
                                                                            <div class="fw-bold"
                                                                                 style="color: var(--primary); font-size: 1.1rem;">
<!--                                                                                --><?//= $projectMember->getFirstName() ?><!-- --><?//= $projectMember->getLastName() ?>
                                                                            </div>
                                                                            <div class="fw-bold"
                                                                                 style="color: var(--accent-color); font-size: 1.1rem;">
<!--                                                                                --><?//= $projectMemberTeam->getCategoryName() ?>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer"
                                                                         style="background-color: var(--primary);">
                                                                        <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">
                                                                            Close
                                                                        </button>
                                                                        <button type="submit"
                                                                                name="submit"
                                                                                class="btn fw-bold"
                                                                                style="background-color: var(--accent-color3); color: var(--primary);">
                                                                            Delete
                                                                        </button>

                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            $teamMemberNo++
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="menu-content-6" class="main-content hide">
            <div class="col-12 p-5 d-flex justify-content-center ">
                <div class="col-md-12 mx-auto">
                    <div class=" d-flex w-100">

                        <div class="btn btn-success fw-bold my-auto ms-auto me-2 d-flex"
                             type="button" data-bs-toggle="modal"
                             data-bs-target="#add-new-event">
                            <ion-icon class="my-auto" name="add-outline"></ion-icon>
                            <div class="my-auto d-flex">New</div>
                        </div>
                        <!-- =========== add new event button model =========== -->
                        <div class="modal fade"
                             id="add-new-event"
                             tabindex="-1"
                             role="dialog"
                             aria-labelledby="exampleModalCenterTitle"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"
                                 role="document">
                                <div class="modal-content">
                                    <!--=== form =====-->
                                    <form action="process/projectdashboard/addNewEvent.php" method="post">
                                        <div class="modal-header py-2 px-2"
                                             style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                            <div class="d-flex flex-row w-100 justify-content-between">

                                                <div class="ms-2 my-auto fs-4 fw-bold">
                                                    Event
                                                </div>

                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                     style="font-size: 1.3rem; color: var(--accent-color2);">
                                                    New
                                                </div>
                                            </div>

                                            <!--======= hidden ==========-->
                                            <input type="hidden" name="menuNo" value="6">
                                            <input type="hidden" name="project_id"
                                                   value="<?= $project->getProjectID() ?>">
                                        </div>

                                        <div class="modal-body"
                                             style="background-color: var(--lighter-secondary);">
                                            <div class=" p-2">
                                                <input class="form-control text-center" type="text" required
                                                       name="name" placeholder="Event Name"/><br>
                                                <input class="form-control text-center" type="text" required
                                                       name="description" placeholder="Description"/><br>
                                                <input class="form-control text-center" type="datetime-local" required
                                                       name="event_start_date" placeholder="Event Start Date"/><br>
                                                <input class="form-control text-center" type="datetime-local" required
                                                       name="event_end_date" placeholder="Event End Date"/><br>
                                            </div>
                                        </div>
                                        <div class="modal-footer" style="background-color: var(--primary);">
                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit"
                                                    name="submit"
                                                    class="btn fw-bold"
                                                    style="background-color: var(--secondary); color: var(--primary);">
                                                ADD
                                            </button>

                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- ========== Event list body =========== -->
                    <div class="position-absolute" style="overflow-y: auto;">
                        <div class="row col-md-12 m-1">
                            <?php
                            $eventNo = 1;
                            foreach ($events as $event) {
                                $event = new Event($event->getEventId(), null, null, null,
                                    null, null, null);
                                $event->loadDataFromeventId($con);
                                ?>

                                <div class="col-md-4 shadow-sm p-0 m-2 fw-normal card card1-margin" style="width: 30%">
                                    <div class="card1-header no-border">
                                        <h5 class="card1-title"><?= $event->getEventName() ?></h5>
                                    </div>
                                    <div class="card1-body pt-0">
                                        <div class="widget-49">
                                            <div class="widget-49-title-wrapper">
                                                <div class="widget-49-date-primary">
                                                    <span class="widget-49-date-day"><?=
                                                        date('d', strtotime($event->getEventStartDate()));
                                                        ?></span></span>
                                                    <span class="widget-49-date-month"><?=
                                                        date('M', strtotime($event->getEventStartDate()));
                                                        ?></span>
                                                </div>
                                                <div class="widget-49-meeting-info">
                                                    <span class="widget-49-pro-title"><?= $event->getEventName() ?></span>
                                                    <span class="widget-49-meeting-time"><?=
                                                        date('g:i A, l', strtotime($event->getEventStartDate())) . ' to ' . date('g:i A, l', strtotime($event->getEventEndDate())); ?></span>
                                                </div>
                                            </div>
                                            <ol class="widget-49-meeting-points">
                                                <li class="widget-49-meeting-item">
                                                    <span><?= $event->geteventDescription() ?></span></li>
                                                <li class="widget-49-meeting-item">
                                                    <span><?= $event->getEventStartDate() ?></span></li>
                                                <li class="widget-49-meeting-item">
                                                    <span><?= $event->getEventEndDate() ?></span></li>
                                            </ol>
                                            <div class="widget-49-meeting-action">
                                                <div class="d-flex justify-content-end mx-auto p-3 card-list-option-buttons"
                                                     style="font-size: 1.7rem;">
                                                    
                                                    <!--========== edit event button =========-->
                                                    <a class="btn btn-sm btn-flash-border-primary" type="button"
                                                              data-bs-toggle="modal"
                                                              data-bs-target="#edit-event<?= $eventNo ?>">Edit</a>

                                                    <!-- =========== edit event button model =========== -->
                                                    <div class="modal fade"
                                                         id="edit-event<?= $eventNo ?>"
                                                         tabindex="-1"
                                                         role="dialog"
                                                         aria-labelledby="exampleModalCenterTitle"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered"
                                                             role="document">
                                                            <div class="modal-content">
                                                                <!--=== form =====-->
                                                                <form action="process/projectdashboard/editEvent.php"
                                                                      method="post">
                                                                    <div class="modal-header py-2 px-2"
                                                                         style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                                        <div class="d-flex flex-row w-100 justify-content-between">

                                                                            <div class="ms-2 my-auto fs-4 fw-bold">
                                                                                Event
                                                                            </div>

                                                                            <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                                            <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                                            <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                                 style="font-size: 1.3rem; color: var(--accent-color2);">
                                                                                Edit
                                                                            </div>
                                                                        </div>

                                                                        <!--======= hidden ==========-->
                                                                        <input type="hidden" name="menuNo"
                                                                               value="6">
                                                                        <input type="hidden" name="event_id"
                                                                               value="<?= $event->getEventId() ?>">
                                                                    </div>

                                                                    <div class="modal-body "
                                                                         style="background-color: var(--lighter-secondary);">
                                                                        <div class="grid px-5 ">
                                                                            <!-- Row 1: Event Name -->
                                                                            <div class="form-group p-2">
                                                                                <input class="form-control text-center"
                                                                                       type="text" name="name"
                                                                                       value="<?= $event->getEventName() ?>"
                                                                                       placeholder="Event Name"/>
                                                                            </div>


                                                                            <!-- Row 2: Event Description -->
                                                                            <div class="form-group p-2">
                                                                                <input class="form-control text-center"
                                                                                       type="text" name="description"
                                                                                       value="<?= $event->getEventDescription() ?>"
                                                                                       placeholder="Event Description"/>
                                                                            </div>


                                                                            <!-- Row 3: Event Date -->
                                                                            <div class="form-group p-2">
                                                                                <input class="form-control text-center"
                                                                                       type="datetime-local"
                                                                                       name="event_start_date"
                                                                                       value="<?= $event->getEventStartDate() ?>"
                                                                                       placeholder="Event Strat Date"/>
                                                                            </div>


                                                                            <div class="form-group p-2">
                                                                                <input class="form-control text-center"
                                                                                       type="datetime-local"
                                                                                       name="event_end_date"
                                                                                       value="<?= $event->getEventEndDate() ?>"
                                                                                       placeholder="Event End Date"/>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer"
                                                                         style="background-color: var(--primary);">
                                                                        <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">
                                                                            Close
                                                                        </button>
                                                                        <button type="submit"
                                                                                name="submit"
                                                                                class="btn fw-bold"
                                                                                style="background-color: var(--secondary); color: var(--primary);">
                                                                            Update
                                                                        </button>

                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!--========== Delete event button =========-->
                                                    <a class="btn btn-sm text-danger btn-flash-border-primary" type="button"
                                                       data-bs-toggle="modal" data-bs-target="#delete-event<?= $eventNo ?>"
                                                              name="trash-outline">DELETE</a>
                                                    <!-- =========== Delete event button model =========== -->
                                                    <div class="modal fade"
                                                         id="delete-event<?= $eventNo ?>"
                                                         tabindex="-1"
                                                         role="dialog"
                                                         aria-labelledby="exampleModalCenterTitle"
                                                         aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered"
                                                             role="document">
                                                            <div class="modal-content">
                                                                <!--=== form =====-->
                                                                <form action="process/projectdashboard/deleteevent.php"
                                                                      method="post">
                                                                    <div class="modal-header py-2 px-2"
                                                                         style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                                        <div class="d-flex flex-row w-100 justify-content-between">

                                                                            <div class="ms-2 my-auto fs-4 fw-bold">
                                                                                <?= $event->getEventName() ?>
                                                                            </div>

                                                                            <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                                            <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                                            <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                                 style="font-size: 1.3rem; color: var(--accent-color3);">
                                                                                Delete
                                                                            </div>
                                                                        </div>

                                                                        <!--======= hidden ==========-->
                                                                        <input type="hidden" name="menuNo"
                                                                               value="6">
                                                                        <input type="hidden" name="event_id"
                                                                               value="<?= $event->getEventId() ?>">
                                                                    </div>

                                                                    <div class="modal-body"
                                                                         style="background-color: var(--lighter-secondary);">
                                                                        <div class="d-flex fw-normal fs-5">
                                                                            Do you want to Delete this Event ?
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer"
                                                                         style="background-color: var(--primary);">
                                                                        <button type="button"
                                                                                class="btn btn-secondary"
                                                                                data-bs-dismiss="modal">
                                                                            Close
                                                                        </button>
                                                                        <button type="submit"
                                                                                name="submit"
                                                                                class="btn fw-bold"
                                                                                style="background-color: var(--accent-color3); color: var(--primary);">
                                                                            Delete
                                                                        </button>

                                                                    </div>
                                                                </form>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php

                                $eventNo++;
                            }

                            ?>


                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div id="menu-content-7" class="main-content w-100 h-100 hide">
            <div class="container-fluid h-100">
                <div class="row h-100">
                    <!-- ====== left side section ========== -->
                    <div class="col-12 col-lg-8">
                        <div class="m-3 border rounded w-100 shadow-sm bg-body-tertiary" style="height: 85%;">
                            <div class="container p-3">
                                <div class="row">
                                    <div class="col-3 d-flex justify-content-center">
                                        <!-- ======= project image area ===== -->
                                        <div class="d-flex flex-column">
                                            <img class="img-thumbnail shadow-sm"
                                                 style="width: 150px; height: 150px;"
                                                 src="assets/images/profile_img/project/<?= $project->getProfileImage() ?>"
                                                 alt="">
                                            <form action="process/projectdashboard/saveProfileImage.php" method="post"
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
                                                <input type="hidden" name="menuNo" value="7">
                                                <input type="hidden" name="project_id"
                                                       value="<?= $project->getProjectID() ?>">
                                                <input class="d-none" type="submit" name="image_save_submit"
                                                       id="image_save_submit"/>
                                            </form>
                                        </div>

                                    </div>
                                    <div class="col-9">
                                        <div class="d-flex mt-2 flex-column">
                                            <form action="process/projectdashboard/editProjectDetails.php"
                                                  method="post">
                                                <div class="fw-bold">Project Name</div>
                                                <div class="d-flex mt-1">

                                                    <input class="shadow-sm text-center form-control"
                                                           name="project_name" type="text"
                                                           value="<?= $project->getProjectName() ?>" required/>
                                                    <!--======= hidden ==========-->
                                                    <input type="hidden" name="menuNo" value="7">
                                                    <input type="hidden" name="project_id"
                                                           value="<?= $project->getProjectID() ?>">
                                                    <button class="btn fw-bold d-flex ms-2 shadow-sm"
                                                            style="width: 127px; color: var(--lighter-secondary) !important; background-color: var(--primary);"
                                                            type="submit" name="submit_project_name">
                                                        <ion-icon class="my-auto ms-auto me-1"
                                                                  style="font-size: 1.4rem;"
                                                                  name="save-outline"></ion-icon>
                                                        <div class="my-auto ms-1 me-auto">Save</div>
                                                    </button>

                                                </div>
                                            </form>
                                            <form action="process/projectdashboard/changeProjectChair.php"
                                                  method="post">
                                                <div class="fw-bold mt-3">Project Chair</div>
                                                <div class="d-flex mt-1">
                                                    <input class="shadow-sm text-center form-control" type="email"
                                                           name="username"
                                                           value="<?= $projectChair->getUsername() ?>" required/>
                                                    <!--======= hidden ==========-->
                                                    <input type="hidden" name="menuNo" value="7">
                                                    <input type="hidden" name="project_id"
                                                           value="<?= $project->getProjectID() ?>">

                                                    <button class="btn fw-bold d-flex ms-2 shadow-sm"
                                                            style="width: 127px; color: var(--lighter-secondary) !important; background-color: var(--primary);"
                                                            type="submit" name="submit">
                                                        <ion-icon class="my-auto ms-auto me-1"
                                                                  style="font-size: 1.4rem;"
                                                                  name="sync-outline"></ion-icon>
                                                        <div class="my-auto ms-1 me-auto">Change</div>
                                                    </button>
                                                </div>
                                            </form>

                                            <div class="mt-2 ms-3 text-center w-75" id="change-projectChair-error"
                                                 style="color: var(--accent-color3)"><?= $errorMessage_settings ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <form action="process/projectdashboard/editProjectDetails.php" method="post">
                                            <div class="border rounded p-3 border-secondary-subtle
                                                    bg-body-secondary shadow-sm d-flex flex-column">
                                                <div class="d-flex w-100 mx-auto">
                                                    <div class="d-flex w-50 ms-5 me-auto">
                                                        <div class="fw-bold w-25 my-auto">Start Date</div>
                                                        <input class="form-control w-50" type="date" name="start_date"
                                                               id=""
                                                               value="<?= $project->getStartDate() ?>" required>
                                                    </div>
                                                    <div class="ms-auto me-5 d-flex w-50">
                                                        <div class="fw-bold w-25 my-auto">End Date</div>
                                                        <input class="form-control w-50" type="date" name="end_date"
                                                               id=""
                                                               value="<?= $project->getEndDate() ?>">
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-4 flex-column">
                                                    <div class="fw-bold">Description</div>
                                                    <textarea class="form-control" name="desc" id="" cols="30"
                                                              rows="9"><?= $project->getDescription() ?></textarea>
                                                </div>
                                                <!--======= hidden ==========-->
                                                <input type="hidden" name="menuNo" value="7">
                                                <input type="hidden" name="project_id"
                                                       value="<?= $project->getProjectID() ?>">

                                                <button class="btn fw-bold d-flex mt-2 ms-auto me-0"
                                                        style="width: 127px; color: var(--lighter-secondary) !important; background-color: var(--primary);"
                                                        type="submit" name="submit_desc">
                                                    <ion-icon class="my-auto ms-auto me-1" style="font-size: 1.4rem;"
                                                              name="save-outline"></ion-icon>
                                                    <div class="my-auto ms-1 me-auto">Save</div>

                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ========== right side section ========== -->
                    <div class="col-12 col-lg-4">
                        <div class="w-100 p-0 pt-3 d-flex container d-flex flex-column">
                            <!-- ======== project Team list ====== -->
                            <div id="project-teams-list" class="card mx-auto col-12 col-md-8 col-lg-12 shadow-sm">
                                <div class="card-header d-flex"
                                     style="background-color: var(--primary); color: var(--lighter-secondary);">
                                    <div class="my-auto fw-bold" style="font-size: 1.3rem;">Project Teams</div>
                                    <div class="btn fw-bold my-auto ms-auto me-2 d-flex"
                                         style="color: var(--accent-color2) !important"
                                         type="button" data-bs-toggle="modal"
                                         data-bs-target="#add-new-project-teams">
                                        <ion-icon class="my-auto" name="add-outline"></ion-icon>
                                        <div class="my-auto">New</div>
                                    </div>

                                    <!-- =========== add new team button model =========== -->
                                    <div class="modal fade"
                                         id="add-new-project-teams"
                                         tabindex="-1"
                                         role="dialog"
                                         aria-labelledby="exampleModalCenterTitle"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"
                                             role="document">
                                            <div class="modal-content">
                                                <!--=== form =====-->
                                                <form action="process/projectdashboard/addNewTeam.php"
                                                      method="post">
                                                    <div class="modal-header py-2 px-2"
                                                         style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                        <div class="d-flex flex-row w-100 justify-content-between">

                                                            <div class="ms-2 my-auto fs-4 fw-bold">
                                                                Project Team
                                                            </div>

                                                            <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                            <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                            <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                 style="font-size: 1.3rem; color: var(--accent-color2);">
                                                                New
                                                            </div>
                                                        </div>

                                                        <!--======= hidden ==========-->
                                                        <input type="hidden" name="menuNo" value="7">
                                                        <input type="hidden" name="project_id"
                                                               value="<?= $project->getProjectID() ?>">
                                                    </div>

                                                    <div class="modal-body"
                                                         style="background-color: var(--lighter-secondary);">
                                                        <div class="d-flex px-5">
                                                            <input class="form-control text-center" type="text"
                                                                   name="team_name" placeholder="Team Name"/>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer"
                                                         style="background-color: var(--primary);">
                                                        <button type="button"
                                                                class="btn btn-secondary"
                                                                data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit"
                                                                name="submit"
                                                                class="btn fw-bold"
                                                                style="background-color: var(--secondary); color: var(--primary);">
                                                            ADD
                                                        </button>

                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!-- ========== project list body =========== -->
                                <div class="card-body" style="overflow-y: auto; height: 350px;">
                                    <div class="container card-project-teams-list">

                                        <?php
                                        $projectTeamNo = 1;
                                        foreach ($teamCategories as $teamCategory) {
                                            ?>

                                            <div class="row shadow-sm ps-2 py-3 my-2 rounded-3 fw-normal"
                                                 style="font-size: 1.0rem; background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                                <div class="col-9 d-flex">
                                                    <div class="my-auto fs-5"><?= $teamCategory->getCategoryName() ?></div>
                                                </div>
                                                <div class="col-3" style="font-size: 1.5rem;">
                                                    <div class="d-flex mx-auto card-list-option-buttons"
                                                         style="font-size: 1.7rem;">
                                                        <!--========== edit team category button =========-->
                                                        <ion-icon class="me-2 my-auto" type="button"
                                                                  data-bs-toggle="modal"
                                                                  data-bs-target="#edit-project-teams-<?= $projectTeamNo ?>"
                                                                  name="create-outline"></ion-icon>

                                                        <!-- =========== edit team category button model =========== -->
                                                        <div class="modal fade"
                                                             id="edit-project-teams-<?= $projectTeamNo ?>"
                                                             tabindex="-1"
                                                             role="dialog"
                                                             aria-labelledby="exampleModalCenterTitle"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                 role="document">
                                                                <div class="modal-content">
                                                                    <!--=== form =====-->
                                                                    <form action="process/projectdashboard/editTeam.php"
                                                                          method="post">
                                                                        <div class="modal-header py-2 px-2"
                                                                             style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                                            <div class="d-flex flex-row w-100 justify-content-between">

                                                                                <div class="ms-2 my-auto fs-4 fw-bold">
                                                                                    Project Team
                                                                                </div>

                                                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                                                <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                                     style="font-size: 1.3rem; color: var(--accent-color2);">
                                                                                    Edit
                                                                                </div>
                                                                            </div>

                                                                            <!--======= hidden ==========-->
                                                                            <input type="hidden" name="menuNo"
                                                                                   value="7">
                                                                            <input type="hidden" name="category_id"
                                                                                   value="<?= $teamCategory->getCategoryID() ?>">
                                                                        </div>

                                                                        <div class="modal-body"
                                                                             style="background-color: var(--lighter-secondary);">
                                                                            <div class="d-flex px-5">
                                                                                <input class="form-control text-center"
                                                                                       type="text"
                                                                                       name="team_name"
                                                                                       value="<?= $teamCategory->getCategoryName() ?>"
                                                                                       placeholder="Team Name"/>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer"
                                                                             style="background-color: var(--primary);">
                                                                            <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">
                                                                                Close
                                                                            </button>
                                                                            <button type="submit"
                                                                                    name="submit"
                                                                                    class="btn fw-bold"
                                                                                    style="background-color: var(--secondary); color: var(--primary);">
                                                                                Update
                                                                            </button>

                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <!--========== Delete team category button =========-->
                                                        <ion-icon class="my-auto" type="button"
                                                                  data-bs-toggle="modal"
                                                                  data-bs-target="#delete-project-teams-<?= $projectTeamNo ?>"
                                                                  name="trash-outline"></ion-icon>
                                                        <!-- =========== Delete team category button model =========== -->
                                                        <div class="modal fade"
                                                             id="delete-project-teams-<?= $projectTeamNo ?>"
                                                             tabindex="-1"
                                                             role="dialog"
                                                             aria-labelledby="exampleModalCenterTitle"
                                                             aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                 role="document">
                                                                <div class="modal-content">
                                                                    <!--=== form =====-->
                                                                    <form action="process/projectdashboard/deleteTeam.php"
                                                                          method="post">
                                                                        <div class="modal-header py-2 px-2"
                                                                             style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                                                            <div class="d-flex flex-row w-100 justify-content-between">

                                                                                <div class="ms-2 my-auto fs-4 fw-bold">
                                                                                    <?= $teamCategory->getCategoryName() ?>
                                                                                </div>

                                                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                                                <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                                                     style="font-size: 1.3rem; color: var(--accent-color3);">
                                                                                    Delete
                                                                                </div>
                                                                            </div>

                                                                            <!--======= hidden ==========-->
                                                                            <input type="hidden" name="menuNo"
                                                                                   value="7">
                                                                            <input type="hidden" name="category_id"
                                                                                   value="<?= $teamCategory->getCategoryID() ?>">
                                                                        </div>

                                                                        <div class="modal-body"
                                                                             style="background-color: var(--lighter-secondary);">
                                                                            <div class="d-flex fw-normal fs-5">
                                                                                Do you want to Delete this Team ?
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer"
                                                                             style="background-color: var(--primary);">
                                                                            <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-bs-dismiss="modal">
                                                                                Close
                                                                            </button>
                                                                            <button type="submit"
                                                                                    name="submit"
                                                                                    class="btn fw-bold"
                                                                                    style="background-color: var(--accent-color3); color: var(--primary);">
                                                                                Delete
                                                                            </button>

                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php

                                            $projectTeamNo++;
                                        }

                                        ?>


                                    </div>
                                </div>
                            </div>

                            <!-- =========== project chair details ======= -->
                            <div class="card d-flex flex-column border rounded mt-4 shadow-sm">
                                <div class="card-header"
                                     style="background-color: var(--primary); color: var(--lighter-secondary);">
                                    <div class="fw-bold mx-auto" style="font-size: 1.3rem;">Project Chair</div>
                                </div>

                                <div class="d-flex card-body">
                                    <img class="shadow-sm rounded-circle mx-3"
                                         style="width: 80px; height: 80px; object-fit: cover;"
                                         src="assets/images/profile_img/ug/<?= $projectChair->getProfileImg() ?>"
                                         alt=""/>
                                    <div class="d-flex ms-2 my-auto flex-column fw-bold">
                                        <div class="d-flex">
                                            <div class="fw-bold" style="color: var(--accent-color3);">Name</div>
                                            <div class="ms-2"><?= $projectChair->getFirstName() ?> <?= $projectChair->getLastName() ?></div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="fw-bold" style="color: var(--accent-color3);">Email</div>
                                            <div class="ms-2"><?= $projectChair->getUsername() ?></div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="fw-bold" style="color: var(--accent-color3);">Contact No</div>
                                            <div class="ms-2"><?= $projectChair->getContactNo() ?></div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--=== pre loader ===-->
    <?php include_once "content/preloader.php" ?>
    <!--=== Preloader Script file ===-->
    <?php include_once "content/commonJS.php" ?>
    <!--=========== Selected Menu change when loading ============-->
    <script>
        document.getElementById("menu-<?php echo $selected_menuNo ?>").classList.add("activate");
        document.getElementById("menu-content-<?php echo $selected_menuNo ?>").classList.remove("hide");
        document.getElementById("menu-content-<?php echo $selected_menuNo ?>").classList.add("show");
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
    <script>
        function addMemberToProject() {
            let username = document.getElementById("add-member-username-input").value;
            let projectTeamID = document.getElementById("add-member-team-select").value;
            console.log(username);
            console.log(projectTeamID);

            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'process/projectdashboard/addTeamMember.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    let response = JSON.parse(xhr.responseText);

                    // Access the original username and the result from the response object
                    let message = response.message;
                    let success = response.success;

                    if (success) {
                        window.location.href = 'projectdashboard.php?tab=2';
                    } else {
                        document.getElementById("add-member-team-error").innerText = message;
                    }


                }
            };

            // Send the username to the PHP script
            xhr.send('username=' + encodeURIComponent(username) + '&project_team_id=' + encodeURIComponent(projectTeamID));


        }
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
    <script src="assets/js/projectdashboard.js"></script>

    </body>

    </html>