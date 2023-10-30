<?php

//$host = "localhost";
//$port = 3306;
//$username = "root";
//$password = "";
//$database = "gantt_test";
//
//$db = new PDO("mysql:host=$host;port=$port",
//               $username,
//               $password);
//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//$db->exec("CREATE DATABASE IF NOT EXISTS `$database`");
//$db->exec("use `$database`");

require_once "../classes/DBConnector.php";

use \classes\DbConnector;

$db = DbConnector::getConnection();

function tableExists($dbh, $id)
{
    $results = $dbh->query("SHOW TABLES LIKE '$id'");
    if(!$results) {
        return false;
    }
    if($results->rowCount() > 0) {
        return true;
    }
    return false;
}

//$exists = tableExists($db, "task");



//    $links = array(
//        array('from' => 1,
//            'to' => 3,
//            'type' => 'FinishToStart'),
//        array('from' => 1,
//            'to' => 6,
//            'type' => 'FinishToStart'),
//    );

//    $insert = "INSERT INTO link (from_id, to_id, type) VALUES (:from, :to, :type)";
//    $stmt = $db->prepare($insert);
//
//    $stmt->bindParam(':from', $from);
//    $stmt->bindParam(':to', $to);
//    $stmt->bindParam(':type', $type);
//
//    foreach ($links as $m) {
//        $from = $m['from'];
//        $to = $m['to'];
//        $type = $m['type'];
//        $stmt->execute();
//    }


date_default_timezone_set("UTC");

function db_get_max_ordinal($parent) {
    global $db;
    $str = "SELECT max(ordinal) FROM main_task WHERE parent_id = :parent";
    if ($parent == null) {
        $str = str_replace("= :parent", "is null", $str);
        $stmt = $db->prepare($str);
    }
    else {
        $stmt = $db->prepare($str);
        $stmt->bindParam(":parent", $parent);
    }
    $stmt->execute();
    return $stmt->fetchColumn(0) ?: 0;
}

function db_get_task($id) {
    global $db;

    $str = "SELECT * FROM main_task WHERE main_task_id = :id";
    $stmt = $db->prepare($str);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    return $stmt->fetch();
}

function db_update_task_parent($id, $parent, $ordinal) {
    global $db;

    $now = (new DateTime("now"))->format('Y-m-d H:i:s');

    $str = "UPDATE main_task SET parent_id = :parent, ordinal = :ordinal, ordinal_priority = :priority WHERE main_task_id = :id";
    $stmt = $db->prepare($str);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":parent", $parent);
    $stmt->bindParam(":ordinal", $ordinal);
    $stmt->bindParam(":priority", $now);
    $stmt->execute();
}

function db_compact_ordinals($parent) {
    $children = db_get_tasks($parent);
    $size = count($children);
    for ($i = 0; $i < $size; $i++) {
        $row = $children[$i];
        db_update_task_ordinal($row["id"], $i);
    }
}

function db_update_task_ordinal($id, $ordinal) {
    global $db;

    $now = (new DateTime("now"))->format('Y-m-d H:i:s');

    $str = "UPDATE main_task SET ordinal = :ordinal, ordinal_priority = :priority WHERE main_task_id = :id";
    $stmt = $db->prepare($str);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":ordinal", $ordinal);
    $stmt->bindParam(":priority", $now);
    $stmt->execute();
}

function db_update_task($id, $start, $end) {
    global $db;

    $str = "UPDATE main_task SET start_date = :start, end_date = :end WHERE main_task_id = :id";
    $stmt = $db->prepare($str);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":start", $start);
    $stmt->bindParam(":end", $end);
    $stmt->execute();
}

function db_update_task_full($id, $start, $end, $name, $complete) {
    global $db;

    $str = "UPDATE main_task SET start_date = :start, end_date = :end, main_task_name = :name, complete = :complete WHERE main_task_id = :id";
    $stmt = $db->prepare($str);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":start", $start);
    $stmt->bindParam(":end", $end);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":complete", $complete);
    $stmt->execute();
}

function db_get_tasks($parent) {
    global $db;

    $str = 'SELECT * FROM main_task WHERE parent_id = :parent ORDER BY ordinal, ordinal_priority desc';
    if ($parent == null) {
        $str = str_replace("= :parent", "is null", $str);
        $stmt = $db->prepare($str);
    }
    else {
        $stmt = $db->prepare($str);
        $stmt->bindParam(':parent', $parent);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}

?>
