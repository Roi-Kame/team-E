<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>最初の画面</title>
</head>
<body>
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

        while ($record = fgetcsv($fp)):?>
        <p><a href="./task.php?file_id=<?php echo $record[0] ?>"><?php echo $record[1] ?></a></p>
        <form action="./file_delete.php" method="POST">
            <input type="submit" value="消去">
        </form>
        <?php
        endwhile;?>
    </div>

    <!-- ここまで左側 -->
    **ここからファイル未選択時の右側（あとでコメントアウト）**
     <p>ファイルを選択してください</p>
</body>
</html>