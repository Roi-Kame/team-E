<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>最初の画面</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="page-header wrapper">
        <h1>ファイル名</h1>
        <nav>
            <ul class="header-nav">
                <li><a href="login.php">メンバー登録</a></li>
                <li><a href="">メンバー一覧</a></li>
            </ul>
        </nav>
    </header>
    <form action="./search.php" method="POST">
        <input type="text" name="file-name" id="file-name" placeholder="ファイル検索">
        <input type="submit" value="検索">
    </form>
    <form action="./file_create.php">
        <input type="submit" value="ファイル作成">
    </form>
    <div class="file_name">
        <?php
        $filename = './data/file.csv';

        $fp = fopen($filename, 'r');

        while ($record = fgetcsv($fp)): ?>
            <p><a href="./task.php?file_id=<?php echo $record[0] ?>"><?php echo $record[1] ?></a></p>
            <form action="./file_delete.php" method="POST">
                <input type="submit" value="消去">
            </form>
        <?php
        endwhile; ?>
    </div>

    <!-- ここまで左側 -->
    **ここからファイル未選択時の右側（あとでコメントアウト）**
    <p>ファイルを選択してください</p>
</body>

</html>