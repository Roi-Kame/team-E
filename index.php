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
            <section class="file-content-none">
                **ここからファイル未選択時の右側（あとでコメントアウト）**
                <p>ファイルを選択してください</p>
            </section>
        </article>
        <aside class="aside">
            <div class="file-box">
                <section class="file-search">
                    <form action="./search.php" method="POST">
                        <input type="text" name="file-name" id="file-name" placeholder="ファイル検索">
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

                while ($record = fgetcsv($fp)): ?>
                    <ul class="file-list-item">
                        <a href="./task.php?file_id=<?php echo $record[0] ?>">
                            <li><?php echo $record[1] ?></li>
                        </a>
                        <form action="./file_delete.php" method="POST">
                            <input type="submit" value="消去">
                        </form>
                    </ul>
                <?php
                endwhile; ?>
            </section>
        </aside>
    </main>
</body>

</html>