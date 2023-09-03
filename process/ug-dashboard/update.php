<?php

use classes\User;

require_once '../../classes/User.php';

if($_SERVER['REQUEST_METHOD']==="POST"){
    if(isset($_POST['submit'])){
        if(empty($_POST['first_name']) || empty($_POST['last_name']) || empty($_POST['contact_no']) || empty($_POST['ug_id'])){

        }else{
            $fname = $_POST['first_name'];
            $lname = $_POST['last_name'];
            $contact_no = $_POST['contact_no'];
            $ug_id = $_POST['ug_id'];

            $upadte = new User($fname,$lname,$contact_no);
            $upadte->saveChangesToDatabase($fname,$lname,$contact_no);

        }
    }
}