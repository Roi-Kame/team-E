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

$file_id = $_POST['file-id'];
$task_name = $_POST['task-name'];
$task_kigen = $_POST['task-kigen'];
$tantou = $_POST['tantou'];
$status = $_POST['status'];
$yuusen = $_POST['yuusen'];

$fp = fopen($filename, 'r');
$cnt = 0;
$task_name_lst = [];
while ($record = fgetcsv($fp)) {
  if($cnt !== 0){
    $task_name_lst[] = $record[2];
    }
  $cnt++;
}

if(in_array($task_name, $task_name_lst)){
  header("Location:task.php?file_id=$file_id&error=duplicate");
  exit;
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

var_dump($record);

$fp = fopen($filename, 'a');


if (flock($fp, LOCK_EX)) {
  fputcsv($fp,$record);
  flock($fp,LOCK_UN);
}else{
  echo 'ファイルロックが失敗しました。';
}

fclose($fp);

header("location:task.php?file_id=$file_id");