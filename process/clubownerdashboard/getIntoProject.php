<?php
session_start();

if (isset($_POST['submit'])){
    $proectID = $_POST["project_id"];

    $_SESSION['project_id'] = $proectID;

    header("location: ../../projectdashboard.php");

}
