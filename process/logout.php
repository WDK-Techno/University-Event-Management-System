<?php
session_start();

if (isset($_POST['submit1'])){

    unset($_SESSION["user_id"]);
    unset($_SESSION['role']);
    unset($_SESSION['profile_img']);

    session_destroy();

    header("location: ../login.php");
}

if (isset($_POST['submit2'])){

    unset($_SESSION["user_id"]);
    unset($_SESSION['role']);
    unset($_SESSION['profile_img']);
    unset($_SESSION['project_id']);

    session_destroy();

    header("location: ../login.php");
}
if (isset($_POST['submit3'])){

    unset($_SESSION['project_id']);

    header("location: ../clubowner-dashboard.php");
}
if (isset($_POST['submit4'])){

    unset($_SESSION['project_id']);

    header("location: ../");
}

