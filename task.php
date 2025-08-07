<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>タスク一覧</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet" />
</head>

<?php
$file_id = $_GET['file_id'];
$filename = './data/file.csv';
$fp = fopen($filename, 'r');
$cnt = 0;
$file_name = '';
while ($record = fgetcsv($fp)) {
    if ($cnt !== 0 && $file_id == $record[0]) {
        $file_name = $record[1];
    }
    $cnt++;
}
fclose($fp);

// 並び替えパラメータの取得（未設定時はnull）
$sort = $_GET['sort'] ?? null;

// タスクを全部読み込む
$tasks = [];
$fp = fopen('./data/task.csv', 'r');
$header = fgetcsv($fp); // ヘッダー読み込み

while ($record = fgetcsv($fp)) {
    if ($record[0] == $file_id && $record[8] == 'false') { // 対象ファイルかつ削除フラグfalseのみ
        $tasks[] = $record;
    }
}
fclose($fp);

// 並び替え処理
if ($sort !== null) {
    switch ($sort) {
        case '低': // 期限順（昇順）
            usort($tasks, function ($a, $b) {
                return strtotime($a[4]) - strtotime($b[4]);
            });
            break;
        case '中': // 進捗状況順（未開始→進行中→完了）
            $priority = ["未開始" => 1, "進行中" => 2, "完了" => 3];
            usort($tasks, function ($a, $b) use ($priority) {
                return $priority[$a[5]] - $priority[$b[5]];
            });
            break;
        case '高': // 優先度順（高→中→低）
            $priority = ["高" => 1, "中" => 2, "低" => 3];
            usort($tasks, function ($a, $b) use ($priority) {
                return $priority[$a[6]] - $priority[$b[6]];
            });
            break;
    }
}
?>

<body>
    <main class="main">
        <article class="article">
            <header class="page-header wrapper">
                <h1><?php echo htmlspecialchars($file_name, ENT_QUOTES, 'UTF-8'); ?></h1>
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

            <!-- タスク作成 -->
            <section class="task-create">
                <form action="./task_complete.php" method="POST">
                    <input type="hidden" name="file-id" id="file-id" value="<?php echo htmlspecialchars($file_id, ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="create-or-edit" id="create" value="create" />
                    <div class="task-create-top">
                        <input class="task-name" type="text" name="task-name" placeholder="タスク名を入力" />
                    </div>
                    <div class="task-create-bottom">
                        <?php
                        $fp = fopen('./data/user.csv', 'r');
                        $all_user = [];
                        $count = 0;
                        while ($record = fgetcsv($fp)) {
                            if ($count !== 0 && $record[3] == "true") {
                                $all_user[] = $record[2];
                            }
                            $count++;
                        }
                        fclose($fp);
                        if (!empty($all_user)):
                        ?>
                            <select name="tantou[]" multiple>
                                <option hidden>担当者を選択</option>
                                <?php foreach ($all_user as $value): ?>
                                    <option value="<?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>

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

                        <input class="date" type="date" name="task-kigen" id="task-kigen" />
                        <input type="submit" value="タスクを追加" />
                    </div>
                </form>
                <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
                    <p>使用済みのタスク名もしくは入力値がありません</p>
                <?php endif; ?>
            </section>

            <!-- タスク一覧表示 -->
            <section class="file-content">
                <div class="sort-container">
                    <form method="GET" action="./task.php">
                        <input type="hidden" name="file_id" value="<?php echo htmlspecialchars($file_id, ENT_QUOTES, 'UTF-8'); ?>" />
                        <select name="sort" onchange="this.form.submit()">
                            <option hidden>並び替え</option>
                            <option value="低" <?php if ($sort === '低') echo 'selected'; ?>>期限順</option>
                            <option value="中" <?php if ($sort === '中') echo 'selected'; ?>>進捗状況順</option>
                            <option value="高" <?php if ($sort === '高') echo 'selected'; ?>>優先度順</option>
                        </select>
                    </form>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th class="top-left"><?php echo htmlspecialchars($header[2], ENT_QUOTES, 'UTF-8'); ?></th>
                            <th><?php echo htmlspecialchars($header[3], ENT_QUOTES, 'UTF-8'); ?></th>
                            <th>残り日数</th>
                            <th><?php echo htmlspecialchars($header[6], ENT_QUOTES, 'UTF-8'); ?></th>
                            <th><?php echo htmlspecialchars($header[5], ENT_QUOTES, 'UTF-8'); ?></th>
                            <th class="top-right"><?php echo htmlspecialchars($header[4], ENT_QUOTES, 'UTF-8'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($tasks) === 0): ?>
                            <tr>
                                <td colspan="6">タスクはありません。</td>
                            </tr>
                        <?php else: ?>
                            <?php
                            date_default_timezone_set('Asia/Tokyo');
                            foreach ($tasks as $record):
                                $tantou_str = $record[3];
                                $pices = explode(",", $tantou_str);

                                $today = new DateTime();
                                $deadline = DateTime::createFromFormat('Y-m-d', $record[4]);

                                if ($deadline && $record[4] !== '0000-00-00') {
                                    $deadline->setTime(0, 0, 0);
                                    $today->setTime(0, 0, 0);

                                    $diff = $today->diff($deadline);
                                    $diff_days = (int)$diff->format('%r%a');
                                    $md_days = $deadline->format('m-d');

                                    if ($diff_days < 0) {
                                        $remaining = '期限切れ';
                                    } elseif ($diff_days === 0) {
                                        $remaining = '今日';
                                    } else {
                                        $remaining = $diff_days . '日';
                                    }
                                } else {
                                    $remaining = '期限未設定';
                                    $md_days = '';
                                }
                            ?>
                                <tr>
                                    <td class="top-left"><?php echo htmlspecialchars($record[2], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php
                                        foreach ($pices as $pice) {
                                            echo htmlspecialchars($pice, ENT_QUOTES, 'UTF-8') . '<br>';
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $remaining; ?></td>
                                    <td><?php echo htmlspecialchars($record[6], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php echo htmlspecialchars($record[5], ENT_QUOTES, 'UTF-8'); ?><br />
                                        <div class="bottom-input">
                                            <form action="./edit_task.php" method="GET">
                                                <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($record[1], ENT_QUOTES, 'UTF-8'); ?>" />
                                                <input type="hidden" name="file_id" value="<?php echo htmlspecialchars($record[0], ENT_QUOTES, 'UTF-8'); ?>" />
                                                <input type="submit" value="編集" />
                                            </form>
                                        </div>
                                    </td>
                                    <td class="top-right">
                                        <?php echo $md_days; ?><br />
                                        <div class="bottom-input task-create-submit">
                                            <form action="./task_delete.php" method="GET">
                                                <input type="hidden" name="task_id" value="<?php echo htmlspecialchars($record[1], ENT_QUOTES, 'UTF-8'); ?>" />
                                                <input type="hidden" name="file_id" value="<?php echo htmlspecialchars($record[0], ENT_QUOTES, 'UTF-8'); ?>" />
                                                <input type="submit" value="消去" />
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </article>

        <!-- ファイル一覧表示 -->
        <aside class="aside">
            <div class="file-box">
                <section class="file-search">
                    <form action="./search.php" method="GET">
                        <input type="text" name="search-text" id="search-text" placeholder="🔍ファイル名検索" />
                    </form>
                </section>
                <section class="file-create">
                    <form action="./file_create.php">
                        <button type="submit">
                            <img src="img/file-create.png" alt="作成" />
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
                    if ($cnt !== 0 && $record[3] == 'false'):
                ?>
                        <div class="file-list-item">
                            <a href="./task.php?file_id=<?php echo htmlspecialchars($record[0], ENT_QUOTES, 'UTF-8'); ?>">
                                <ul>
                                    <li><?php echo htmlspecialchars($record[1], ENT_QUOTES, 'UTF-8'); ?></li>
                                    <form action="./file_delete.php" method="GET">
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($record[0], ENT_QUOTES, 'UTF-8'); ?>" />
                                        <input type="submit" value="削除" />
                                    </form>
                                </ul>
                            </a>
                        </div>
                <?php
                    endif;
                    $cnt++;
                endwhile;
                fclose($fp);
                ?>
            </section>
        </aside>
    </main>
</body>

</html>