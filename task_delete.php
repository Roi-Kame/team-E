<!-- タスク消去 -->
<?php
$task_id = $_GET['task_id'];
$file_id = $_GET['file_id'];

$filename = './data/task.csv';
$fp = fopen($filename, 'r');
$all_records = [];
while ($record = fgetcsv($fp)) {
    $all_records[] = $record;
}
fclose($fp);

$result = [];

foreach ($all_records as $record) {
    if ($record[0] == $file_id && $record[1] == $task_id) {
        $record[8] = 'true';
    }
    $result[] = $record;
}
$fp = fopen($filename, 'w');
foreach ($result as $record) {
    fputcsv($fp, $record);
}
fclose($fp);

header("location:task.php?file_id=$file_id");
