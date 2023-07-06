<?php
// データベース接続情報
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gs_db2";

// データベースに接続
$conn = new mysqli($servername, $username, $password, $dbname);
// フォームデータの取得とエスケープ処理
$places = array();
$addresses = array();
$colors = array();

for ($i = 1; $i <= 5; $i++) {
    $places[] = $conn->real_escape_string($_POST['place' . $i]);
    $addresses[] = $conn->real_escape_string($_POST['address' . $i]);
    $categories[] = $conn->real_escape_string($_POST['category' . $i]);
    $contents[] = $conn->real_escape_string($_POST['content' . $i]);
}

// データベースに挿入するためのSQLクエリの作成
$sql = "INSERT INTO gs_an_table2 (place, address, category, content) VALUES ";

$values = array();
for ($i = 0; $i < 5; $i++) {
    $values[] = "('" . $places[$i] . "', '" . $addresses[$i] . "', '" . $categories[$i] . "', '". $contents[$i] . "')";
}

$sql .= implode(", ", $values);

// SQLクエリの実行
if ($conn->query($sql) === TRUE) {
    echo "データが正常に挿入されました";
} else {
    echo "エラー: " . $sql . "<br>" . $conn->error;
}

// データベース接続のクローズ
$conn->close();
?>

<a href="select.php">一覧へ</a>
