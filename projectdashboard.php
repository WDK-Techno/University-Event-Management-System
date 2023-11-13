<?php
session_start();
require_once "classes/DBConnector.php";
require_once "classes/Project.php";
require_once "classes/User.php";
require_once "classes/TeamCategory.php";
require_once "classes/TeamMember.php";
require_once "classes/Event.php";
require_once "classes/PRTask.php";

use classes\Event;
use classes\Project;
use classes\DBConnector;
use classes\Club;
use classes\Undergraduate;
use classes\TeamCategory;
use classes\TeamMember;
use classes\PRTask;

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
} else

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
$desingTeamMembers = TeamMember::getMemberListFromCategoryID($con, $project->getDesignTeamID());
$writingTeamMembers = TeamMember::getMemberListFromCategoryID($con, $project->getWritingTeamID());

//Get Events List
$events = Event::getEventListFromProjectID($con, $project->getProjectID());
//Get Team Member List
$teamMembers = TeamMember::getMemberListFromProjectID($con, $project->getProjectID());
//Get PR Tasks List
$PRTasks = PRTask::getTaskListFromProjectID($con, $project->getProjectID());


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $selected_menuNo = 3;
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

    <!-- ===== Boostrap CSS ==== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
          crossorigin="anonymous">

    <!-- ======= daypilot Grant chart ========== -->
    <script src="GrantChart/js/daypilot/daypilot-all.min.js" type="text/javascript"></script>
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
        <?php include_once "content/projectdashboard/teamMembers.php" ?>
    </div>
    <div id="menu-content-3" class="main-content hide">
        <?php include_once "content/GrantChart.php" ?>
    </div>
    <div id="menu-content-4" class="main-content hide">
        <?php include_once  "content/projectdashboard/activityPlan.php" ?>
    </div>
    <div id="menu-content-5" class="main-content hide">
        <div class="container-fluid">
            <div class="row d-flex">
                <div class="col-11 mx-auto">
                    <div class="d-flex flex-column mt-3 mb-2">
                        <div class="d-flex my-3 mx-auto w-100">
                            <!-- ======= define PR dropdowns ======== -->
                            <div class="d-flex ms-0 me-auto my-auto">
                                <form action="process/projectdashboard/definePRTeams.php" method="POST" class="d-flex"
                                      style="height: fit-content">
                                    <select id="design_team_id" class="form-select" onchange="defineSubmit()"
                                            style="width: 50%;"
                                            name="design_team_id" id="" required>

                                        <option class="text-center" value="null">-- Define Design Team --
                                        </option>
                                        <?php
                                        $isSelected = "";
                                        foreach ($teamCategories as $teamCategory) {
                                            if ($project->getDesignTeamID() == $teamCategory->getCategoryID()) {
                                                $isSelected = "selected";
                                            } else {
                                                $isSelected = "";
                                            }
                                            ?>
                                            <option value="<?= $teamCategory->getCategoryID() ?>" <?= $isSelected ?>><?= $teamCategory->getCategoryName() ?></option>
                                            <?php

                                        }
                                        ?>
                                    </select>
                                    <select id="sec_team_id" class="form-select ms-2" onchange="defineSubmit()"
                                            style="width: 50%;"
                                            name="sec_team_id" id="" required>
                                        <option class="text-center" value="null" selected>-- Define Writing Team --
                                        </option>
                                        <?php
                                        $isSelected = "";
                                        foreach ($teamCategories as $teamCategory) {
                                            if ($project->getWritingTeamID() == $teamCategory->getCategoryID()) {
                                                $isSelected = "selected";
                                            } else {
                                                $isSelected = "";
                                            }
                                            ?>
                                            <option value="<?= $teamCategory->getCategoryID() ?>" <?= $isSelected ?>><?= $teamCategory->getCategoryName() ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <!--======= hidden ==========-->
                                    <input type="hidden" name="menuNo" value="5">
                                    <input type="hidden" name="project_id"
                                           value="<?= $project->getProjectID() ?>">
                                    <input class="d-none" type="submit" name="define_submit"
                                           id="define_submit"/>

                                </form>
                            </div>

                            <!-- ======= add task button ======== -->
                            <?php
                            $isDisabled = "disabled";
                            if ($project->getDesignTeamID() != null && $project->getWritingTeamID() != null) {
                                $isDisabled = "";
                            }
                            ?>
                            <div class="btn fw-bold my-auto me-0 ms-auto d-flex <?= $isDisabled ?>"
                                 style="color: var(--lighter-secondary) !important; background-color: var(--primary); height: fit-content"
                                 type="button" data-bs-toggle="modal"
                                 data-bs-target="#add-new-task">
                                <ion-icon class="my-auto" name="add-outline"></ion-icon>
                                <div class="my-auto">Task</div>
                            </div>
                        </div>

                        <!-- ========= add task button model ========== -->
                        <div class="modal fade"
                             id="add-new-task"
                             tabindex="-1"
                             role="dialog"
                             aria-labelledby="exampleModalCenterTitle"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered"
                                 role="document">
                                <div class="modal-content">
                                    <!--=== form =====-->
                                    <form action="process/projectdashboard/addNewTask.php" method="POST">
                                        <div class="modal-header py-2 px-2"
                                             style="background-color: var(--darker-primary); color: var(--lighter-secondary);">
                                            <div class="d-flex flex-row w-100 justify-content-between">

                                                <div class="ms-2 my-auto fs-4 fw-bold">
                                                    Task
                                                </div>

                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-primary text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">New</div> -->
                                                <!-- <div class="me-3 ms-auto my-auto px-3 py-1 bg-dark text-light fw-bold rounded-3 shadow-sm" style="font-size: 1.1rem;">Ongoing</div> -->
                                                <div class="me-3 ms-auto my-auto px-1 py-1 fw-bold rounded-3 shadow-sm"
                                                     style="font-size: 1.3rem; color: var(--accent-color2);">
                                                    New
                                                </div>
                                            </div>

                                            <!--======= hidden ==========-->
                                            <input type="hidden" name="menuNo" value="5">
                                        </div>

                                        <div class="modal-body"
                                             style="background-color: var(--lighter-secondary);">
                                            <!-- ====== input topic and description ====== -->
                                            <div class="d-flex mt-2 px-5">
                                                <input class="form-control text-center"
                                                       name="topic" id="add-topic"
                                                       placeholder="Topic" required/>
                                            </div>
                                            <div class="d-flex mt-2 px-5">
                                                <input class="form-control text-center"
                                                       name="description" id="add-description"
                                                       placeholder="Description"/>
                                            </div>
                                            <!-- ===== select team ======= -->
                                            <div class="d-flex mt-2 px-5">

                                                <select id="designer_id" class="form-select ms-auto me-2"
                                                        style="width: 50%;"
                                                        name="designer_id" id="" required>
                                                    <option class="text-center" value="" selected>-- Select Designer --
                                                    </option>
                                                    <?php
                                                    foreach ($desingTeamMembers as $desingTeamMember) {
                                                        $member = new Undergraduate(null, null, null, null, null, null);
                                                        $member->setUserId($desingTeamMember->getUgID());
                                                        $member->loadDataFromUserID($con);
                                                        ?>
                                                        <option value="<?= $member->getUserId() ?>"><?= $member->getFirstName() ?> <?= $member->getLastName() ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                                <select id="caption_writer_id" class="form-select ms-auto me-0"
                                                        style="width: 50%;"
                                                        name="caption_writer_id" id="" required>
                                                    <option class="text-center" value="" selected>-- Select Caption
                                                        Writter
                                                        --
                                                    </option>
                                                    <?php
                                                    foreach ($writingTeamMembers as $writingTeamMember) {
                                                        $member = new Undergraduate(null, null, null, null, null, null);
                                                        $member->setUserId($writingTeamMember->getUgID());
                                                        $member->loadDataFromUserID($con);
                                                        ?>
                                                        <option value="<?= $member->getUserId() ?>"><?= $member->getFirstName() ?> <?= $member->getLastName() ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>

                                            </div>
                                            <div class="mt-2 text-center" id="add-member-team-error"
                                                 style="color: var(--accent-color3)"></div>

                                            <div class="d-flex mt-2 px-5 w-100">
                                                <div class="d-flex w-100 rounded p-2" style="background-color: var(--secondary)">
                                                    <div class="ms-1 me-auto my-auto fw-bold" style="font-size: 0.8rem;">Publish <br> Date & Time</div>
                                                    <div class="d-flex ms-auto me-0">
                                                        <input class="form-control text-center me-2" type="date" required
                                                               style="width: fit-content"
                                                               name="publish_date"/>
                                                        <input class="form-control text-center" style="width: fit-content"
                                                               type="time" required
                                                               name="publish_time"/>
                                                    </div>

                                                </div>
                                            </div>
                                            <!--======= hidden ==========-->
                                            <input type="hidden" name="menuNo" value="5">
                                            <input type="hidden" name="project_id"
                                                   value="<?= $project->getProjectID() ?>">

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
                        <div class="card" style="height: fit-content;">
                            <div class="card-header team-member-table pb-0"
                                 style="background-color: var(--darker-primary); color: var(--lighter-secondary);">

                                <div class="row p-0 fw-bold">
                                    <div class="col-1 text-center py-2 rounded-top-3"
                                         style="background-color: var(--primary);">
                                        Published
                                    </div>
                                    <div class="col-1 text-center py-2 rounded-top-3"
                                         style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                        Publish Date
                                    </div>
                                    <div class="col-1 text-center py-2 rounded-top-3"
                                         style="background-color: var(--primary);">Time
                                    </div>
                                    <div class="col-2 text-center py-2 rounded-top-3"
                                         style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                        Topic
                                    </div>
                                    <div class="col-3 text-center py-2 rounded-top-3"
                                         style="background-color: var(--primary);">
                                        Description
                                    </div>
                                    <div class="col-1 text-center py-2 rounded-top-3"
                                         style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                        Designer
                                    </div>
                                    <div class="col-1 text-center py-2 rounded-top-3"
                                         style="background-color: var(--primary);">
                                        Caption Writter
                                    </div>
                                    <div class="col-1 text-center py-2 rounded-top-3"
                                         style="background-color: var(--lighter-secondary); color: var(--darker-primary);">
                                        Verify
                                    </div>
                                    <div class="col-1">

                                    </div>
                                </div>

                            </div>

                            <div class="card-body pt-0 bg-dark-subtle scrollable-div Flipped"
                                 style="background-color: var(--secondary);">
                                <div class="container p-0 scrollable-div-inside">

                                    <?php
                                    $prTaskNo = 1;
                                    foreach ($PRTasks as $PRTask) {
                                        $task = new PRTask($PRTask->getprID(), null, null, null, null, null, null);
                                        $task->loadTaskFromPRId($con);

                                        ?>
                                        <form action="process/projectdashboard/editPRTask.php" class="" method="POST">
                                            <div class="row mb-2 shadow-sm set-border" style="height: 50px;">

                                                <div class="col-1 tabel-column-type-1 d-flex justify-content-center"
                                                     style="font-size: 1.8rem; ">
                                                    <input type="checkbox"
                                                           class="my-auto ms-3 me-auto form-check-input"
                                                           style="background-color: var(--primary);border-color: var(--accent-color3) ; border-width: 2.5px;"
                                                           name="is_published"
                                                           value="published"
                                                        <?php if ($task->getisVerifyByProjectChair() == 0) echo "disabled" ?>
                                                        <?php if ($task->getisPublished() == 1) echo "checked" ?>
                                                           onchange="updatePRSubmit(<?= $prTaskNo ?>)">
                                                </div>
                                                <div class="col-1 tabel-column-type-2 d-flex justify-content-center">
                                                    <div class="my-auto d-flex flex-column">
                                                        <div class="d-flex mx-auto fw-lighter"
                                                             style="font-size: 0.8rem;"><?= date("Y", strtotime($task->getpublishDate())) ?></div>
                                                        <div class="d-flex mx-auto">
                                                            <div class="me-1"><?= date("M", strtotime($task->getpublishDate())) ?></div>
                                                            <div><?= date("d", strtotime($task->getpublishDate())) ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-1 tabel-column-type-1 d-flex justify-content-center">
                                                    <div class="my-auto"><?= date("g:i A", strtotime($task->getpublishDate())) ?></div>
                                                </div>
                                                <div class="col-2 tabel-column-type-2 d-flex justify-content-center">
                                                    <div class="my-auto fw-bold"><?= $task->gettopic() ?></div>
                                                </div>
                                                <div class="col-3 tabel-column-type-1 d-flex justify-content-center">
                                                    <div class="my-auto text-center"><?= $task->getdescription() ?></div>
                                                </div>
                                                <div class="col-1 tabel-column-type-2 d-flex justify-content-center"
                                                     style="font-size: 0.8rem; text-align: center">
                                                    <?php
                                                    $disgner = new Undergraduate(null, null, null, null, null, null);
                                                    $disgner->setUserId($task->getdesignerID());
                                                    $disgner->loadDataFromUserID($con);
                                                    ?>
                                                    <div class="my-auto"><?= $disgner->getFirstName() ?>
                                                        <br><?= $disgner->getLastName() ?></div>
                                                </div>
                                                <div class="col-1 tabel-column-type-1 d-flex justify-content-center"
                                                     style="font-size:0.8rem ;text-align: center;">
                                                    <?php
                                                    $writer = new Undergraduate(null, null, null, null, null, null);
                                                    $writer->setUserId($task->getcaptionWriterID());
                                                    $writer->loadDataFromUserID($con);
                                                    ?>
                                                    <div class="my-auto"><?= $writer->getFirstName() ?>
                                                        <br><?= $writer->getLastName() ?></div>
                                                </div>

                                                <div class="col-1 tabel-column-type-2 d-flex justify-content-center"
                                                     style="font-size: 1.3rem;">
                                                    <input type="checkbox"
                                                           class="my-auto form-check-input"
                                                           style="background-color: var(--accent-color3); border-color: yellow;border-width: 1.2px"
                                                           name="is_verify" value="verified"
                                                        <?php if ($task->getisPublished() == 1) echo "disabled" ?>
                                                        <?php if ($task->getisVerifyByProjectChair() == 1) echo "checked" ?>
                                                           onchange="updatePRSubmit(<?= $prTaskNo ?>)">
                                                </div>
                                                <div class="col-1 tabel-column-type-1 d-flex justify-content-center"
                                                     style="font-size: 1.5rem">
                                                    <ion-icon class="my-auto me-2" type="button"
                                                              data-bs-toggle="modal"
                                                              data-bs-target="#edit-pr-task-<?= $prTaskNo ?>"
                                                              name="create-outline"></ion-icon>
                                                    <ion-icon class="my-auto" type="button"
                                                              data-bs-toggle="modal"
                                                              data-bs-target="#delete-pr-task-<?= $prTaskNo ?>"
                                                              name="trash-outline"></ion-icon>
                                                </div>
                                                <!--======= hidden ==========-->
                                                <input type="hidden" name="menuNo" value="5">
                                                <input type="hidden" name="pr_id"
                                                       value="<?= $task->getprID() ?>">
                                                <input class="d-none" type="submit" name="pr_update_submit"
                                                       id="pr_update_submit_<?= $prTaskNo ?>"/>
                                            </div>

                                        </form>
                                        <?php
                                        $prTaskNo++;
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
    <div id="menu-content-6" class="main-content hide">
        <?php include_once 'content/projectdashboard/events.php' ?>
    </div>
    <div id="menu-content-7" class="main-content w-100 h-100 hide">
        <?php include_once "content/projectdashboard/settings.php" ?>
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
<!--========= execute define PR Team submit button ======== -->
<script>
    function defineSubmit() {
        document.getElementById('define_submit').click();
    }
</script>
<!--========= execute PR table update submit button ======== -->
<script>
    function updatePRSubmit(prTaskNo) {
        document.getElementById('pr_update_submit_' + prTaskNo).click();
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