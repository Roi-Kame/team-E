<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メンバーリスト</title>
</head>

<body>
    <div class="member_list">
        <strong>
            <p>メンバーリスト</p>
        </strong>
    </div>

    <?php
    $filename = "./data/user.csv";
    $fp = fopen($filename, 'r');
    while ($member = fgetcsv($fp)) {
        if ($member[0] == "#") {
            continue;
        } else {
            echo "<p>" . $member[2] . "</p>";
        }
    }

    ?>
</body>

</html>