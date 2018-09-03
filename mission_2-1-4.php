<?php
header('Content-Type: text/html; charset=UTF-8');//文字コードの指定

//フォームで送信された内容の取り込み
$var1=($_POST['form1']);		//氏名
$var2=($_POST['form2']);		//コメント
$var3=($_POST['form3']);		//削除対象番号
$var10=($_POST['form4']);		//編集対象番号
$editno=($_POST['form5']);		//編集中の番号

//日時を変数として取り込む
$date=date('Y年m月d日H:i:s');
//コメント一覧用ファイルと投稿番号管理ファイルの宣言
$filename1='mission_2-1-4.txt';//コメント一覧
$filename2='count_2-1-4.txt';//投稿番号


//新規書き込み
if($_POST['send']&&! $_POST['delete']&&! $_POST['edit']&&empty($editno)){ 		//送信ボタン押されたとき(編集対象番号が空)

		if (!empty($var1)&&!empty($var2)) {   //さらにその中で、氏名とコメントがが空欄でないとき
		
				//投稿番号の変数$countを作る
				$fp1=fopen($filename2,'a+');		//投稿番号管理ファイルを開く。(a+...読み込み／書き出し用,ファイルポインタはファイルの終端,ファイルがない場合は作成)
				$count=file_get_contents($filename2);		//投稿番号管理ファイルの内容を文字列$countへ(初めは０)
				$count++;		//文字列(変数)$countに１を足し投稿番号完成！！
				ftruncate($fp1,0);		//投稿番号管理ファイルの中身をからにする
				fwrite($fp1,$count);		//変数$countを書き込む(初めは1が書き込まれる感じ)
				fclose($fp1);			//投稿番号管理ファイルを閉じる
				
				//コメント一覧ファイルに書き込む内容をまとめ,変数$var5と置く
				$var5="$count<>$var1<>$var2<>$date";
				
				//コメント一覧ファイルへの書き込み
				$fp2=fopen($filename1,'a');		//ファイルをオープン.a...追記でオープン,ファイルがない場合, 作成
				fwrite($fp2,$var5.PHP_EOL);		//ファイルに$var5を書き込む。次回追記されたときに次の行に書き込まれるようにPHP_EOLで改行しておく。
				fclose($fp2);//ファイルを閉じる。
				};		//氏名とコメントがが空欄でないときの操作終了
};

//投稿削除				
if($_POST['delete']&&! $_POST['send']&&! $_POST['edit']){		//削除ボタンが押された時
		if(!empty($var3)){		//さらに削除対象番号が記入されている場合
		
				//コメント一覧ファイルの上書き
				$fp3=fopen($filename1,'a+');		//コメント一覧ファイルをオープンして処理できる状態にする。(a+...読み込み／書き出し用,ファイルポインタはファイルの終端,ファイルがない場合は作成)
				$array3=file($filename1);		//テキストファイルを配列$array3に入れる[投稿１、投稿２、・・・]
				ftruncate($fp3,0);		//配列に入れたので一旦,コメント一覧ファイルの中身を空にする
				foreach($array3 as $var8){		//配列$array3の中身を一つずつ変数＄var8に取り込む。(１回目$var8=投稿1、２回目$var8=投稿2の繰り返し)
						$array4= explode("<>", $var8);		//変数$var8の文字列を<>で分割し、配列$array4に格納($array4[0]が投稿番号)
						if(!($array4[0]==$var3)){		//投稿番号が削除対象番号$var3と一致しない場合
								fwrite($fp3,$var8);		//コメント一覧ファイルに$var8(<>が入った状態の投稿)を書き込み
						};		//投稿番号が削除対象番号$var3と一致しない場合の操作終了
				};		//上書き のループ終了
				fclose($fp3);		//コメント一覧ファイルを閉じる
		};			//削除対象番号が記入されている場合の操作終了	
};		


//投稿編集
//フォームに編集対象の投稿を表示
if(!$_POST['delete']&&! $_POST['send']&& $_POST['edit']){//編集ボタンが押されたとき
		if(!empty($var10)){	//編集対象番号が入力されている場合
		$fp4=fopen($filename1,'a+');		//ファイルをオープンする
		$array5=file($filename1);		//テキストファイルを配列$array3に入れる[投稿１、投稿２、・・・]
		foreach ($array5 as $var11){	//テキストファイルの中身を取り出しル―プに入れる。
	    		$array6 = explode("<>",$var11);	//投稿番号を取り出して
				if($var10 == $array6[0]){	//編集対象番号と各行の投稿番号がイコールの時
						$data0 = $array6[0];	//1つの投稿の配列を指している。[0]は投稿番号　[1]は名前　[2]はコメント　[3]は日付
						$data1 = $array6[1];
						$data2 = $array6[2];
						$data3 = $array6[3];
					
				};
		};
		fclose($fp4);	
	};
};
//ファイルの上書き
if($_POST['send']&&! $_POST['delete']&&! $_POST['edit']&&!empty($editno)){ 
						if (!empty($var1)&&!empty($var2)) { 		//さらにその中で、氏名とコメントがが空欄でないと
						$editpost="$editno<>$var1<>$var2<>$date";		//コメント一覧ファイルに書き込む内容をまとめ,変数$editpostと置く
						$fp5=fopen($filename1,'a+');		//投稿一覧ファイルを開く。(a+...読み込み／書き出し用,ファイルポインタはファイルの終端,ファイルがない場合は作成)
						$array7=file($filename1);		//テキストファイルを配列$array7に入れる[投稿１、投稿２、・・・]
						ftruncate($fp5,0);		//配列に入れたので一旦,コメント一覧ファイルの中身を空にする
						foreach ($array7 as $eachpost) {
								$array8= explode("<>", $eachpost);		//変数$eachpostの文字列を<>で分割し、配列$array8に格納
								if($array8[0]==$editno){		//投稿番号が編集中の番号$editnoと一致した場合
								fwrite($fp5,$editpost.PHP_EOL);	//編集後の投稿を書き込み
								}else{		//それ以外の場合は
								fwrite($fp5,$eachpost);		//元の投稿のまま書き込み
								};		
						};		//テキストファイルへの書き込み終わり
				fclose($fp5);			
				};
};
?>

<html>
<meta http-equiv="content-type" charset="utf-8">
<body>
<form action="mission_2-1-4.php" method="post">

名前:<input type="text" name="form1"  value="<?php echo $data1;?>" placeholder="名前" > <br>

コメント:<input type="text" name="form2"  value="<?php echo $data2;?>" placeholder="コメント" > 

<input type="submit" value="送信" name="send"><br>

<input type="hidden" name="form5"  value="<?php echo $data0;?>"> 

<br>

コメントを削除する:<input type="text" placeholder="削除対象番号" name="form3">

<input type="submit" value="削除" name="delete"><br>

コメントを編集する:<input type="text" placeholder="編集対象番号" name="form4">

<input type="submit" value="編集" name="edit"><br>

</form>
</body>
</html>

//ブラウザ表示
<?php
if($_POST['delete'] or $_POST['send'] or $_POST['edit']){//ボタンが押されたとき
			$fplast=fopen($filename1,'r');
			$allpost=file($filename1);		//テキストファイルを配列$allpostに入れる[投稿１,投稿２,投稿３...]の状態
			foreach( $allpost as $line ){  			//配列$allpostの中身を一つずつ変数$lineに(１回目$line=投稿1、２回目$line=投稿2の繰り返し)
				$arraylast = explode("<>",$line);			//変数$lineの文字列を<>で分割し、配列$arraylastに格納($varlast[0]が投稿番号)
				$joinpost=join("   ",$arraylast);
	 			echo $joinpost."<br>" ;
			   }
			fclose($fplast);
};
?>

