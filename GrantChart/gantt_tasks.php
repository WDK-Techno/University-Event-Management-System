<?php
session_start();


require_once '_db.php';

class Task
{
}

$result = tasklist($db, db_get_tasks(null));

header('Content-Type: application/json');
echo json_encode($result);

function tasklist($db, $items)
{
  $projectIDFromSession = $_SESSION['project_id'];
  $result = array();

  foreach ($items as $item) {
    $r = new Task();

    // rows
    $r->id = $item['main_task_id'];
    $r->text = htmlspecialchars($item['main_task_name']);
    $r->start = $item['start_date'];
    $r->end = $item['end_date'];
    $r->complete = intval($item['complete']);
//      if ($item['milestone']) {
//          $r->type = 'Milestone';
//      }

//      $parent = $r->id;

//      $children = db_get_tasks($parent);
//
//      if (!empty($children)) {
//          $r->children = tasklist($db, $children);
//      }
    if ($item['project_id'] == $projectIDFromSession){
      $result[] = $r;
    }
  }
  return $result;
}
