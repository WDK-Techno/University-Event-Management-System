<?php
$errMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['status'])) {
        $error = $_GET['status'];

        if ($error == 1) {
            $errMessage = "Input Cannot Be Empty";
        }
        if ($error == 2) {
            $errMessage = "Invalid Username or Password";
        }
    }
}
?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home Page</title>
    <!-- ====== CSS Files ==== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/login.css">

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
                <a href="register.php" class="d-flex" style="text-decoration: none">
                    <button class="btn btn-outline-secondary d-flex align-items-center" type="submit"><Span
                                class="d-none d-lg-inline pe-2">SignUp</Span>
                        <ion-icon style="font-size: 1.0rem;" name="person-add-outline"></ion-icon>
                    </button>
                    <!--			  <button class="btn btn-outline-primary ms-2 d-flex align-items-center" type="submit"><Span class="d-none d-lg-inline-block pe-2">LogIn</Span><ion-icon style="font-size: 1.5rem;" name="log-in-outline"></ion-icon></button>-->
                </a>
            </div>
        </div>
    </nav>

    <!-- ======= Main Content ====== -->
    <div class="w-100" style="height: 100vh;">
        <div class="container "
             style="position:absolute; left:0; right:0; top: 55%; transform: translateY(-50%); -ms-transform: translateY(-50%); -moz-transform: translateY(-50%); -webkit-transform: translateY(-50%); -o-transform: translateY(-50%);">
            <div class="row justify-content-center ">
                <div class="col-md-7 col-lg-6 col-xl-6 col-xxl-4 ">
                    <div class="card shadow-lg ">
                        <div class="card-body p-0 ">
                            <div class="row ">
                                <div class="col-lg-12 ">
                                    <div class="p-4 " >
                                        <div class="text-center">
                                            <h4 class="text-dark mb-4">User Login</h4>
                                        </div><!-- Start: Login Form -->
                                        <form action="process/login.php" method="post" class="user">
                                            <div class="mb-3">
                                                <input class="form-control form-control-user"  type="email"
                                                       id="email" aria-describedby="emailHelp"
                                                       placeholder="Enter Email Address" name="username" required="">
                                            </div>
                                            <div class="mb-3">
                                                <input class="form-control form-control-user" type="password"
                                                       placeholder="Password" name="password" required="">
                                            </div>
                                            <!-- Start: Error Message -->
                                            <div class="text-center" id="login-error"
                                                 style="color: var(--accent-color3)"><?=$errMessage ?></div>
                                            <div class="row mb-3">
                                                <p id="errorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                            </div><!-- End: Error Message -->

                                            <button
                                                    class="btn btn-primary d-block btn-user w-100" id="submitBtn"
                                                    name="submit" type="submit">Login
                                            </button>
                                            <hr>
                                        </form><!-- End: Login Form --><!-- Start: Forgot Password -->
                                        <div class="text-center"><a class="small" href="forgot-password.html">Forgot
                                                Password?</a></div><!-- End: Forgot Password -->
                                        <!-- Start: Register -->
                                        <div class="text-center"><a class="small" href="register.html">Create an
                                                Account!</a></div><!-- End: Register -->
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

<!-- ====== Script files ===== -->
<script src="assests/js/home.js"></script>
<script>
    let email = document.getElementById("email")
    let submitBtn = document.getElementById("submitBtn")
    let errorMsg = document.getElementById('errorMsg')

    function displayErrorMsg(e) {
        errorMsg.style.display = "block"
        errorMsg.innerHTML = e
        submitBtn.disabled = true
    }

    function hideErrorMsg() {
        errorMsg.style.display = "none"
        submitBtn.disabled = false
    }

    // Validate email upon change
    email.addEventListener("change", function () {
        // Check if the email is valid using a regular expression (string@string.string)
        if (email.value.match(/^[^@]+@[^@]+\.[^@]+$/))
            hideErrorMsg()
        else
            displayErrorMsg("Invalid email")
    });
</script>

</body>

</html>