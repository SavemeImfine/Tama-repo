<?php
header('Content-Type: text/html; charset=UTF-8');//文字コードの指定

//3-1データベース接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';		//ユーザー名とパスワードをコンストラクタの2番目と3番目の引数
$pdo = new PDO($dsn,$user,$password);

//3-3
$sql ='SHOW TABLES';
$result = $pdo -> query($sql);		//3つのカラムを持ったテーブル「tbtest」を変数として取り出す(投稿ごとの配列)
foreach ($result as $row){		//投稿を一つずつ変数$rowに入れ、投稿番号を表示
			echo $row[0];
			echo '<br>';
}
echo "<hr>";

?>