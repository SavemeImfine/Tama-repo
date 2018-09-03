<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<html>
<body>
<form action="mission_1-7.php" method="post">
<input type="text"value="コメント" name="com" >
<input type="submit" value="送信" name="sub">
</form>
<?php
$htmlspecialchars=$_POST['com'];
if (!empty($htmlspecialchars)) {
	//ファイル名の定義
	$filename='mission_1-6_Tamakawa.txt';	//ファイル名の定義
	//ファイルをオープンして処理できる状態にする。aの意味は追記でオープンするということ。ファイルが存在しない場合には、 作成を試みる。
	$fp=fopen($filename,'a');
	fwrite($fp,$htmlspecialchars.PHP_EOL);	//ファイルポインタに書き込んだ内容を書き込む。次回追記されたときに次の行に書き込まれるようにPHP_EOLで改行しておく。
	$ichiran = file( $filename );// ファイルを全て配列に入れる。そしてそれを変数と置く。
	foreach($ichiran as $value){
		echo $value."<br>";
		};//
	fclose($fp);//ファイルポインタを閉じる。
	}
?>
</body>
</html>