<?php

require_once "classes/DBConnector.php";
require_once "classes/Project.php";
require_once "classes/User.php";
require_once "classes/TeamCategory.php";
require_once "classes/TeamMember.php";
require_once "classes/Event.php";


use classes\Project;
use classes\DBConnector;
use classes\Club;
use classes\Undergraduate;
use classes\TeamCategory;
use classes\TeamMember;

$projectIDFromSession = 1;
$con = DBConnector::getConnection();

//Load Project Details to object
$project = new Project($projectIDFromSession, null, null, null, null);

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

    $teamMembers = TeamMember::getMemberListFromProjectID($con, $project->getProjectID());

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
        <title>Document</title>

        <!-- ====== CSS Files ==== -->
        <link rel="stylesheet" href="assets/css/style.css">
        <!-- <link rel="stylesheet" href="assests/scss/style.scss"> -->
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="assets/css/projectdashboard.css">

        <!-- ===== Boostrap CSS ==== -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
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
                        <ion-icon name="people-circle-outline"></ion-icon>
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
                        <ion-icon name="walk-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">Activitty Plan</span>
                    </a>
                </li>
                <li id="menu-5" class="sideBar-btn" onclick="showMenuContent(5)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="document-text-outline"></ion-icon>
                        <span class="sideBar-btn-text my-auto">PR Plan</span>
                    </a>
                </li>
                <li id="menu-6" class="sideBar-btn" onclick="showMenuContent(6)">
                    <a href="#" class="nav-link d-flex justify-content-start">
                        <ion-icon name="document-text-outline"></ion-icon>
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
            <div id="user-name">
                <div class="d-flex justify-content-start">
                    <ion-icon name="person-circle-outline" class="d-block my-auto w3-text-lime"
                              style="font-size:2.8rem;"></ion-icon>
                    <span class="ms-2 w3-text-light-green">
                        <strong class="d-block">Kavindra</strong>
                        <strong class="d-block">Weerasinghe</strong>
                    </span>
                </div>
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
                            <img id="user-img" src="https://github.com/mdo.png" alt="" width="40"
                                 class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu shadow dropdown-menu-end">
                            <!-- <li class="dropdown-item d-flex justify-content-start px-4"><ion-icon name="person-outline" style="font-size: 1.2rem;" class="me-2"></ion-icon><span>Profile</span></li>
                            <li class="dropdown-item d-flex justify-content-start px-4"><ion-icon name="arrow-undo-outline" style="font-size: 1.2rem;" class="me-2"></ion-icon><span>Userboard</span></li> -->
                            <li class="dropdown-item d-flex justify-content-start px-4"><span>Userboard</span>
                                <ion-icon
                                        name="arrow-undo-outline" class="ms-auto" style="font-size: 1.2rem;"></ion-icon>
                            </li>
                            <li class="dropdown-item d-flex justify-content-start px-4"><span>Profile</span>
                                <ion-icon
                                        name="person-outline" class="ms-auto" style="font-size: 1.2rem;"></ion-icon>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-item d-flex justify-content-start px-4" type="button">
                                <span>Logout</span>
                                <ion-icon name="log-out-outline" class="ms-auto"
                                          style="font-size: 1.2rem;"></ion-icon>
                            </li>
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
                                 style="color: var(--darker-primary) !important; background-color: var(--secondary);"
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
                                    <form action="" method="post">
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
                                                       name="username" placeholder="Email" required/>
                                            </div>
                                            <!-- ===== select team ======= -->
                                            <div class="d-flex mt-2 px-5">
                                                <select class="form-select ms-auto me-0" style="width: 50%;"
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


                        <!-- ========== member table ============ -->
                        <div class="card" style="height: 500px;">
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
                            <div class="card-body pt-0 bg-dark-subtle"
                                 style="background-color: var(--secondary); overflow-y: scroll;">
                                <div class="container p-0">
                                    <?php
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

                                                    <ion-icon class="my-auto me-2" type="button"
                                                              data-bs-toggle="modal"
                                                              data-bs-target=""
                                                              name="create-outline"></ion-icon>
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
        </div>
        <div id="menu-content-6" class="main-content hide">
            <div class="col-12 col-lg-4">
                <div class="w-100 p-0 pt-3 d-flex container">
                    <div class="card-header d-flex w-100"
                         style="background-color: var(--primary); color: var(--lighter-secondary);">
                        <div class="my-auto fw-bold" style="font-size: 1.3rem;">Events</div>
                        <div class="btn fw-bold my-auto ms-auto me-2 d-flex"
                             style="color: var(--accent-color2) !important"
                             type="button" data-bs-toggle="modal"
                             data-bs-target="#add-new-event">
                            <ion-icon class="my-auto" name="add-outline"></ion-icon>
                            <div class="my-auto">New</div>
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
                                            <input type="hidden" name="menuNo" value="7">
                                            <input type="hidden" name="event_id"
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
                                                       name="event_date" placeholder="Event Date"/><br>
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
                    <div class="card-body" style="overflow-y: auto; height: ;">
                        <div class="container card-event-list ">
                            <?php
                            $eventNo = 1;
                            foreach ($project as $event) {
                                ?>
                                <div class="row shadow-sm ps-2 py-3 my-2 rounded-3 fw-normal"
                                     style="font-size: 1.0rem; background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                    <div class="col-9 d-flex">
                                        <div class="my-auto fs-5"><?= $event->geteventName() ?></div>
                                    </div>
                                    <div class="col-3" style="font-size: 1.5rem;">
                                        <div class="d-flex mx-auto card-list-option-buttons"
                                             style="font-size: 1.7rem;">
                                            <!--========== edit event button =========-->
                                            <ion-icon class="me-2 my-auto" type="button"
                                                      data-bs-toggle="modal"
                                                      data-bs-target="#edit-event<?= $eventNo ?>"
                                                      name="create-outline"></ion-icon>

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
                                                                       value="7">
                                                                <input type="hidden" name="event_id"
                                                                       value="<?= $event->geteventId() ?>">
                                                            </div>

                                                            <div class="modal-body"
                                                                 style="background-color: var(--lighter-secondary);">
                                                                <div class="d-flex px-5">
                                                                    <input class="form-control text-center"
                                                                           type="text"
                                                                           name="name"
                                                                           value="<?= $eventName->geteventName() ?>"
                                                                           placeholder="Event Name"/>
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
                                            <ion-icon class="my-auto" type="button" data-bs-toggle="modal"
                                                      data-bs-target="#delete-event<?= $eventNo ?>"
                                                      name="trash-outline"></ion-icon>
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
                                                                        <?= $eventName->geteventName() ?>
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
                                                                <input type="hidden" name="event_id"
                                                                       value="<?= $eventId->geteventId() ?>">
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
                        <h1>das</h1>
                    </div>
                    <!-- ========== right side section ========== -->
                    <div class="col-12 col-lg-4">
                        <div class="w-100 p-0 pt-3 d-flex container">
                            <div id="project-teams-list" class="card mx-auto col-12 col-md-8 col-lg-12">
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
                                                <form action="process/projectdashboard/addNewTeam.php" method="post">
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
                                <!-- ========== project list body =========== -->
                                <div class="card-body" style="overflow-y: auto; height: 300px;">
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
                                                        <ion-icon class="my-auto" type="button" data-bs-toggle="modal"
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

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
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
    <script src="assets/js/projectdashboard.js"></script>

    </body>

    </html>
    <?php
}
?>