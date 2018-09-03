<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<html>
<body>
<form action="mission_1-6.php" method="post">
<input type="text"value="コメント" name="com" >
<input type="submit" value="送信" name="sub">
</form>
<?php
$htmlspecialchars=$_POST['com'];
if (!empty($htmlspecialchars)) {
$filename='mission_1-6_Tamakawa.txt';	//ファイル名の定義
$fp=fopen($filename,'a');//ファイルをオープンして処理できる状態にする。aの意味は追記でオープンするということ。ファイルが存在しない場合には、 作成を試みる。
fwrite($fp,$htmlspecialchars.PHP_EOL);	//ファイルポインタに書き込んだ内容を書き込む。次回追記されたときに次の行に書き込まれるようにPHP_EOLで改行しておく。
fclose($fp);//ファイルポインタを閉じる。
$date=date('Y年m月d日H時i分');
echo"ご入力ありがとうございます。".$date."に".$htmlspecialchars."を受け付けました。";
}
?>
</body>
</html>