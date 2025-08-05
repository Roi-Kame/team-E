<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ファイル作成画面</title>
</head>

<body>
    <form onsubmit="return create_file()" action="./file_complete.php" method="post">
        <p>
            <label for="file-name">ファイル名</label><br>
            <input type="text" name="file-name" id="file-name">
            <label id="error" for="error" style="display: none">ファイル名を入力してください</label>
        </p>
        <p>
            <input type="submit" value="ファイル作成">
        </p>
    </form>
    <form action="./index.php">
        <p>
            <input type="submit" value="前の画面に戻る">
        </p>
    </form>
    <?php if (isset($_GET['error']) && $_GET['error'] === 'duplicate'): ?>
        <p>そのファイル名は存在しているため使えません。</p>
        <?php endif; ?>
    <script src="./js/app.js"></script>
</body>

</html>