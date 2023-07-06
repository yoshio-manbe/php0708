<link rel="stylesheet" href="./css/select.css">

<?php
//【重要】
/**
 * DB接続のための関数をfuncs.phpに用意
 * require_onceでfuncs.phpを取得
 * 関数を使えるようにする。
 */
try {
    $db_name = 'gs_db2';    //データベース名
    $db_id   = 'root';      //アカウント名
    $db_pw   = '';      //パスワード：MAMPは'root'
    $db_host = 'localhost'; //DBホスト
    $pdo = new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
} catch (PDOException $e) {
    exit('DB Connection Error:' . $e->getMessage());
}

//２．データ登録SQL作成
$stmt = $pdo->prepare('SELECT * FROM gs_an_table2;');
$status = $stmt->execute();

//３．データ表示
$view = '';
if ($status === false) {
    $error = $stmt->errorInfo();
    exit('SQLError:' . print_r($error, true));
} else {
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        //GETデータ送信リンク作成
        // <a>で囲う。
        $view .= '<p>';
        $view .= '<a href="detail.php?id=' . $result['id'] . '">';
        $view .= $result['place'] . '：' . $result['address']. '：' . $result['category']. '：' . $result['content'];
        $view .= '</a>';
        $view .= '<a href="delete.php?id=' . $result['id'] . '">';
        $view .= ' [削除] ';
        $view .= '</a>';
        $view .= '</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>データ一覧</title>
</head>

<body id="main" >
    <?php require 'header.php'; ?>

    <h2>
        データ一覧
    </h2>

    <div>
        <div class="container jumbotron" >
            <a href="detail.php" ></a>
            <?= $view ?>
        </div>
    </div>
    <!-- Main[End] -->

</body>
</html>

