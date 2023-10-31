<?php
require_once '_db.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$now = (new DateTime("now"))->format('Y-m-d H:i:s');
$ordinal = db_get_max_ordinal(null) + 1;

$stmt = $db->prepare("INSERT INTO main_task (main_task_name, start_date, end_date, ordinal, ordinal_priority,project_id) VALUES (?,?,?,?,?,?)");
$stmt->bindValue(1, $params->name);
$stmt->bindValue(2, $params->start);
$stmt->bindValue(3, $params->end);
$stmt->bindValue(4, $ordinal);
$stmt->bindValue(5, $now);
$stmt->bindValue(6,$params->project_id);
$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = 'Created with id: '.$db->lastInsertId();
$response->id = $db->lastInsertId();

header('Content-Type: application/json');
echo json_encode($response);
