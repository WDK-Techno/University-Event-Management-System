<?php

class User
{
    private $user_id;
    private $username;
    private $password;

    private $role;
    private $status;
    public function __construct($usrname, $password)
    {

        $this->username = $usrname;
        $this->password = $password;

    }



}
class Undergraduate extends User {
    private $firstName;
    private $lastName;
    private $contactNo;
}

class Club extends User{
    private $clubName;
    private $contactNo;
}