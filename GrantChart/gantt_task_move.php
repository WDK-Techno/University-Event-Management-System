<?php
require_once '_db.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

db_update_task($params->id, $params->start, $params->end);

class Result {}

$response = new Result();
$response->result = 'OK';

header('Content-Type: application/json');
echo json_encode($response);
