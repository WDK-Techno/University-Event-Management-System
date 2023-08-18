<?php

namespace classes;

use PDOException;

class User
{
    private $user_id;
    private $username;
    private $password;

    private $role;
    private $status;

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function setUsername($username)
    {
        $this->username = $username;
    }


    public function getPassword()
    {
        return $this->password;
    }


    public function setPassword($password)
    {
        $this->password = $password;
    }


    public function getRole()
    {
        return $this->role;
    }


    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }


    public function __construct($usrname, $password)
    {

        $this->username = $usrname;
        $this->password = $password;

    }

    public function checkDuplicateEmail($con)
    {

        $query = "SELECT * FROM user WHERE user_name = ? AND status <> ?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->username);
        $pstmt->bindValue(2, "delete");
        $pstmt->execute();
        $rowCount = $pstmt->rowCount();
        if ($rowCount > 0) {
            return true;
        } else {
            return false;
        }

    }


}

class Undergraduate extends User
{
    private $firstName;
    private $lastName;
    private $contactNo;

    public function __construct($usrname, $password, $firstName, $lastName, $contactNo)
    {
        parent::__construct($usrname, $password);

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->contactNo = $contactNo;
        parent::setRole("ug");
        parent::setStatus("active");
    }

    public function register($con)
    {
        try {

            $findDuplicate = parent::checkDuplicateEmail($con); //check duplicate
            if (!$findDuplicate) {
                $query1 = "INSERT INTO user (user_name,password,role,status) VALUES (?,?,?,?)";
                $pstmt = $con->prepare($query1);
                $pstmt->bindValue(1, parent::getUsername());
                $pstmt->bindValue(2, parent::getPassword());
                $pstmt->bindValue(3, parent::getRole());
                $pstmt->bindValue(4, parent::getStatus());
                $pstmt->execute();

                if ($pstmt->rowCount() > 0) {

                    $regID = $con->lastInsertId();
                    parent::setUserId($regID);

                    $query2 = "INSERT INTO undergraduate (user_id,first_name,last_name,contact_no) VALUES (?,?,?,?)";

                    $pstmt2 = $con->prepare($query2);
                    $pstmt2->bindValue(1, $regID);
                    $pstmt2->bindValue(2, $this->firstName);
                    $pstmt2->bindValue(3, $this->lastName);
                    $pstmt2->bindValue(4, $this->contactNo);

                    $pstmt2->execute();

                    if ($pstmt2->rowCount() > 0) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } catch (PDOException $exc) {
            die("Error in User Registration" . $exc->getMessage());
        }
    }

}

class Club extends User
{
    private $clubName;
    private $contactNo;
}