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

        while ($record = fgetcsv($fp)):?>
        <p><a href="./task.php?file_id=<?php $record[0] ?>"><?php echo $record[1] ?></a></p>
        <form action="./file_delete.php" method="POST">
            <input type="submit" value="消去">
        </form>
        <?php
        endwhile;?>
    </div>

    **ここまで左側**<br>
    **ここからタスク管理**
    <form action="./task_complete.php" method="post">
        <p>
            <label for="task-name">タスク名</label><br>
            <input type="text" name="task-name" id="task-name">
        </p>
        <p>
            <label for="tantou-name">担当者</label><br>
            <select name="tantou-bloodtype">
                <option value="user-name1">user-name1</option>
                <option value="user-name2">user-name2</option>
            </select>
        </p>
        <p>
            <label for="kigen">期限</label><br>
            <input type="date" name="kigen" id="kigen">まで
        </p>
        <p>
            <label for="status">ステータス</label><br>
            <select name="status-bloodtype">
                <option value="status1">進行中</option>
                <option value="status2">完了</option>
            </select>
        </p>
        <p>
            <label for="yuusen">優先度</label><br>
            <select name="yuusen-bloodtype">
                <option value="high">高</option>
                <option value="medium">中</option>
                <option value="low">低</option>
            </select>
        </p>
        <p>
            <input type="submit" value="タスク作成">
        </p>
    </form>
    <?php
    $filename = './data/task.csv';

    $fp = fopen($filename, 'r');

    $count = 0;
    while ($record = fgetcsv($fp)):
        if($count !== 0):?>
            <p>タスクID<?php echo $record[0] . ' ' . $record[1] ?></p>
    <?php
    endif;
    $count ++;
    endwhile;?>
</body>
</html>
