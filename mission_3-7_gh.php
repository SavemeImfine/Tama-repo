<?php
//3-1
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';		//ユーザー名とパスワードをコンストラクタの2番目と3番目の引数
$pdo = new PDO($dsn,$user,$password);

//3-7
$id = 8;
$nm = "BTS";
$kome = "LOVE YOURSELF 結 Answer"; 
$sql = "update tbtest set name='$nm' , comment='$kome' where id = $id";
$result = $pdo->query($sql);
?>