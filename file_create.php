<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ファイル作成画面</title>
</head>
<body>
    <form action="./file_complete.php" method="post">
        <p>
            <label for="file-name">ファイル名</label><br>
            <input type="text" name="file-name" id="file-name">
        </p>
        <p>
            <input type="submit" value="ファイル作成">
        </p>
    </form>
    <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
    <p>そのファイル名は使えません。ファイル名を変更してください。</p>
    <?php endif; ?>
</body>
</html>
