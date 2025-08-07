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

if ($st == "") {
    header('location:index.php');
}
$filename = './data/file.csv';
$fp = fopen($filename, 'r');

$all_records = [];

while ($record = fgetcsv($fp)) {
    $all_records[] = $record;
}

$search_records = [];

foreach ($all_records as $record) {
    if (str_contains($record[1], $st) && $record[3] == 'false') {
        $search_records[] = [$record[0], $record[1]];
    }
}
// var_dump($search_records)
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
                $count = 0;

                if ($search_records == false): ?>
                    <p>条件に一致するファイルはありません</p>
                    <?php else:
                    foreach ($search_records as $record): ?>
                        <div class="file-list-item">
                            <a href="./task.php?file_id=<?php echo $record[0] ?>">
                                <ul>
                                    <li><?php echo $record[1] ?></li>

                                    <form action="./file_delete.php" method="GET">
                                        <input type="hidden" name="id" value="<?php echo $record[0] ?>">
                                        <input type="submit" value="消去">
                                    </form>
                                </ul>
                            </a>
                        </div>
                <?php
                        $count++;
                    endforeach;
                endif; ?>
            </section>
        </aside>
    </main>
</body>

</html>