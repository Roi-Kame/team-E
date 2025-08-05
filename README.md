
git pull origin main

タスク登録時の検証
3. ファイル名が押されたらそのファイルidと同じファイルidを持つタスクを一覧表示（get送信）
4. タスク登録（ファイルid,タスクid,タスク名,担当者,期限,ステータス,優先度,消去済）
5. タスク消去
6. タスク編集

ファイル名の下に%表示

ファイル作成　済
ファイル消去　済
ファイル検索　済




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
    <form action="./search.php" method="GET">
        <input type="text" name="search-text" id="search-text" placeholder="ファイル名検索">
        <input type="submit" value="検索">
    </form>
    <form action="./file_create.php">
        <input type="submit" value="ファイル作成">
    </form>
    <div class="file_name">
        <?php
        $filename = './data/file.csv';

        $fp = fopen($filename, 'r');

        $count = 0;

        while ($record = fgetcsv($fp)):
        if($count !== 0 && $record[3] == 'false'):?>
            <p><a href="./task.php?file_id=<?php echo $record[0] ?>"><?php echo $record[1] ?></a></p>
            <form action="./file_delete.php" method="GET">
                <input type="hidden" name="id" value="<?php echo $record[0]?>">
                <input type="submit" value="消去">
            </form>
        <?php
        endif;
        $count ++;
        endwhile; ?>
    </div>

    <!-- ここまで左側 -->
    **ここからファイル未選択時の右側（あとでコメントアウト）**
    <p>ファイルを選択してください</p>
</body>

</html>