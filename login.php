<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>ログイン 新規登録</title>
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
    </div>
    <?php
    // ユーザーネーム入力を受け取りcsvに保存(新規登録)
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // POSTされたときだけ保存処理
        $username = $_POST['username'];
        $filename = './data/user.csv';

        $fp = fopen($filename, 'a');
        fputcsv($fp, [$username]);
        fclose($fp);
    }


    ?>
    <script src="js/app.js"></script>
</body>

</html>