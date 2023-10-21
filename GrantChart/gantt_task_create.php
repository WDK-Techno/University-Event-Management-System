<?php
require_once '_db.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$now = (new DateTime("now"))->format('Y-m-d H:i:s');
$ordinal = db_get_max_ordinal(null) + 1;

$stmt = $db->prepare("INSERT INTO task (name, start, end, ordinal, ordinal_priority) VALUES (:name, :start, :end, :ordinal, :priority)");
$stmt->bindParam(':name', $params->name);
$stmt->bindParam(':start', $params->start);
$stmt->bindParam(':end', $params->end);
$stmt->bindParam(":ordinal", $ordinal);
$stmt->bindParam(":priority", $now);
$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = 'Created with id: '.$db->lastInsertId();
$response->id = $db->lastInsertId();

header('Content-Type: application/json');
echo json_encode($response);
