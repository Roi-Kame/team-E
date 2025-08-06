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
    <main class="main">
        <article class="article">
            <header class="page-header wrapper">
                <h1>ファイル名</h1>
                <nav>
                    <ul class="header-nav">
                        <a href="login.php">
                            <li>メンバー登録</li>
                        </a>
                        <a href="">
                            <li>メンバーリスト</li>
                        </a>
                    </ul>
                </nav>
            </header>
            
            <?php $file_id = $_GET['file_id']; ?>
            <form action="./task_complete.php" method="POST">
                <input type="hidden" name="file-id" id="file-id" value="<?php echo $file_id ?>">
                <input type="text" name="task-name" placeholder="タスク名を入力">
                <input type="date" name="task-kigen" id="task-kigen">
                <?php
                $filename = './data/user.csv';

                $fp = fopen($filename, 'r');

                $all_user = [];

                $count = 0;
                while($record = fgetcsv($fp)){
                    if($count !== 0 && $record[3] == "false"){
                        $all_user[] = $record[2];
                    }
                    $count ++;
                }
                fclose($fp);
                if(empty($all_user)):?>
                    <select name="tantou">
                        <?php foreach ($all_user as $value): ?>
                        <option hidden>担当者を選択</option>
                        <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif ?>
                <select name="status">
                    <option hidden>進捗度を選択</option>
                    <option value="未開始">未開始</option>
                    <option value="進行中">進行中</option>
                    <option value="完了">完了</option>
                </select>
                <select name="yuusenn">
                    <option hidden>優先度を選択</option>
                    <option value="低">低</option>
                    <option value="中">中</option>
                    <option value="高">高</option>
                </select>
                <input type="submit" value="タスクを追加">
            </form>
            <!-- ↓一覧表示 -->
            <section class="file-content-none">
                <?php
                $filename = './data/task.csv';

                $fp = fopen($filename, 'r');

                $cnt = 0;
                $task_name_lst = [];
                while ($record = fgetcsv($fp)):
                    if($record[0] == $file_id):
                        $task_name_lst[] = $record[2];
                        if ($cnt !== 0 && $record[8] == 'false'): ?>
                            <ul class="file-list-item">
                                <?php echo $record[2] ?>
                                <!-- echoで書いてるけど<p>とかがよかったらそっちで -->
                                <form action="./file_delete.php" method="GET">
                                    <input type="hidden" name="id" value="<?php echo $record[0] ?>">
                                    <input type="submit" value="消去">
                                </form>
                            </ul>
                <?php
                        endif;
                    endif;
                    $cnt++;
                endwhile;
                if($task_name_lst == false):?>
                    <p>タスクはありません。</p>
                <?php endif; ?>
            </section>
        </article>
        <aside class="aside">
            <div class="file-box">
                <section class="file-search">
                    <form action="./search.php" method="GET">
                        <input type="text" name="search-text" id="search-text" placeholder="ファイル名検索">
                    </form>
                </section>
                <section class="file-create">
                    <form action="./file_create.php">
                        <input type="submit" value="📁+">
                    </form>
                </section>
            </div>
            <section class="file-list">
                <?php
                $filename = './data/file.csv';

                $fp = fopen($filename, 'r');
                $cnt = 0;
                while ($record = fgetcsv($fp)):
                    if ($cnt !== 0 && $record[3] == 'false'): ?>
                        <ul class="file-list-item">
                            <a href="./task.php?file_id=<?php echo $record[0] ?>">
                                <li><?php echo $record[1] ?></li>
                            </a>
                            <form action="./file_delete.php" method="GET">
                                <input type="hidden" name="id" value="<?php echo $record[0] ?>">
                                <input type="submit" value="消去">
                            </form>
                        </ul>
                <?php
                    endif;
                    $cnt++;
                endwhile;
                ?>
            </section>
        </aside>
    </main>
</body>

</html>