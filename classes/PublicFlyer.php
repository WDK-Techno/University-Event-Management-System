<?php

namespace classes;
use PDO;
use PDOException;
class PublicFlyer
{
    private $flyerID;
    private $startDate;
    private $endDate;
    private $caption;
    private $link;
    private $flyerImg;
    private $clubID;
    private $status;


    public function getFlyerID()
    {
        return $this->flyerID;
    }


    public function setFlyerID($flyerID)
    {
        $this->flyerID = $flyerID;
    }


    public function getStartDate()
    {
        return $this->startDate;
    }


    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }


    public function getEndDate()
    {
        return $this->endDate;
    }


    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }


    public function getCaption()
    {
        return $this->caption;
    }

    public function setCaption($caption)
    {
        $this->caption = $caption;
    }


    public function getLink()
    {
        return $this->link;
    }


    public function setLink($link)
    {
        $this->link = $link;
    }


    public function getFlyerImg()
    {
        return $this->flyerImg;
    }


    public function setFlyerImg($flyerImg)
    {
        $this->flyerImg = $flyerImg;
    }


    public function getClubID()
    {
        return $this->clubID;
    }


    public function setClubID($clubID)
    {
        $this->clubID = $clubID;
    }


    public function getStatus()
    {
        return $this->status;
    }


    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function __construct($flyerID,$startDate,$endDate,$caption,$link,$flyerImg,$clubID,$status)
    {
        $this->flyerID=$flyerID;
        $this->startDate=$startDate;
        $this->endDate=$endDate;
        $this->caption=$caption;
        $this->link=$link;
        $this->flyerImg=$flyerImg;
        $this->clubID=$clubID;
        $this->status=$status;

    }

    public function  addNewFlyer($con){

        try {
            $query= "INSERT INTO public_flyer(start_date,end_date,caption,link,flyer_image,club_id,status) VALUES(?,?,?,?,?,?,?)";
            $pstmt=$con->prepare($query);
            $pstmt->bindValue(1,$this->startDate);
            $pstmt->bindValue(2,$this->endDate);
            $pstmt->bindValue(3,$this->caption);
            $pstmt->bindValue(4,$this->link);
            $pstmt->bindValue(5,$this->flyerImg);
            $pstmt->bindValue(6,$this->clubID);
            $pstmt->bindValue(7,$this->status);
            $pstmt->execute();


            if($pstmt->rowCount() > 0){
                    $this->flyerID= $con->lastInsertId();
                    $this->loadFlyerFromFlyerID($con);
                return true;
            }else{
                return false;
            }


        }catch (PDOException $exc){
            die("Error in Flyer Adding" . $exc->getMessage());
        }

    }

    public function loadFlyerFromFlyerID($con){

        try {
            $query = "SELECT * FROM public_flyer WHERE flyer_id = ?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->flyerID);
            $pstmt->execute();

            $rs = $pstmt->fetch(PDO::FETCH_OBJ);
            if (!empty($rs)) {
                $this->flyerID = $rs->flyer_id;
                $this->startDate = $rs->start_date;
                $this->endDate = $rs->end_date;
                $this->caption=$rs->caption;
                $this->link=$rs->link;
                $this->flyerImg= $rs->flyer_image;
                $this->clubID=$rs->club_id;
                $this->status = $rs->status;
                return true;
            } else {
                return false;
            }


        } catch (PDOException $exc) {
            die("Error in Project details loading" . $exc->getMessage());
        }

    }

    public static function getFlyersListFromClubID($con,$clubID){
        $publicFlyers = array();

        try {
            $query = "SELECT * FROM public_flyer WHERE club_id=?";
            $pstmt=$con->prepare($query);
            $pstmt->bindValue(1, $clubID);
            $pstmt->execute();
            $result = $pstmt->fetchAll(PDO::FETCH_OBJ);

            if (!empty($result)) {
                foreach ($result as $use) {
                    $publicFlyer=new PublicFlyer($use->flyer_id,$use->start_date,
                    $use->end_date,$use->caption,$use->link,$use->flyer_image,
                        $use->club_id,$use->status);

                    $publicFlyers[]=$publicFlyer;
                }
            }
        }catch (PDOException $exc){
            die("Error in Database Loading" . $exc->getMessage());
        }
        return $publicFlyers;
    }

    public function saveChangesToDatabase($con){

    }

}