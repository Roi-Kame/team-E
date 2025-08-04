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
    <div id="login-container">
        <h1>新規登録</h1>
        <form action="login.php" method="post">
            <div id="form-container">
                <label for="username">ユーザーネーム</label>
                <br>
                <input type="text" id="username" name="username" required placeholder="name">
                <br>
                <input type="submit" value="登録">
            </div>
        </form>
    </div>
    <?php
    // ユーザーネーム入力を受け取りcsvに保存(新規登録)
    ?>
</body>

</html>