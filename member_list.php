<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/member.css">
    <title>メンバーリスト</title>
</head>

<body>
    <div class="list">
        <h1>メンバーリスト</h1>
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
                        <li><?php echo $member[2] ?>
                            <form method='post'>
                                <input type='hidden' name='id' value=<?php echo $member[0] ?>>
                                <div class='delete'>
                                    <input class="button" type='submit' value='削除'>
                                </div>
                            </form>
                        </li>
                    </ul>
            <?php
                endif;
            endwhile;
            fclose($fp);
            ?>
        </div>


        <form action="./index.php">
            <div class="back">
                <input class="button" type="submit" value="前の画面に戻る">
            </div>
        </form>
    </div>


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