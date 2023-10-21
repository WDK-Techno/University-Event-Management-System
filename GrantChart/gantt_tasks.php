<?php
require_once '_db.php';

class Task {}

$result = tasklist($db,db_get_tasks(null));

header('Content-Type: application/json');
echo json_encode($result);

function tasklist($db,$items) {
    $result = array();

    foreach($items as $item) {
      $r = new Task();

      // rows
      $r->id = $item['id'];
      $r->text = htmlspecialchars($item['name']);
      $r->start = $item['start'];
      $r->end = $item['end'];
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

      $result[] = $r;
    }
    return $result;
}
