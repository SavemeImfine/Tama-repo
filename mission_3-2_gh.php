<?php
header('Content-Type: text/html; charset=UTF-8');//文字コードの指定

//3-1データベース接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';		//ユーザー名とパスワードをコンストラクタの2番目と3番目の引数
$pdo = new PDO($dsn,$user,$password);

//3-2
$sql = "CREATE TABLE tbtest"
. " ("
. "id INT,"		//INT...そのフィールドには整数値のみ入力可能
. "name char(32),"		//char...格納可能領域が決まっている。
. "comment TEXT"		//TEXT...テキストのみ入力可能
.");";
$stmt = $pdo->query($sql);		//query() は、指定したSQL文をデータベースに対して発行し、返された結果セット を PDOStatement オブジェクトとして返す。->は左辺から右辺を取り出す演算子.3つのカラムを持ったテーブル「tbtest」が作成される.

?>