<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/member.css">
    <title>メンバーリスト</title>
</head>

<body>
    <div class="list">
        <header>
            <strong>
                <h1>メンバーリスト</h1>
            </strong>
        </header>
    </div>

    <!-- メンバー表示処理 -->
    <div class="member_list_inner">
        <?php
        $filename = "./data/user.csv";
        $fp = fopen($filename, 'r');
        while ($member = fgetcsv($fp)):
            if ($member[0] == "#"):
                continue;
            elseif ($member[3] == "true"): ?>
                <ul class="member-list">
                    <li><?php echo $member[2] ?></li>
                    <form method='post'>
                        <input type='hidden' name='id' value=<?php echo $member[0] ?>>
                        <div class='delete'>
                            <input type='submit' value='削除'>
                        </div>
                    </form>
                </ul>
        <?php
            endif;
        endwhile;
        fclose($fp);
        ?>
    </div>

    <form action="./index.php">
        <p>
            <input type="submit" value="前の画面に戻る">
        </p>
    </form>


    <!-- 削除処理 -->
    <?php
    $filename = "./data/user.csv";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $target_id = $_POST['id'];
        $rows = [];

        // ファイル読み込み
        $fp = fopen($filename, 'r');
        while (($member = fgetcsv($fp)) !== FALSE) {
            if ($member[0] === $target_id) {
                $member[3] = "false"; // 表示フラグを false に変更
            }
            $rows[] = $member;
        }
        fclose($fp);

        // ファイル書き込み（上書き）
        $fp = fopen($filename, 'w');
        foreach ($rows as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    ?>
</body>

</html>