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
    $desingTeamMembers = TeamMember::getMemberListFromCategoryID($con, $project->getDesignTeamID());
    $writingTeamMembers = TeamMember::getMemberListFromCategoryID($con, $project->getWritingTeamID());

//Get Events List
    $events = Event::getEventListFromProjectID($con, $project->getProjectID());
//Get Team Member List
    $teamMembers = TeamMember::getMemberListFromProjectID($con, $project->getProjectID());
//Get PR Tasks List
    $PRTasks = PRTask::getTaskListFromProjectID($con, $project->getProjectID());


    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $selected_menuNo = 1;
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
                        <span class="sideBar-btn-text my-auto">Gantt Chart</span>
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
            <?php include_once "content/projectdashboard/projectDetails.php" ?>
        </div>
        <!--======== Content 2 - Team Members ======-->
        <div id="menu-content-2" class="main-content hide">
            <?php include_once "content/projectdashboard/teamMembers.php" ?>
        </div>
        <div id="menu-content-3" class="main-content hide">
            <?php include_once "content/GrantChart.php" ?>
        </div>
        <div id="menu-content-4" class="main-content hide">
            <?php include_once "content/projectdashboard/activityPlan.php" ?>
        </div>
        <div id="menu-content-5" class="main-content hide">
            <?php include "content/projectdashboard/pr_plan.php" ?>;
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
        function updatePRSubmit(prTaskNo, no) {
            document.getElementById('pr_update_submit_' + no + '_' + prTaskNo).click();
        }
    </script>
    <!--========= execute sub task complete update submit button ======== -->
    <script>
        function updateSubTaskComplete(subTaskNo) {
            document.getElementById('sub_task_update_submit_'+subTaskNo).click();
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

    <!--======= display selected team members in add subtask model ==========-->
    <script>
        function displaySelectedTeamMembers() {
            let teamCategoryID = document.getElementById("selected-team-cat-in-add-subtask").value;
            console.log(teamCategoryID);

            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'process/projectdashboard/selectTeamMembers.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    let response = JSON.parse(xhr.responseText);

                    // Access the original username and the result from the response object
                    let message = response.message;
                    let success = response.success;
                    let members = response.members;
                    if (success) {
                        // Access the members array here and populate the dropdown
                        let teamMemberDropDown = document.getElementById("selected-team-cat-members");

                        // Clear existing options
                        teamMemberDropDown.innerHTML = '';
                        for (let memberId in members) {
                            let option = document.createElement("option");
                            option.value = memberId;
                            option.text = members[memberId];
                            teamMemberDropDown.add(option);
                        }
                    } else {
                        document.getElementById("add-member-team-error").innerText = message;
                    }


                }
            };

            // Send the username to the PHP script
            xhr.send('team_cat_id=' + encodeURIComponent(teamCategoryID));

        }
    </script>

    <!--======= display selected team members in Edit subtask model ==========-->
    <script>
        function displaySelectedTeamMembersInEdit(subTaskNo) {
            let teamCategoryID = document.getElementById("selected-team-cat-in-edit-subtask-" + subTaskNo).value;
            console.log(teamCategoryID);

            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'process/projectdashboard/selectTeamMembers.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    let response = JSON.parse(xhr.responseText);

                    // Access the original username and the result from the response object
                    let message = response.message;
                    let success = response.success;
                    let members = response.members;
                    if (success) {
                        // Access the members array here and populate the dropdown
                        let teamMemberDropDown = document.getElementById("selected-team-cat-members-in-edit-" + subTaskNo);

                        // Clear existing options
                        teamMemberDropDown.innerHTML = '';
                        for (let memberId in members) {
                            let option = document.createElement("option");
                            option.value = memberId;
                            option.text = members[memberId];
                            teamMemberDropDown.add(option);
                        }
                    } else {
                        document.getElementById("add-member-team-error").innerText = message;
                    }


                }
            };

            // Send the username to the PHP script
            xhr.send('team_cat_id=' + encodeURIComponent(teamCategoryID));

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

    <?php
}
?>