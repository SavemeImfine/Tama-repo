<?php
header("Content-Type: text/html; charset=UTF-8");//文字コードの指定
?>
<html>
<body>
<form action="mission_1-5.php" method="post">
<input type="text"value="コメント" name="com" >
<input type="submit" value="送信" name="sub">
</form>
<?php
$htmlspecialchars=$_POST['com'];//コメントの内容を変数に格納する
if (!empty($htmlspecialchars)) {//もしコメントが空白でないならば
$filename='mission_1-5_Tamakawa.txt';	///ファイル名の定義
$fp=fopen($filename,'w');//ファイルをオープンして処理できる状態にする。w・・・ファイルポインタをファイルの先頭に置き、ファイルサイズをゼロにする。ファイルが存在しない場合には、 作成を試みる。
fwrite($fp,$htmlspecialchars);//ファイルポインタにコメントの内容を書き込む。
fclose($fp);//ファイルポインタを閉じる。
		if($htmlspecialchars=="完成!"){//コメントが完成！ならば
		echo"おめでとう!";}//おめでとうと表示する
		else{	//それ以外の場合は
		$date=date('Y年m月d日H時i分');//
		echo"ご入力ありがとうございます。".$date."に".$htmlspecialchars."を受け付けました。";}//送信確認画面の表示
};
?>
</body>
</html>