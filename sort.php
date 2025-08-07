<?php
$filename = "./data/task.csv";
$fp = fopen($filename, 'r');

$sort = $_POST['sort'];
$tasks = [];
// タスクを取得して$tasksに格納
while ($record = fgetcsv($fp)) {
    $tasks[] = $record;
}

fclose($fp);

switch ($sort) {
        // 期限順の並び替え
        case "期限順":
            usort($status,function($a,$b){
                return strtotime(&a[4]) - strtotime($b[4]);
            });
            break;
        // 進捗順の並び替え
        case "進捗順":
            $priority = ["低" => 1, "中" => 2, "高" => 3];
            usort($status, function($a,$b) use ($priority){
                return $priority[$b[6]] - $priority[$a[6]];
            });
        // 優先度順の並び替え

}
