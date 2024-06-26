<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <!-- ====== CSS Files ==== -->
    <link rel="stylesheet" href="assets/css/register.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- ===== Boostrap CSS ==== -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">


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
                <a href="login.php" class="d-flex text-decoration-none">
                    <!--			  <button class="btn btn-outline-secondary d-flex align-items-center" type="submit"><Span class="d-none d-lg-inline pe-2">SignUp</Span><ion-icon style="font-size: 1.0rem;;"" name="person-add-outline"></ion-icon></button>-->
                    <button class="btn btn-outline-primary ms-2 d-flex align-items-center" type="submit"><Span
                                class="d-none d-lg-inline-block pe-2">LogIn</Span>
                        <ion-icon style="font-size: 1.5rem;" name="log-in-outline"></ion-icon>
                    </button>
                </a>
            </div>
        </div>
    </nav>
    <div class="w-100" style="height: 100vh;">
        <div class="container">
            <div class="row mh-100vh">
                <div class="screen  " >
                    <div class=" screen__content" >
                        <h3 style="padding: 30px 0px 30px 0px;color: black;font-weight: bold; " align="center">
                            Register </h3>
                        <div class="text-center m-3">
                            <a href="content/ug_signup.php">
                                <button class="btn btn-danger " type="button"
                                        style="border: none;width: 300px;height: 58px;background-color: #2b14bc;">
                                    Undergraduates
                                </button>
                            </a>
                        </div>
                        <div style="padding-bottom: 30px;" class="text-center m-3">
                            <a href="content/club_signup.php">
                                <button class="btn btn-danger " type="button"
                                        style="border: none;width: 300px;height: 58px;background-color: #339363;">
                                    Club/Society
                                </button>
                            </a>
                        </div>

                    </div>
                    <div class="screen__background">
                        <span class="screen__background__shape screen__background__shape4"></span>
                        <span class="screen__background__shape screen__background__shape3"></span>
                        <span class="screen__background__shape screen__background__shape2"></span>
                        <span class="screen__background__shape screen__background__shape1"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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

<!-- ====== Script files ===== -->
<script src="assests/js/home.js"></script>
</body>
</html>