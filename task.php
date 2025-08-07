<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク一覧</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<?php $file_id = $_GET['file_id']; 
$filename = './data/file.csv'; 
$fp = fopen($filename, 'r'); 
$cnt = 0;
$file_name = '';
while($record = fgetcsv($fp)){
    if($cnt !== 0 && $file_id == $record[0]){
        $file_name = $record[1];
    }
    $cnt ++;
}
?>

<body>
    <main class="main">
        <article class="article">
            <header class="page-header wrapper">
                <h1><?php echo $file_name ?></h1>
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


            <!-- タスク作成 --------------------------------------------------------------------- -->

            <section class="task-create">
                <form action="./task_complete.php" method="POST">
                    <input type="hidden" name="file-id" id="file-id" value="<?php echo $file_id ?>">
                    <input type="hidden" name="create-or-edit" id="create" value="create">
                    <div class="task-create-top">
                        <input class="task-name" type="text" name="task-name" placeholder="タスク名を入力">
                    </div>
                    <div class="task-create-bottom">
                        <?php
                        $filename = './data/user.csv';

                        $fp = fopen($filename, 'r');

                        $all_user = [];

                        $count = 0;
                        while ($record = fgetcsv($fp)) {
                            if ($count !== 0 && $record[3] == "true") {
                                $all_user[] = $record[2];
                            }
                            $count++;
                        }
                        fclose($fp);
                        if (empty($all_user) == false): ?>
                            <select name="tantou[]" multiple>
                                <?php foreach ($all_user as $value): ?>
                                    <option hidden>担当者を選択</option>
                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif ?>
                        <select name="yuusenn">
                            <option hidden>優先度を選択</option>
                            <option value="低">低</option>
                            <option value="中">中</option>
                            <option value="高">高</option>
                        </select>
                        <select name="status">
                            <option hidden>進行状況</option>
                            <option value="未開始">未開始</option>
                            <option value="進行中">進行中</option>
                            <option value="完了">完了</option>
                        </select>
                        <input class="date" type="date" name="task-kigen" id="task-kigen">
                        <input type="submit" value="タスクを追加">
                    </div>
                </form>
                <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
                    <p>そのタスク名は使えません。</p>
                <?php endif; ?>
            </section>


            <!-- ↓タスク一覧表示 ------------------------------------------------------- -->

            <section class="file-content">
                <?php
                $filename = './data/task.csv';
                $fp = fopen($filename, "r");
                $records = fgetcsv($fp);
                ?>
                <table>
                    <thead>
                        <tr>
                            <th class="top-left"><?php echo $records[2]; ?></th>
                            <th><?php echo $records[3]; ?></th>
                            <th>残り日数</th>
                            <th><?php echo $records[6]; ?></th>
                            <th><?php echo $records[5]; ?></th>
                            <th class="top-right"><?php echo $records[4]; ?></th>
                        </tr>
                    </thead>
                    <?php
                    date_default_timezone_set('Asia/Tokyo');
                    $task = false;
                    while ($record = fgetcsv($fp)):
                        if ($record[8] == 'false' && $record[0] == $file_id):
                            $task = true; ?>
                            <tr>
                                <td class="top-left"><?php echo $record[2] ?></td>
                                <td><?php $tantou_str = $record[3];
                                        $pices = explode(",", $tantou_str); 
                                        // var_dump($pices);
                                        foreach($pices as  $pice){
                                            echo $pice . '<br>';} ?></td>
                                <td>
                                    <?php
                                    $today = new DateTime();
                                    $deadline = DateTime::createFromFormat('Y-m-d', $record[4]);

                                    if ($deadline && $record[4] !== '0000-00-00') {
                                        $deadline->setTime(0, 0, 0); // 時間を無視して日付だけ比べる
                                        $today->setTime(0, 0, 0);

                                        $diff = $today->diff($deadline);
                                        $diff_days = (int)$diff->format('%r%a'); // 正負付きの差
                                        $md_days = $deadline->format('m-d');

                                        if ($diff_days < 0) {
                                            echo '期限切れ';
                                        } elseif ($diff_days === 0) {
                                            echo '今日';
                                        } else {
                                            echo $diff_days . '日';
                                        }
                                    } else {
                                        echo '期限未設定';
                                    }
                                    ?>
                                </td>
                                <td><?php echo $record[6] ?></td>
                                <td>
                                    <?php echo $record[5] ?><br>
                                    <div class="bottom-input">
                                        <form action="./edit_task.php" method="GET">
                                            <input type="hidden" name="task_id" value="<?php echo $record[1] ?>">
                                            <input type="hidden" name="file_id" value="<?php echo $record[0] ?>">
                                            <input type="submit" value="編集">
                                        </form>
                                    </div>
                                </td>
                                <td class="top-right"><?php echo $md_days ?><br>
                                    <div class="bottom-input task-create-submit">
                                        <form action="./task_delete.php" method="GET">
                                            <input type="hidden" name="task_id" value="<?php echo $record[1] ?>">
                                            <input type="hidden" name="file_id" value="<?php echo $record[0] ?>">
                                            <input type="submit" value="消去">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                    <?php
                        endif;
                    endwhile;
                    ?>
                </table>
                <?php if (!$task): ?>
                    <p>タスクはありません。</p>
                <?php
                endif;
                fclose($fp); ?>
            </section>
        </article>
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
                $filename = './data/file.csv';

                $fp = fopen($filename, 'r');
                $cnt = 0;
                while ($record = fgetcsv($fp)):
                    if ($cnt !== 0 && $record[3] == 'false'): ?>
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
                    endif;
                    $cnt++;
                endwhile;
                ?>
            </section>
        </aside>
    </main>
</body>

</html>