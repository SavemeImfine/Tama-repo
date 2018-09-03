<?php
//3-1
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';		//ユーザー名とパスワードをコンストラクタの2番目と3番目の引数
$pdo = new PDO($dsn,$user,$password);

//3-8
$id = 8;
$sql = "delete from tbtest where id=$id";
$result = $pdo->query($sql);
?>