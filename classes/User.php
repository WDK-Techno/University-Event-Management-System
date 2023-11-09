<?php

namespace classes;

use PDOException;

class User
{
    protected $user_id;
    protected $username;
    protected $password;

    protected $role;
    protected $status;


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

    public function getUserIDFromUsername($con)
    {
        try {
            $query = "SELECT * FROM user WHERE user_name = ? AND role = ? AND status <> ?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->username);
            $pstmt->bindValue(2, $this->role);
            $pstmt->bindValue(3, "delete");
            $pstmt->execute();
            $rs = $pstmt->fetch(\PDO::FETCH_OBJ);
            return $rs->user_id;

        } catch (PDOException $exc) {
            die("Error in loading userID From Database " . $exc->getMessage());
        }
    }

    public function authenticate($con)
    {
        try {
            $query = "SELECT * FROM user WHERE user_name = ? AND status <> ?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->username);
            $pstmt->bindValue(2, "delete");
            $pstmt->execute();
            $rs = $pstmt->fetch(\PDO::FETCH_OBJ);
            if (!empty($rs)) {
                $db_password = $rs->password;
                if (password_verify($this->password, $db_password)) {
                    $this->user_id = $rs->user_id;
                    $this->username = $rs->user_name;
                    $this->password = null;
                    $this->role = $rs->role;
                    $this->status = $rs->status;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }

        } catch (PDOException $exc) {
            die("Error in user Authentication " . $exc->getMessage());
        }
    }

    public function saveUserChangesToDataBase($con)
    {
        $query = "UPDATE user SET password=?,status=? WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->password);
        $pstmt->bindValue(2, $this->status);
        $pstmt->bindValue(3, $this->user_id);
        $pstmt->execute();

        return $pstmt->rowCount() > 0;
    }

}

class Undergraduate extends User
{
    private $firstName;
    private $lastName;
    private $contactNo;
    private $profileImg;

    public function getFirstName()
    {
        return $this->firstName;
    }


    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }


    public function getLastName()
    {
        return $this->lastName;
    }


    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getContactNo()
    {
        return $this->contactNo;
    }


    public function setContactNo($contactNo)
    {
        $this->contactNo = $contactNo;
    }

    public function getProfileImg()
    {
        return $this->profileImg;
    }

    public function setProfileImg($profileImg)
    {
        $this->profileImg = $profileImg;
    }


    public function __construct($usrname, $password, $firstName, $lastName, $contactNo, $profileImg)
    {
        parent::__construct($usrname, $password);

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->contactNo = $contactNo;
        $this->profileImg = $profileImg;
//        === parent class ======
        $this->role = "ug";
        $this->status = "active";
    }

    public function register($con)
    {
        try {

            $findDuplicate = parent::checkDuplicateEmail($con); //check duplicate
            if (!$findDuplicate) {
                $query1 = "INSERT INTO user (user_name,password,role,status) VALUES (?,?,?,?)";
                $pstmt = $con->prepare($query1);
                $pstmt->bindValue(1, $this->username);
                $pstmt->bindValue(2, $this->password);
                $pstmt->bindValue(3, $this->role);
                $pstmt->bindValue(4, $this->status);
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

    public function loadDataFromUserID($con)
    {
        $query = "SELECT * FROM undergraduate INNER JOIN user ON undergraduate.user_id = user.user_id WHERE user.user_id =?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->user_id);
        $pstmt->execute();
        $rs = $pstmt->fetch(\PDO::FETCH_OBJ);
        if (!empty($rs)) {
            $this->username = $rs->user_name;
            $this->role = $rs->role;
            $this->status = $rs->status;
            $this->firstName = $rs->first_name;
            $this->lastName = $rs->last_name;
            $this->contactNo = $rs->contact_no;
            $this->profileImg = $rs->profile_image;
            return true;
        } else {
            return false;
        }
    }

    public function saveChangesToDatabase($con)
    {
        $query = "UPDATE undergraduate SET first_name=?,last_name=?,
                         contact_no=?,profile_image=? WHERE user_id=?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->firstName);
        $pstmt->bindValue(2, $this->lastName);
        $pstmt->bindValue(3, $this->contactNo);
        $pstmt->bindValue(4, $this->profileImg);
        $pstmt->bindValue(5, $this->user_id);
        $pstmt->execute();

        return $pstmt->rowCount() > 0;

    }

    public function getUndergraduates($con){
        $query = "SELECT u.user_id,u.user_name,ug.first_name,ug.last_name,ug.contact_no,ug.profile_image,u.status FROM user u JOIN undergraduate ug ON u.user_id = ug.user_id";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(\PDO::FETCH_OBJ);
        return $rs;
    }


}

class Club extends User
{
    private $clubName;
    private $contactNo;
    private $registerDate;
    private $profileImage;

    private $clubDescription;


    public function getClubName()
    {
        return $this->clubName;
    }


    public function setClubName($clubName)
    {
        $this->clubName = $clubName;
    }


    public function getContactNo()
    {
        return $this->contactNo;
    }


    public function setContactNo($contactNo)
    {
        $this->contactNo = $contactNo;
    }

    /**
     * @return mixed
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * @param mixed $registerDate
     */
    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;
    }

    public function getProfileImage()
    {
        return $this->profileImage;
    }

    public function setProfileImage($profileImage)
    {
        $this->profileImage = $profileImage;
    }

    /**
     * @return mixed
     */
    public function getClubDescription()
    {
        return $this->clubDescription;
    }

    /**
     * @param mixed $clubDescription
     */
    public function setClubDescription($clubDescription)
    {
        $this->clubDescription = $clubDescription;
    }


    public function __construct($usrname, $password, $clubName, $contactNo)
    {
        parent::__construct($usrname, $password);

        $this->clubName = $clubName;
        $this->contactNo = $contactNo;
        $this->role = "club";
        $this->status = "new";
    }

    public function registerClub($con)
    {
        $findDuplicate = parent::checkDuplicateEmail($con); //check duplicate
        if (!$findDuplicate) {
            try {
                $query1 = "INSERT INTO user (user_name,password,role,status) VALUES (?,?,?,?)";
                $pstmt = $con->prepare($query1);
                $pstmt->bindValue(1, $this->username);
                $pstmt->bindValue(2, $this->password);
                $pstmt->bindValue(3, $this->role);
                $pstmt->bindValue(4, $this->status);
                $pstmt->execute();

                if ($pstmt->rowCount() > 0) {
                    $regID = $con->lastInsertId();
                    $this->user_id = $regID;

                    $query2 = "INSERT INTO club (user_id,name,contact_no) VALUES (?,?,?)";
                    $pstmt2 = $con->prepare($query2);
                    $pstmt2->bindValue(1, $regID);
                    $pstmt2->bindValue(2, $this->clubName);
                    $pstmt2->bindValue(3, $this->contactNo);
                    $pstmt2->execute();

                    return $pstmt2->rowCount() > 0;
                } else {
                    return false;
                }
            } catch (PDOException $exc) {
                die("Error in Club Registraion " . $exc->getMessage());
            }
        } else {
            return false;
        }
    }

    public function loadDataFromUserID($con)
    {

        $query = "SELECT * FROM club INNER JOIN user ON club.user_id = user.user_id WHERE user.user_id =?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->user_id);
        $pstmt->execute();
        $rs = $pstmt->fetch(\PDO::FETCH_OBJ);
        if (!empty($rs)) {
            $this->username = $rs->user_name;
            $this->role = $rs->role;
            $this->status = $rs->status;
            $this->clubName = $rs->name;
            $this->contactNo = $rs->contact_no;
            $this->registerDate = $rs->register_date;
            $this->profileImage = $rs->profile_image;
            $this->clubDescription = $rs->description;

            return true;
        } else {
            return false;
        }
    }

    public function saveChangesToDatabase($con)
    {
        try {

            $query = "UPDATE club SET name=?,contact_no=?,profile_image=? ,description=? WHERE user_id=?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->clubName);
            $pstmt->bindValue(2, $this->contactNo);
            $pstmt->bindValue(3, $this->profileImage);
            $pstmt->bindValue(4, $this->clubDescription);
            $pstmt->bindValue(5, $this->user_id);
            $pstmt->execute();

            return $pstmt->rowCount() > 0;

        } catch (PDOException $exc) {
            die("Error in update data to DB " . $exc->getMessage());
        }
    }

    public function getClubs($con){
        $query = "SELECT u.user_id,u.user_name,club.name,club.contact_no,u.status,club.profile_image,club.description FROM user u JOIN club club ON u.user_id = club.user_id WHERE status = 'active' || status = 'deactive' ";
        $pstmt = $con->prepare($query);
        $pstmt->execute();
        $rs = $pstmt->fetchAll(\PDO::FETCH_OBJ);
        return $rs;
    }

    public function getRequests($con){
    $query = "SELECT u.user_id,u.user_name,club.name,club.contact_no,club.register_date FROM user u JOIN club club ON u.user_id = club.user_id WHERE status = 'new'";
    $pstmt = $con->prepare($query);
    $pstmt->execute();
    $rs = $pstmt->fetchAll(\PDO::FETCH_OBJ);
    return $rs;
    }

    public function getRowCount($con){
    $query = "SELECT * FROM user u JOIN club club ON u.user_id = club.user_id WHERE status = 'new'";
    $pstmt = $con->prepare($query);
    $pstmt->execute();
    $rs = $pstmt->fetchAll(\PDO::FETCH_OBJ);
    $count = $pstmt->rowCount();
    return $count;
    }

    public function loadDataFromCategoryID($con)
    {

        $query = "SELECT * FROM club INNER JOIN user ON club.user_id = user.user_id WHERE user.user_id =?";
        $pstmt = $con->prepare($query);
        $pstmt->bindValue(1, $this->user_id);
        $pstmt->execute();
        $rs = $pstmt->fetch(\PDO::FETCH_OBJ);
        if (!empty($rs)) {
            $this->username = $rs->user_name;
            $this->role = $rs->role;
            $this->status = $rs->status;
            $this->clubName = $rs->name;
            $this->contactNo = $rs->contact_no;
            $this->registerDate = $rs->register_date;
            $this->profileImage = $rs->profile_image;
            $this->clubDescription = $rs->description;

            return true;
        } else {
            return false;
        }
    }


}