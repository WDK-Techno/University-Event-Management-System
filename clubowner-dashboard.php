<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- ====== CSS Files ==== -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- <link rel="stylesheet" href="assests/scss/style.scss"> -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="../assets/css/clubownerdash.css">

    <!-- ===== Boostrap CSS ==== -->
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


</head>

<body style="box-sizing: border-box;">

    <!-- =======  side bar ======= -->
    <div class="sideBar w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:block;" id="mySidebar">


        <!-- ======== side bar content ======= -->
        <div class="d-flex flex-column flex-shrink-0 p-3">

            <ion-icon id="openNav" class="d-block m-2" onclick="sideBarControl()" name="chevron-back-circle-outline"></ion-icon>

            <!-- <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <span class="fs-4 m-2">Sidebar</span>
            </a> -->

            <div id="project-details" class="my-2" style="font-weight:bold; font-size: 1.5rem;">
                <span class="d-block w3-text-light-blue"></span>
                <span class="d-block w3-text-cyan">IEEE Club</span>
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
            <div id="user-name">
                <div class="d-flex justify-content-start">
                    <ion-icon name="person-circle-outline" class="d-block my-auto w3-text-lime" style="font-size:2.8rem;"></ion-icon>
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
                <a class="navbar-brand text-primary d-none d-sm-block" href="index.html">UWU<span class="text-dark">Event</span><span class="text-warning">z</span></a>
                <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button> -->
                <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
                <div id="project-name" class="ms-0 me-auto mx-sm-auto">Club President Dash</div>
                <div class="d-flex" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li> -->
                    </ul>

                    <div class="btn-group ms-auto me-0">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img id="user-img" src="https://github.com/mdo.png" alt="" width="40" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu shadow dropdown-menu-end">
                            <!-- <li class="dropdown-item d-flex justify-content-start px-4"><ion-icon name="person-outline" style="font-size: 1.2rem;" class="me-2"></ion-icon><span>Profile</span></li>
                            <li class="dropdown-item d-flex justify-content-start px-4"><ion-icon name="arrow-undo-outline" style="font-size: 1.2rem;" class="me-2"></ion-icon><span>Userboard</span></li> -->
                            <li class="dropdown-item d-flex justify-content-start px-4"><span>Userboard</span><ion-icon name="arrow-undo-outline" class="ms-auto" style="font-size: 1.2rem;"></ion-icon>
                            </li>
                            <li class="dropdown-item d-flex justify-content-start px-4"><span>Profile</span><ion-icon name="person-outline" class="ms-auto" style="font-size: 1.2rem;"></ion-icon></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li class="dropdown-item d-flex justify-content-start px-4" type="button">
                                <span>Logout</span><ion-icon name="log-out-outline" class="ms-auto" style="font-size: 1.2rem;"></ion-icon>
                            </li>
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
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Project details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method=POST>
                                <div class="modal-body">

                                    <label for="prName" class="form-label h5">Name</label>
                                    <br />
                                    <input type="text" id="prName" name="prName" required />
                                    <br />
                                    <label for="cbName" class="form-label h5">club name</label>
                                    <br />
                                    <input type="text" id="cbName" name="cbName" required />
                                    <br />
                                    <label for="Prchair" class="form-label h5">select project chair</label>
                                    <br />
                                    <input type="text" id="Prchair" name="Prchair" required />


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="addProject">Add</button>
                                    </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <hr />

            <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3">
                <div class="col">
                    <div class="rounded border">
                        <div class="bg-image card d-block shadow-1-strong h-80" style="background-image: url('https://assets-global.website-files.com/5e39e095596498a8b9624af1/5f6e93d250a6d04f4eae9f02_Backgrounds-WFU-thumbnail-(size).jpg');">
                            <div class="card-body text-white">
                                <h5 class="card-title">Project name</h5>
                                <p class="card-text">
                                    Some quick example text to build on the card title and make up the bulk of the
                                    card's content.
                                </p>
                                <a href="#!" class="btn btn-outline-light">More</a>
                            </div>
                        </div>
                        <div class="py-4">
                            <div class="toggle-button-cover">
                                <div class="button-cover">
                                    <div class="button r" id="button-3">
                                        <input type="checkbox" class="checkbox" />
                                        <div class="knobs"></div>
                                        <div class="layer"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

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
        <h1>Content 5</h1>
    </div>

    </div>

    <!-- ==== Boostrap Script ==== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>


    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <!-- ========= Ionicons Scripts ===== -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- ====== Script files ===== -->
    <script src="../assets/js/projectdashboard.js"></script>

</body>

</html>