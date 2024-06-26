<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home Page</title>
    <!-- ====== CSS Files ==== -->
   <link rel="stylesheet" href="../assets/css/ug&club_signup.css">
    <link rel="stylesheet" href="../assets/css/style.css">

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
            <a class="navbar-brand text-primary" href="index.html">UWU<span class="text-dark">Event</span><span
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
                <div class="d-flex">
                    <a href="../register.php" class="text-decoration-none">
                        <button class="btn btn-outline-secondary d-flex align-items-center" type="submit"><Span
                                    class="d-none d-lg-inline pe-2">SignUp</Span>
                            <ion-icon style="font-size: 1.0rem;;"
                            " name="person-add-outline"></ion-icon></button>
                    </a>
                    <a href="../login.php" class="text-decoration-none">
                        <button class="btn btn-outline-primary ms-2 d-flex align-items-center" type="submit"><Span
                                    class="d-none d-lg-inline-block pe-2">LogIn</Span>
                            <ion-icon style="font-size: 1.5rem;" name="log-in-outline"></ion-icon>
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ======= Main Content ====== -->
    <div class="w-100" style="height: 100vh;">

        <!-- Start: Ludens - Register -->
        <div class="container"
             style="position:absolute; left:0; right:0; top: 55%; transform: translateY(-50%); -ms-transform: translateY(-50%); -moz-transform: translateY(-50%); -webkit-transform: translateY(-50%); -o-transform: translateY(-50%);">
            <div class="row d-flex d-xl-flex justify-content-center justify-content-xl-center">
                <div class="col-sm-7 col-lg-6 col-xl-6 col-xxl-4 bg-white shadow-lg" style="border-radius: 5px;">
                    <div class="p-5">
                        <div class="text-center">
                            <h4 class="text-dark mb-4">Club/Society</h4>
                        </div>

                        <!-- Start: Register Form -->
                        <form action="../process/signup/reg_club.php" method="post" class="user" enctype="multipart/form-data">
                            <!-- Start: Username -->

                            <!-- Start: Email -->
                            <div class="mb-3">
                                <input name="username" class="form-control form-control-user" type="email" id="email"
                                       placeholder="Email Address" required="">
                            </div>
                            <!-- End: Email --><!-- Start: Password -->
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input name="password" class="form-control form-control-user"
                                           type="password" id="password" placeholder="Password" required="">
                                </div>
                                <div class="col-sm-6">
                                    <input class="form-control form-control-user" type="password"
                                           id="verifyPassword" placeholder="Repeat Password" required="">
                                </div>
                            </div><!-- End: Password -->
                            <!-- Start: Names -->
                            <div class="row mb-3">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input name="club_name" class="form-control form-control-user" type="text"
                                           placeholder="Club Name" required="">
                                </div>

                            </div><!-- End: Names -->
                            <!-- Start: Contact No -->
                            <div class="row mb-3">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input name="contact_no" class="form-control form-control-user" type="text"
                                           placeholder="Contact Number" required="">
                                </div>

                            </div><!-- End: Contact No -->

                            <!-- Start: File Upload -->
                           <div class="mb-3">
                            <label for="pdfFile" class="form-label">Upload PDF File:</label>
                            <input type="file"  id="pdfFile" name="pdfFile">
                            </div>

                         <!-- End: File Upload -->

                            

                            


                            <!-- Start: Email Error Message -->
                            <div class="row mb-3">
                                <p id="emailErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                                <p id="passwordErrorMsg" class="text-danger" style="display:none;">Paragraph</p>
                            </div><!-- End: Email Error Message -->
                            <button class="btn btn-primary d-block btn-user w-100" style=" background-color: #339363;"
                                    id="submitBtn" name="submit" type="submit"> Register
                            </button>
                            <hr>
                        </form>
                        <!-- End: Register Form --><!-- Start: Forgot Password -->

                        <div class="text-center"><a class="small" href="../login.php">Already have an account?
                                Login!</a>
                        </div><!-- End: Login -->
                    </div>
                </div>
            </div>

        </div><!-- End: Ludens - Register -->
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

<script>
    let email = document.getElementById("email")
    let password = document.getElementById("password")
    let verifyPassword = document.getElementById("verifyPassword")
    let submitBtn = document.getElementById("submitBtn")
    let emailErrorMsg = document.getElementById('emailErrorMsg')
    let passwordErrorMsg = document.getElementById('passwordErrorMsg')

    function displayErrorMsg(type, msg) {
        if (type == "email") {
            emailErrorMsg.style.display = "block"
            emailErrorMsg.innerHTML = msg
            submitBtn.disabled = true
        } else {
            passwordErrorMsg.style.display = "block"
            passwordErrorMsg.innerHTML = msg
            submitBtn.disabled = true
        }
    }

    function hideErrorMsg(type) {
        if (type == "email") {
            emailErrorMsg.style.display = "none"
            emailErrorMsg.innerHTML = ""
            submitBtn.disabled = true
            if (passwordErrorMsg.innerHTML == "")
                submitBtn.disabled = false
        } else {
            passwordErrorMsg.style.display = "none"
            passwordErrorMsg.innerHTML = ""
            if (emailErrorMsg.innerHTML == "")
                submitBtn.disabled = false
        }
    }

    // Validate password upon change
    password.addEventListener("change", function () {

        // If password has no value, then it won't be changed and no error will be displayed
        if (password.value.length == 0 && verifyPassword.value.length == 0) hideErrorMsg("password")

        // If password has a value, then it will be checked. In this case the passwords don't match
        else if (password.value !== verifyPassword.value) displayErrorMsg("password", "Passwords do not match")

        // When the passwords match, we check the length
        else {
            // Check if the password has 8 characters or more
            if (password.value.length >= 8)
                hideErrorMsg("password")
            else
                displayErrorMsg("password", "Password must be at least 8 characters long")
        }
    })

    verifyPassword.addEventListener("change", function () {
        if (password.value !== verifyPassword.value)
            displayErrorMsg("password", "Passwords do not match")
        else {
            // Check if the password has 8 characters or more
            if (password.value.length >= 8)
                hideErrorMsg("password")
            else
                displayErrorMsg("password", "Password must be at least 8 characters long")
        }
    })

    // Validate email upon change
    email.addEventListener("change", function () {
        // Check if the email is valid using a regular expression (string@string.string)
        if (email.value.match(/^[^@]+@[^@]+\.[^@]+$/))
            hideErrorMsg("email")
        else
            displayErrorMsg("email", "Invalid email")
    });
</script>

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