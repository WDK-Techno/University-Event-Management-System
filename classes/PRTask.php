<?php

namespace classes;

use PDO;
use PDOException;

class PRTask
{
    private $prID;
    private $isPublished;
    private $publishDate;
    private $topic;
    private $description;
    private $designerID;
    private $isDesignCompleted;
    private $captionWriterID;
    private $isCaptionCompleted;
    private $designCompletingDeadline;
    private $isVerifyByProjectChair;
    private $projectID;
    private $status;

    public function getprID()
    {
        return $this->prID;
    }

    public function setprID($prID)
    {
        $this->prID = $prID;
    }

    public function getisPublished()
    {
        return $this->isPublished;
    }

    public function setisPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    public function getpublishDate()
    {
        return $this->publishDate;
    }

    public function setpublishDate($publishDate)
    {
        $this->publishDate = $publishDate;
    }

    public function gettopic()
    {
        return $this->topic;
    }

    public function settopic($topic)
    {
        $this->topic = $topic;
    }

    public function getdescription()
    {
        return $this->description;
    }

    public function setdescription($description)
    {
        $this->description = $description;
    }

    public function getdesignerID()
    {
        return $this->designerID;
    }

    public function setdesignerID($designerID)
    {
        $this->designerID = $designerID;
    }

    public function getisDesignCompleted()
    {
        return $this->isDesignCompleted;
    }

    public function setisDesignCompleted($isDesignCompleted)
    {
        $this->isDesignCompleted = $isDesignCompleted;
    }

    public function getcaptionWriterID()
    {
        return $this->captionWriterID;
    }

    public function setcaptionWriterID($captionWriterID)
    {
        $this->captionWriterID = $captionWriterID;
    }

    public function getisCaptionCompleted()
    {
        return $this->isCaptionCompleted;
    }

    public function setisCaptionCompleted($isCaptionCompleted)
    {
        $this->isCaptionCompleted = $isCaptionCompleted;
    }

    public function getdesignCompletingDeadline()
    {
        return $this->designCompletingDeadline;
    }

    public function setdesignCompletingDeadline($designCompletingDeadline)
    {
        $this->designCompletingDeadline = $designCompletingDeadline;
    }

    public function getisVerifyByProjectChair()
    {
        return $this->isVerifyByProjectChair;
    }

    public function setisVerifyByProjectChair($isVerifyByProjectChair)
    {
        $this->isVerifyByProjectChair = $isVerifyByProjectChair;
    }

    public function getprojectID()
    {
        return $this->projectID;
    }

    public function setprojectID($projectID)
    {
        $this->projectID = $projectID;
    }

    public function getstatus()
    {
        return $this->status;
    }

    public function setstatus($status)
    {
        $this->status = $status;
    }

    public function __construct($prID, $publishDate, $topic, $description, $designerID, $captionWriterID, $projectID)
    {
        $this->prID = $prID;
        $this->publishDate = $publishDate;
        $this->topic = $topic;
        $this->description = $description;
        $this->designerID = $designerID;
        $this->captionWriterID = $captionWriterID;
        $this->projectID = $projectID;
    }

    public function addNewTask($con)
    {
        try {
            $query = "INSERT INTO pr_task (publish_date,topic,description,designer_id,caption_writer_id,design_deadline,project_id) VALUES (?,?,?,?,?,?,?)";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->publishDate);
            $pstmt->bindValue(2, $this->topic);
            $pstmt->bindValue(3, $this->description);
            $pstmt->bindValue(4, $this->designerID);
            $pstmt->bindValue(5, $this->captionWriterID);
            $pstmt->bindValue(6, $this->designCompletingDeadline);
            $pstmt->bindValue(7, $this->projectID);
            $pstmt->execute();

            if ($pstmt->rowCount() > 0) {
                $this->prID = $con->lastInsertId();
                return $this->loadTaskFromPRId($con);

            } else {
                return false;
            }
        } catch (PDOException $exc) {
            die("Error in Event Adding" . $exc->getMessage());
        }
    }

    public static function getTaskListFromProjectID($con, $project_id)
    {
        $PRTasks = array();
        try {
            $query = "SELECT * FROM pr_task WHERE status = 'active' AND project_id=? ORDER BY publish_date";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $project_id);
            $pstmt->execute();
            $rs = $pstmt->fetchAll(PDO::FETCH_OBJ);
            if (!empty($rs)) {
                foreach ($rs as $row) {
                    $PRTask = new PRTask($row->pr_id, $row->publish_date, $row->topic,
                        $row->description, $row->designer_id, $row->caption_writer_id, $row->project_id);
                    $PRTasks[] = $PRTask;
                }
            }
        } catch (PDOException $exc) {
            die("Error in Database Loading" . $exc->getMessage());
        }
        return $PRTasks;
    }

    public function loadTaskFromPRId($con)
    {
        try {
            $query = "SELECT * FROM pr_task WHERE  pr_id = ?";
            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->prID);
            $pstmt->execute();

            $rs = $pstmt->fetch(PDO::FETCH_OBJ);
            if (!empty($rs)) {
                $this->prID = $rs->pr_id;
                $this->isPublished = $rs->published;
                $this->publishDate = $rs->publish_date;
                $this->topic = $rs->topic;
                $this->description = $rs->description;
                $this->designerID = $rs->designer_id;
                $this->isDesignCompleted = $rs->design_complete;
                $this->captionWriterID = $rs->caption_writer_id;
                $this->isCaptionCompleted = $rs->caption_complete;
                $this->designCompletingDeadline = $rs->design_deadline;
                $this->isVerifyByProjectChair = $rs->project_chair_verify;
                $this->projectID = $rs->project_id;
                $this->status = $rs->status;

                return true;
            } else {
                return false;
            }
        } catch (PDOException $exc) {
            die("Error in Event details loading" . $exc->getMessage());
        }
    }

    public function saveChangesToDatabase($con)
    {
        try {
            $query = "UPDATE pr_task SET published=?,publish_date=?,topic=?,description=?,designer_id=?,
                   design_complete=?,caption_writer_id=?,caption_complete=?,design_deadline=?,
                   project_chair_verify=?,
                   project_id=?,status=? WHERE pr_id=?";

            $pstmt = $con->prepare($query);
            $pstmt->bindValue(1, $this->isPublished);
            $pstmt->bindValue(2, $this->publishDate);
            $pstmt->bindValue(3, $this->topic);
            $pstmt->bindValue(4, $this->description);
            $pstmt->bindValue(5, $this->designerID);
            $pstmt->bindValue(6, $this->isDesignCompleted);
            $pstmt->bindValue(7, $this->captionWriterID);
            $pstmt->bindValue(8, $this->isCaptionCompleted);
            $pstmt->bindValue(9, $this->designCompletingDeadline);
            $pstmt->bindValue(10, $this->isVerifyByProjectChair);
            $pstmt->bindValue(11, $this->projectID);
            $pstmt->bindValue(12, $this->status);
            $pstmt->bindValue(13, $this->prID);
            $pstmt->execute();

            return $pstmt->rowCount() > 0;

        } catch (PDOException $exc) {
            die("Error in PR Table save changes " . $exc->getMessage());
        }
    }

}