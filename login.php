<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <!-- git pull origin main コミットする前のお約束 -->
</head>

<body>
    <h1>新規登録</h1>
    <form action="login.php" method="post">
        <label for="username">ユーザーネーム:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <input type="submit" value="登録">
    </form>
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
</body>

</html>