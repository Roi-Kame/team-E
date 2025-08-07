<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>最初の画面</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<?php
$st = $_GET['search-text'];
// echo $st;

// ファイル名で検索
if ($st == "") {
    header('location:index.php');
}
$filename_file = './data/file.csv';

$fp_file = fopen($filename_file, 'r');

$all_file_records = [];

$cnt = 0;
while ($record = fgetcsv($fp_file)) {
    if ($cnt !== 0) {
        $all_file_records[] = $record;
    }
    $cnt++;
    $cnt++;
}
fclose($fp_file);

$filename_task = './data/task.csv';

$fp_task = fopen($filename_task, 'r');

$all_task_records = [];
$cnt = 0;
while ($record = fgetcsv($fp_task)) {
    if ($cnt !== 0) {
        $all_task_records[] = $record;
    }
    $cnt++;
}
fclose($fp_task);

$search_file_records = [];
$search_task_records = [];

foreach ($all_file_records as $record) {
    if (str_contains($record[1], $st) && $record[3] == 'false') {
        $search_file_records[] = [$record[0], $record[1]];
    }
}

foreach ($all_task_records as $record) {
    if ((str_contains($record[2], $st) && $record[8] == 'false') or  (str_contains($record[3], $st) && $record[8] == 'false') or (str_contains($record[5], $st) && $record[8] == 'false') or (str_contains($record[6], $st) && $record[8] == 'false')) {
        $search_task_records[] = [$record[0], $record[1]];
    }
}

// var_dump($search_file_records);
// var_dump($search_task_records);

?>

<body>
    <main class="main">
        <article class="article">
            <header class="page-header wrapper">
                <h1>ファイル未選択</h1>
                <nav>
                    <ul class="header-nav">
                        <a href="login.php">
                            <li>メンバー登録</li>
                        </a>
                        <a href="./member_list.php">
                            <li>メンバーリスト</li>
                        </a>
                    </ul>
                </nav>
            </header>
            <section class="file-content">
                <!-- **ここからファイル未選択時の右側（あとでコメントアウト）** -->
                <p>ファイルを選択してください</p>
            </section>
        </article>
        <!-- ファイル一覧表示 ------------------------------------------------------------ -->
        <aside class="aside">
            <div class="file-box">
                <section class="file-search">
                    <form action="./search.php" method="GET">
                        <input type="text" name="search-text" id="search-text" placeholder="🔍ファイル名検索">
                    </form>
                </section>
                <section class="file-create">
                    <form action="./file_create.php">
                        <button type="submit">
                            <img src="img/file-create.png" alt="作成">
                        </button>
                    </form>
                </section>
            </div>
            <section class="file-list">
                <?php

                if (empty($search_file_records) && empty($search_task_records)): ?>
                    <p>条件に一致するファイルはありません</p>
                    <?php elseif (!empty($search_file_records) && empty($search_task_records)):
                    foreach ($search_file_records as $record): ?>
                        <div class="file-list-item">
                            <a href="./task.php?file_id=<?php echo $record[0] ?>">
                                <ul>
                                    <li><?php echo $record[1] ?></li>

                                    <form action="./file_delete.php" method="GET">
                                        <input type="hidden" name="id" value="<?php echo $record[0] ?>">
                                        <input type="submit" value="削除">
                                    </form>
                                </ul>
                            </a>
                        </div>
                    <?php
                    endforeach;
                elseif (empty($search_file_records) && !empty($search_task_records)):
                    foreach ($search_task_records as $record): 
                        $fp_file = fopen($filename_file, "r");?>
                    foreach ($search_task_records as $record):
                        $fp = fopen($filename_file, 'r'); ?>
                        <div class="file-list-item">
                            <a href="./task.php?file_id=<?php echo $record[0] ?>">
                                <ul>
                                    <li><?php
                                        while ($file_line = fgetcsv($fp_file)) {
                                            if ($record[0] == $file_line[0]) {
                                                echo $file_line[1];
                                            }
                                        } ?></li>

                                    <form action="./file_delete.php" method="GET">
                                        <input type="hidden" name="id" value="<?php echo $record[0] ?>">
                                        <input type="submit" value="削除">
                                    </form>
                                </ul>
                            </a>
                        </div>
                    <?php
                    fclose($fp_file);
                    endforeach;
                elseif (!empty($search_file_records) && !empty($search_task_records)):
                    foreach ($search_file_records as $record): ?>
                        <div class="file-list-item">
                            <a href="./task.php?file_id=<?php echo $record[0] ?>">
                                <ul>
                                    <li><?php echo $record[1] ?></li>

                                    <form action="./file_delete.php" method="GET">
                                        <input type="hidden" name="id" value="<?php echo $record[0] ?>">
                                        <input type="submit" value="削除">
                                    </form>
                                </ul>
                            </a>
                        </div>
                    <?php
                    endforeach;
                    foreach ($search_task_records as $record): 
                        $fp_file = fopen($filename_file, "r");?>
                        <div class="file-list-item">
                            <a href="./task.php?file_id=<?php echo $record[0] ?>">
                                <ul>
                                    <li><?php
                                        while ($file_line = fgetcsv($fp_file)) {
                                            if ($record[0] == $file_line[0]) {
                                                echo $file_line[1];
                                            }
                                        } ?></li>

                                    <form action="./file_delete.php" method="GET">
                                        <input type="hidden" name="id" value="<?php echo $record[0] ?>">
                                        <input type="submit" value="削除">
                                    </form>
                                </ul>
                            </a>
                        </div>
                <?php
                    fclose($fp_fiile);
                    endforeach;
                endif; ?>
            </section>
        </aside>
    </main>
</body>

</html>