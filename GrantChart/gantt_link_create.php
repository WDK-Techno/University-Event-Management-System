<?php
//require_once '_db.php';
//
//$json = file_get_contents('php://input');
//$params = json_decode($json);
//
//$stmt = $db->prepare("INSERT INTO link (from_id, to_id, type) VALUES (:from, :to, :type)");
//$stmt->bindParam(':from', $params->from);
//$stmt->bindParam(':to', $params->to);
//$stmt->bindParam(':type', $params->type);
//$stmt->execute();
//
//class Result {}
//
//$response = new Result();
//$response->result = 'OK';
//$response->message = 'Created with id: '.$db->lastInsertId();
//$response->id = $db->lastInsertId();
//
//header('Content-Type: application/json');
//echo json_encode($response);
