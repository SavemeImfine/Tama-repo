<?php
header('Content-Type: text/html; charset=UTF-8');//文字コードの指定

//フォームで送信された内容の取り込み
$yourname=($_POST['form1']);		//氏名
$yourcomment=($_POST['form2']);		//コメント
$sakujoNO=($_POST['form3']);		//削除対象番号
$henshuNO=($_POST['form4']);		//編集対象番号
$editno=($_POST['form5']);		//編集中の番号
$pass=($_POST['postPW']);	//投稿時に登録するパスワード
$deletepass=($_POST['deletePW']);	//削除確認パスワード
$editpass=($_POST['editPW']);	//編集確認パスワード


//日時を変数として取り込む
$date=date('Y年m月d日H:i:s');
//コメント一覧用ファイルと投稿番号管理ファイルの宣言
$filename1='mission_2-5.txt';//コメント一覧
$filename2='count_2-5.txt';//投稿番号


//新規書き込み
if($_POST['send']&&! $_POST['delete']&&! $_POST['edit']&&empty($editno)){ 		//送信ボタン押されたとき(編集対象番号が空)

		if (!empty($yourname)&&!empty($yourcomment)&&!empty($pass)) {   //さらにその中で、氏名とコメント,パスワードが空欄でないとき
		
				//投稿番号の変数$countを作る
				$fp1=fopen($filename2,'a+');		//投稿番号管理ファイルを開く。(a+...読み込み／書き出し用,ファイルポインタはファイルの終端,ファイルがない場合は作成)
				$count=file_get_contents($filename2);		//投稿番号管理ファイルの内容を文字列$countへ(初めは０)
				$count++;		//文字列(変数)$countに１を足し投稿番号完成！！
				ftruncate($fp1,0);		//投稿番号管理ファイルの中身をからにする
				fwrite($fp1,$count);		//変数$countを書き込む(初めは1が書き込まれる感じ)
				fclose($fp1);			//投稿番号管理ファイルを閉じる
				
				//コメント一覧ファイルに書き込む内容をまとめ,変数$var5と置く
				$var5="$count<>$yourname<>$yourcomment<>$date<>$pass<>";
				
				//コメント一覧ファイルへの書き込み
				$fp2=fopen($filename1,'a');		//ファイルをオープン.a...追記でオープン,ファイルがない場合, 作成
				fwrite($fp2,$var5.PHP_EOL);		//ファイルに$var5を書き込む。次回追記されたときに次の行に書き込まれるようにPHP_EOLで改行しておく。
				fclose($fp2);//ファイルを閉じる。
				};		//氏名とコメントがが空欄でないときの操作終了
};


//投稿削除				
if($_POST['delete']&&! $_POST['send']&&! $_POST['edit']){		//削除ボタンが押された時
		if(!empty($sakujoNO)&& !empty($deletepass)){		//さらに削除対象番号が記入されている場合
		
				//コメント一覧ファイルの上書き
				$fp3=fopen($filename1,'a+');				//コメント一覧ファイルをオープンして処理できる状態にする。(a+...読み込み／書き出し用,ファイルポインタはファイルの終端,ファイルがない場合は作成)
				$array3=file($filename1);		//テキストファイルを配列$array3に入れる[投稿１、投稿２、・・・]
				foreach($array3 as $var8){		//配列$array3の中身を一つずつ変数＄var8に取り込む。(１回目$var8=投稿1、２回目$var8=投稿2の繰り返し)
							$array4= explode("<>", $var8);		//変数$var8の文字列を<>で分割し、配列$array4に格納($array4[0]が投稿番号)
							if($array4[0]==$sakujoNO){		//投稿番号が削除対象番号と一致したら
											$dno=$array4[0];//投稿番号
											$predpass=$array4[4];	//テキストファイルからパスワードの取り出し完了(この時点では最後にスペースが入っている。)
											$dpass=trim($predpass);//スペースの削除
							};	
				};
				if(!($deletepass==$dpass)){//パスワードが一致しない場合
							fclose($fp3);	//ファイルを閉じる
							echo "パスワードが違うため削除できません"; //ブラウザにエラーを表示
				}else{//パスワードが一致した場合
							ftruncate($fp3,0);		//配列に入れたので一旦,コメント一覧ファイルの中身を空にする
							foreach($array3 as $var9){		//配列$array3の中身を一つずつ変数＄var9に取り込む。(１回目$var9=投稿1、２回目$var9=投稿2の繰り返し)
										$array9= explode("<>", $var9);		//変数$var9の文字列を<>で分割し、配列$array9に格納($array9[0]が投稿番号)
										if(!($array9[0]==$sakujoNO)){		//投稿番号が削除対象番号と一致しない場合
													fwrite($fp3,$var9);		//コメント一覧ファイルに$var8(<>が入った状態の投稿)を書き込み
										};		//投稿番号が削除対象番号$var3と一致しない場合の操作終了
							};		//上書き のループ終了
							fclose($fp3);		//コメント一覧ファイルを閉じる
							echo "投稿を削除しました";
				};	//パスワードが一致した場合の動作終了
		};			//削除対象番号が記入されている場合の操作終了	
};		



//投稿編集
//①フォームに編集対象の投稿を表示
if(!$_POST['delete']&&! $_POST['send']&& $_POST['edit']){//編集ボタンが押されたとき
		if(!empty($henshuNO)&& !empty($editpass)){	//編集対象番号とパスワードが入力されている場合
				$fp4=fopen($filename1,'a+');				//コメント一覧ファイルをオープンして処理できる状態にする。(a+...読み込み／書き出し用,ファイルポインタはファイルの終端,ファイルがない場合は作成)
				$arrayIR=file($filename1);		//テキストファイルを配列$arrayIRに入れる[投稿１、投稿２、・・・]
				foreach($arrayIR as $varepost){		//配列$array3の中身を一つずつ変数＄var8に取り込む。(１回目$var8=投稿1、２回目$var8=投稿2の繰り返し)
							$arrayepost= explode("<>", $varepost);		//変数$varepostの文字列を<>で分割し、配列$arrayepostに格納($arrayepost[0]が投稿番号)
							if($arrayepost[0]==$henshuNO){		//投稿番号が削除対象番号と一致したら
											$eno=$arrayepost[0];//投稿番号
											$preepass=$arrayepost[4];	//テキストファイルからパスワードの取り出し完了(この時点では最後にスペースが入っている。)
											$epass=trim($preepass);//スペースの削除
							};	
				};		
		if(!($editpass==$epass)){//パスワードが一致しない場合
							fclose($fp4);	//ファイルを閉じる
							echo "パスワードが違うため編集できません"; //ブラウザにエラーを表示
		}else{//パスワードが一致した場合
							foreach ($arrayIR as $varepost){	//テキストファイルの中身を取り出しル―プに入れる。
	    								$array14 = explode("<>",$varepost);	//投稿番号を取り出して
										if($henshuNO == $array14[0]){	//編集対象番号と各行の投稿番号がイコールの時
														$data0 = $array14[0];	//[0]は投稿番号　[1]は名前　[2]はコメント　[3]は日付
														$data1 = $array14[1];
														$data2 = $array14[2];
														$data3 = $array14[3];//フォームに表示する変数をおいた。
														echo "【内容を編集し、新しくパスワードを設定してください。】";
					
										};
								};
			fclose($fp4);	
		};
	};
};
//②ファイルに投稿を上書き
if($_POST['send']&&! $_POST['delete']&&! $_POST['edit']&&!empty($editno)){ //編集投稿番号が表示された状態で送信ボタンが押されたとき
						if (!empty($yourname)&&!empty($yourcomment)&&!empty($pass)) { 		//さらにその中で、氏名とコメント、パスワードが空欄でないと
						$editpost="$editno<>$yourname<>$yourcomment<>$date<>$pass<>";		//コメント一覧ファイルに書き込む内容をまとめ,変数$editpostと置く
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
				echo "投稿を更新しました"	;
				};
};
?>

<html>
<meta http-equiv="content-type" charset="utf-8">
<body>
<form action="mission_2-5.php" method="post">

<hr size="2" width="300" align="left" color="black" noshade   >

<br>
名前:<input type="text" name="form1"  value="<?php echo $data1;?>" placeholder="名前" > <br>
コメント:<input type="text" name="form2"  value="<?php echo $data2;?>" placeholder="コメント" > <br>
パスワード: <input type="text" placeholder="パスワード" name="postPW">
<input type="submit" value="送信" name="send"><br>

<input type="hidden" name="form5"  value="<?php echo $data0;?>"> 

<br>
<hr size="2" width="300" align="left" color="black" noshade   >
<br>

コメントの削除:<input type="text" placeholder="削除対象番号" name="form3"> <br>
パスワード: <input type="text" placeholder="パスワード" name="deletePW">
<input type="submit" value="削除" name="delete"> <br>

<br>
<hr size="2" width="300" align="left" color="black" noshade   >
<br>

コメントの編集:<input type="text" placeholder="編集対象番号" name="form4"> <br>
パスワード: <input type="text" placeholder="パスワード" name="editPW">
<input type="submit" value="編集" name="edit"><br>
<br>

<hr size="2" width="300" align="left" color="black" noshade   >

</form>
</body>
</html>

<?php
//ブラウザにコメントを表示
if($_POST['delete'] or $_POST['send'] or $_POST['edit']){//ボタンが押されたとき
			$fplast=fopen($filename1,'r');
			$allpost=file($filename1);		//テキストファイルを配列$allpostに入れる[投稿１,投稿２,投稿３...]の状態
			foreach( $allpost as $line ){  			//配列$allpostの中身を一つずつ変数$lineに(１回目$line=投稿1、２回目$line=投稿2の繰り返し)
				$arraylast = explode("<>",$line);			//変数$lineの文字列を<>で分割し、配列$arraylastに格納($varlast[0]が投稿番号)
				echo $arraylast[0]."&emsp;". $arraylast[1]."&emsp;".$arraylast[2] ."&emsp;". $arraylast[3]."<br>";
							   };
			fclose($fplast);
};
?>