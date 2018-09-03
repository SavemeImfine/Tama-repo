<?php
header('Content-Type: text/html; charset=UTF-8');//文字コードの指定

//3-1
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';		//ユーザー名とパスワードをコンストラクタの2番目と3番目の引数
$pdo = new PDO($dsn,$user,$password);

//3-5
$sql = $pdo -> prepare("INSERT INTO tbtest (id,name, comment) VALUES ('8',:name, :comment)");
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);		//PDO::PARAM_STR...SQL CHAR, VARCHAR, または他の文字列データ型を表します。
$name = 'BTS';//名前
$comment = 'Answer : Love Myself'; //好きな言葉
$sql -> execute();

?>