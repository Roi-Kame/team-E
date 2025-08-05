<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/delete_confirm.css">
    <!-- git pull origin main コミットする前のお約束 -->
    <title>削除確認</title>
</head>

<body>
    <div class="delete-confirm-container">
        <h1>削除確認</h1>
        <p class="really-delete">本当に削除しますか？</p>
        <div class="button-container">
            <form action="delete_confirm.php" method="post">
                <input type="hidden" name="delete" value="true">
                <button type="submit">はい</button>
            </form>
            <form action="index.php" method="get">
                <button type="submit">いいえ</button>
            </form>
        </div>
    </div>
</body>

</html>