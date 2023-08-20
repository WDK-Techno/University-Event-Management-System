<?php

namespace classes;

class TeamMember
{
    private $categoryID;
    private $ugID;


    public function __construct($categoryID, $ugID)
    {
        $this->categoryID = $categoryID;
        $this->ugID = $ugID;
    }


    public function getCategoryID()
    {
        return $this->categoryID;
    }


    public function setCategoryID($categoryID)
    {
        $this->categoryID = $categoryID;
    }


    public function getUgID()
    {
        return $this->ugID;
    }


    public function setUgID($ugID)
    {
        $this->ugID = $ugID;
    }



}