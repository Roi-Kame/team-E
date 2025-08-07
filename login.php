<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>新規登録</title>
    <!-- git pull origin main コミットする前のお約束 -->
</head>

<body>
    <div class="login-container">
        <h1>新規登録</h1>
        <form onsubmit="return validateForm()" action="login.php" method="post">
            <div class="form-container">
                <label for="username">ユーザーネーム</label>
                <br>
                <input type="text" id="username" name="username" laceholder="name" placeholder="name">
                <p id="error" style="display:none;">ユーザーネームを入力してください</p>
                <br>
                <input type="submit" value="登録">
            </div>
        </form>
        <form action="./index.php">
            <div class="form-container">
                <input type="submit" value="前の画面に戻る">
            </div>
        </form>
    </div>
    <?php
    // ユーザーネーム入力を受け取りcsvに保存(新規登録)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // POSTされたときだけ保存処理
        $day = date('Y-m-d');
        $username = $_POST['username'];
        $filename = './data/user.csv';

        // 読み取りモードで開く
        $read_fp = fopen($filename, 'r');
        $id = 0;
        while ($row = fgetcsv($read_fp)) {
            $id = intval($row[0]);
        }
        $new_id = $id + 1;
        fclose($read_fp);
        // 追記モードで開く
        $fp = fopen($filename, 'a');
        fputcsv($fp, [$new_id, $day, $username, "true"]);
        fclose($fp);

        header("Location: index.php");
        exit;
    }


    ?>
    <script src="js/app.js"></script>
</body>

</html>