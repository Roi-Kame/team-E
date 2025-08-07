<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ファイル作成</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="stylesheet" href="./css/file-create.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <main class="main">
        <article class="article">
            <header class="page-header wrapper">
                <h1>ファイル作成</h1>
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
                <div class="file-create-box">
                    <form onsubmit="return create_file()" action="./file_complete.php" method="post">

                        <label class="label-faile-name" for="file-name">ファイル名</label>
                        <input type="text" placeholder="ファイル名を入力" name="file-name" id="file-name">
                        <label id="error" for="error" style="display: none">ファイル名を入力してください</label>

                        <input class="button-file-make" type="submit" value="ファイル作成">
                    </form>
                    <form class="button-back-box" action="./index.php">
                        <p>
                            <input class="button-back" type="submit" value="前の画面に戻る">
                        </p>
                    </form>
                </div>
                <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
                    <p>そのファイル名は存在しているため使えません。</p>
                <?php endif; ?>
                <script src="./js/app.js"></script>
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
                                        <input type="submit" value="削除">
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