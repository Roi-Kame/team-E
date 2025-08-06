<?php
date_default_timezone_set('Asia/Tokyo');

$filename = './data/task.csv';

$create_date = date('Y-m-d');

$fp = fopen($filename, 'r');
$cnt = 0;
while (fgetcsv($fp) !== false) {
  $cnt++;
}


fclose($fp);

$id = $cnt;

$crored = $_POST['create-or-edit'];
$file_id = $_POST['file-id'];
$task_id = $_POST['task-id'];
$task_name = $_POST['task-name'];
$task_kigen = $_POST['task-kigen'];
$tantou = $_POST['tantou'];
$status = $_POST['status'];
$yuusen = $_POST['yuusenn'];

$fp = fopen($filename, 'r');
$cnt = 0;
$task_name_lst = [];
$shoukyo_lst = [];

$all_task_date = [];
while ($record = fgetcsv($fp)) {
  if ($cnt !== 0 && $file_id == $record[0]) {
    $task_name_lst[] = $record[2];
    $shoukyo_lst[] = $record[8];
  }
  $cnt++;
}

if ($crored == "create") {
  if (in_array($task_name, $task_name_lst)) {
    $task_name_idx = array_search($task_name, $task_name_lst);
    if ($shoukyo_lst[$task_name_idx] == 'false') {
      header("Location:task.php?file_id=$file_id&error=duplicate");
      exit;
    }
  }

  $record = [
    $file_id,
    $id,
    $task_name,
    $tantou,
    $task_kigen,
    $status,
    $yuusen,
    $create_date,
    'false'
  ];

  // var_dump($record);
  fclose($fp);
  $fp = fopen($filename, 'a');

  if (flock($fp, LOCK_EX)) {
    fputcsv($fp, $record);
    flock($fp, LOCK_UN);
  } else {
    echo 'ファイルロックが失敗しました。';
  }

  fclose($fp);
} else {
  $fp = fopen($filename, "r");
  while ($record = fgetcsv($fp)) {
    if ($record[0] !== $file_id or $record[1] !== $task_id) {
        $all_task_date[] = $record;
    }
  }

  fclose($fp);

 foreach($all_task_date as $line){
  if($line[2] == $task_name){
      header("Location:task.php?file_id=$file_id&error=duplicate");
      exit;
    }
  }
 

  $fp = fopen($filename, 'w');

  $records = [
    $file_id,
    $task_id,
    $task_name,
    $tantou,
    $task_kigen,
    $status,
    $yuusen,
    $create_date,
    'false'
  ];

  if (flock($fp, LOCK_EX)) {
    foreach ($all_task_date as $record) {
      fputcsv($fp, $record);
    }
    fputcsv($fp, $records);
    flock($fp, LOCK_UN);
  } else {
    echo 'ファイルロックが失敗しました。';
  }

  fclose($fp);
}

header("location:task.php?file_id=$file_id");
