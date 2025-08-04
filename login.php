<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン 新規登録</title>
</head>

<body>
    <h1>ログイン</h1>
    <form action="login.php" method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <button type="submit">ログイン</button>
        <button type="button" onclick="location.href='register.php'">新規登録</button>
</body>

</html>