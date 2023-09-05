<?php
session_start();
require_once 'classes/DBConnector.php';
require_once 'classes/Project.php';
require_once 'classes/User.php';

use classes\DBConnector;
use classes\Project;
use classes\Club;
use classes\Undergraduate;


$con = DBConnector::getConnection();

if (isset($_SESSION['user_id'])) {


    $clubid = $_SESSION['user_id'];
    $projects = Project::getProjectListFromClubID($con, $clubid);

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
                            <form action="process/clubownerdashboard/getIntoProject.php" method="post">
                                <div class="rounded border">
                                    <div class="card d-block shadow-sm">
                                        <div class="card-header p-3 text-white"
                                             style="background-color: var(--primary)">
                                            <h5 class="card-title fw-bold"
                                                style="font-size: 1.5rem"><?= $project->getProjectName() ?></h5>
                                            <!--==== hidden ======-->
                                            <input type="hidden" name="project_id"
                                                   value="<?= $project->getProjectID() ?>">

                                            <button type="submit" name="submit" class="btn my-2 btn-outline-light">
                                                Access
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
                                        <form action="process/clubownerdashboard/deleteProject.php" method="post">
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
                        <?php
                    }
                    $i++;
                } ?>
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