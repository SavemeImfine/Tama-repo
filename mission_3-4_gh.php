<?php
header('Content-Type: text/html; charset=UTF-8');//文字コードの指定

//3-1データベース接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';		//ユーザー名とパスワードをコンストラクタの2番目と3番目の引数
$pdo = new PDO($dsn,$user,$password);

//3-4
$sql ='SHOW CREATE TABLE tbtest';		//現在作成されているテーブルの一覧を取得する
$result = $pdo -> query($sql);
foreach ($result as $row){
			print_r($row);
}
echo "<hr>";
?>