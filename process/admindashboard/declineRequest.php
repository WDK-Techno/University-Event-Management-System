<?php
require '../../core/init.php';

if (isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];
    $userObj->declineRequest($user_id);
    header("Location:../../superadmindashboard.php");
}