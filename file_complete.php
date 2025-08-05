<?php
date_default_timezone_set('Asia/Tokyo');

$filename = './data/file.csv';

$date = date('Y-m-d');

$fp = fopen($filename, 'r');
$cnt = 0;
$file_name_lst = [];
while ($records = fgetcsv($fp)) {
  if($cnt !== 0){
    $file_name_lst[] = $records[1];
  }
  $cnt++;
}
fclose($fp);
// var_dump($file_name_lst);
$id = $cnt;

$file_name = $_POST['file-name'];

if(in_array($file_name, $file_name_lst)){
  header('Location: file_create.php?error=duplicate');
  exit;
}

$record = [
    $id,
    $file_name,
    $date,
    'false'
];

$fp = fopen($filename, 'a');

// ファイロックをかける
if (flock($fp, LOCK_EX)) {
  // ファイル操作を実行する
  // CSVファイルに一行書き込む
  fputcsv($fp,$record);
  // ロック解除
  flock($fp,LOCK_UN);
}else{
  echo 'ファイルロックが失敗しました。';
}

fclose($fp);

header('location:index.php');
