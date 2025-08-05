<!-- ファイル消去 -->
<?php
$id = $_GET['id'];
$filename = './data/file.csv';
$fp = fopen($filename, 'r');
$all_records = [];
while ($record = fgetcsv($fp)) {
    $all_records[] = $record;
}
$result = [];
foreach ($all_records as $record) {
    if ($record[0] == $id) {
        $record[3] = 'true';
    }
    $result[] = $record;
}
$fp = fopen($filename, 'w');
foreach ($result as $record) {
    fputcsv($fp, $record);
}
header('location:index.php');
