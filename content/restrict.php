<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: ../login.php");
}
unset($_SESSION["user_id"]);
unset($_SESSION['role']);
session_destroy();

$name = "";
$typ = "";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $typ = $_GET['typ'];
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home Page</title>
    <!-- ====== CSS Files ==== -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/login.css">

    <!-- ===== Boostrap CSS ==== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


</head>

<body>

<div class="bgimg">
    <!-- ======= Navigation Bar =======    -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand text-primary" href="index.php">UWU<span class="text-dark">Event</span><span
                        class="text-warning">z</span></a>
            <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button> -->
            <!-- <div class="collapse navbar-collapse" id="navbarSupportedContent"> -->
            <div class="" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item">
                      <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li> -->
                </ul>
                <a href="../login.php" class="d-flex" style="text-decoration: none">
                    <button class="btn btn-outline-primary ms-2 d-flex align-items-center" type="submit"><Span
                                class="d-none d-lg-inline-block pe-2">LogIn</Span>
                        <ion-icon style="font-size: 1.5rem;" name="log-in-outline"></ion-icon>
                    </button>
                    <!--			  <button class="btn btn-outline-primary ms-2 d-flex align-items-center" type="submit"><Span class="d-none d-lg-inline-block pe-2">LogIn</Span><ion-icon style="font-size: 1.5rem;" name="log-in-outline"></ion-icon></button>-->
                </a>
            </div>
        </div>
    </nav>

    <!-- ======= Main Content ====== -->
    <div class="w-100" style="height: 100vh;">
        <div class="container"
             style="position:absolute; left:0; right:0; top: 55%; transform: translateY(-50%); -ms-transform: translateY(-50%); -moz-transform: translateY(-50%); -webkit-transform: translateY(-50%); -o-transform: translateY(-50%);">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-6 col-xl-6 col-xxl-4">
                    <div class="card shadow-lg o-hidden border-0 my-5">
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="p-5 bg-transparent text-center">
                                        <?php
                                        if ($typ === "new") {
                                            $name = $_GET['name'];
                                            ?>
                                            <div class="text-center">
                                                <h4 class="mb-3" style="color: var(--accent-color3);">
                                                    Need Admin Approval</h4>
                                            </div>
                                            <div class="text-center my-2 fw-bold fs-4" style="color: var(--darker-primary);"><?=$name?> Club</div>
                                            <div class="fw-light">Your Club is not get approved yet</div>
                                            <div class="fw-light">Please Contact Admin</div>
                                            <div class="fw-bold">Contact No : 077789456</div>
                                            <div class="fw-bold">Email : admin@gmail.com</div>

                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($typ === "ug_deactive") {
                                            $fName = $_GET['fname'];
                                            $lName = $_GET['lname'];
                                            ?>
                                            <div class="text-center">
                                                <h4 class="mb-3" style="color: var(--accent-color3);">
                                                    Deactivate Account</h4>
                                            </div>
                                            <div class="text-center my-2 fw-bold fs-4" style="color: var(--darker-primary);"><?=$fName?> <?=$fName?></div>
                                            <div class="fw-light">Your account is deactivated</div>
                                            <div class="fw-light">Please Contact Admin</div>
                                            <div class="fw-bold">Contact No : 077789456</div>
                                            <div class="fw-bold">Email : admin@gmail.com</div>

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
        </div>


    </div>
    <!-- Start: Ludens Login -->

</div><!-- End: Ludens Login -->


<!-- ======== Footer ======== -->


<footer class="py-0 px-5 text-dark">
    <div class="row">
        <!-- <h1>zdhfudkslfsudhli</h1> -->
    </div>
    <div class="d-flex flex-column align-items-center flex-lg-row justify-content-lg-between py-4 my-4 border-top">
        <p class="text-center">© 2023 UWUEventz, Inc. <span class="d-block d-md-inline">All rights reserved.</span></p>
        <ul class="list-unstyled d-flex">
            <li class="m-1"><a class="link-dark" href="#">
                    <ion-icon name="logo-tumblr"></ion-icon>
                </a></li>
            <li class="m-1"><a class="link-dark" href="#">
                    <ion-icon name="logo-instagram"></ion-icon>
                </a></li>
            <li class="m-1"><a class="link-dark" href="#">
                    <ion-icon name="logo-facebook"></ion-icon>
                </a></li>
        </ul>
    </div>
</footer>

<!-- ==== Boostrap Script ==== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
<!-- ========= Ionicons Scripts ===== -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>