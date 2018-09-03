<?php
//文字コードの指定
header('Content-Type: text/html; charset=UTF-8');

//データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';		//ユーザー名とパスワードをコンストラクタの2番目と3番目の引数
$pdo = new PDO($dsn,$user,$password);

//テーブルの作成(4-1-a)
$sql1 = "CREATE TABLE mission4"	//mission4というテーブルを作成
. " ("
. "id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"		//投稿番号が挿入されるカラム名（列のタイトル）をidとした。AUTO_INCREMENT NOT NULL PRIMARY KEYとすると自動的に番号が１から振られる。INT...そのフィールドには整数値のみ入力可能
. "namae TEXT,"		//TEXT...テキストのみ入力可能、
. "komento TEXT,"	//コメントが挿入されるカラム名komento
. "date TEXT,"//日にちが挿入かれるカラム名date
. "pass TEXT"//パスワードが挿入されるカラム名pass
.");";
$stmt1 = $pdo->query($sql1);		//query() は、指定したSQL文をデータベースに対して発行し、返された結果セット を PDOStatement オブジェクトとして返す。->は左辺から右辺を取り出す演算子.5つのカラムを持ったテーブル「mission４」が作成される.

//フォームで送信された内容の取り込み
$yourname=($_POST['nameform']);		//氏名
$yourcomment=($_POST['commentform']);		//コメント
$yourpass=($_POST['passform']);	//投稿時に登録するパスワード
$sakujono=($_POST['deleteno']);		//削除対象番号
$deletepass=($_POST['deletepass']);	//削除確認パスワード
$henshuno=($_POST['editno']);		//編集対象番号
$editpass=($_POST['editpass']);	//編集確認パスワード
$check=($_POST['check']);		//編集中の番号

//日時を変数として取り込む
$hinichi=date('Y年m月d日H:i:s');


//新規書き込み

if($_POST['send']&&! $_POST['delete'] && !$_POST['edit']&&empty($check)){ 	//送信ボタン押されたとき
	if (!empty($yourname)&&!empty($yourcomment)&&!empty($yourpass)) {   //さらにその中で、氏名とコメント,パスワードが空欄でないとき
	　　//(4-1-d)
			$sql4 = $pdo -> prepare("INSERT INTO mission4(namae,komento,date,pass) VALUES (:namae,:komento, :date,:pass)");//prepare()...SQLを準備します。Toukouというテーブルのカラム（name,value）のそれぞれに対して VALUES (:name, :value) のように:name と :value というパラメータを与えています。ここの値が変わっても何回でもこのSQLを使えるようになっています。
			$sql4-> bindParam(':namae', $namae, PDO::PARAM_STR);
			$sql4 -> bindParam(':komento', $komento, PDO::PARAM_STR);	
			$sql4-> bindParam(':date', $date, PDO::PARAM_STR);	
			$sql4-> bindParam(':pass', $pass, PDO::PARAM_STR);//PDO::PARAM_STR...SQL CHAR, VARCHAR, または他の文字列データ型を表します。
			//ここで、:namae とかのパラメータに値を入れてます。 bindParam は (':namae', $namae, PDO::PARAM_STR) のように、一個目で :name のようにさっき与えたパラメータを指定。２個目に、それに入れる変数を指定します。bindParam には直接数値を入れれない。変数のみです。３個目で型を指定。PDO::PARAM_STR は文字列であるという事。
			$namae = $yourname;//名前
			$komento = $yourcomment; //コメント
			$date = $hinichi;//日にち
			$pass= $yourpass; //パスワード
			$sql4 -> execute();
	};
};


//投稿削除
if($_POST['delete']&&! $_POST['send'] && !$_POST['edit']){		//削除ボタンが押された時
	if(!empty($sakujono)&& !empty($deletepass)){		//さらに削除対象番号が記入されている場合
				//パスワードが一致しているか確認
				$sqldele= 'SELECT * FROM mission4';//テーブルの中身を取り出す
				$resultsdele = $pdo -> query($sqldele);//sql文を実行
				foreach ($resultsdele as $rowdele){
							if($rowdele['id']==$sakujono && $rowdele['pass']==$deletepass){//もし投稿番号が削除番号と一致しているかつパスワードが一致したら
								echo "【投稿番号".$sakujono."の内容が削除されました】";
								//投稿削除(4-1-g)
								$deleteid = $sakujono;
								$sqldelete = "delete from mission4 where id=$deleteid";
								$resultdelete = $pdo->query($sqldelete);
							};
				};					
	};
};

//投稿編集
//①フォームに編集対象の投稿を表示する
if(!$_POST['delete']&&! $_POST['send']&& $_POST['edit']){//編集ボタンが押されたとき
			if(!empty($henshuno)&& !empty($editpass)){	//編集対象番号とパスワードが入力されている場合
						$sqledit1= 'SELECT * FROM mission4';//テーブルの中から投稿番号が一致している箇所を検索
						$resultsedit1 = $pdo -> query($sqledit1);//sql文を実行
						foreach ($resultsedit1 as $rowedit1){
								if($rowedit1['id']==$henshuno && $rowedit1['pass']==$editpass){
												$data0 = $rowedit1['id'];	//[0]は投稿番号[1]は名前[2]はコメント
												$data1 = $rowedit1['namae'];
												$data2 = $rowedit1['komento'];//フォームに表示する変数をおいた。
												echo "【内容を編集し、新しくパスワードを設定してください。】";							
								};
						};					
			};
};
//②ファイルに投稿を上書き
if($_POST['send']&&! $_POST['delete']&&! $_POST['edit']&&!empty($check)){ //編集投稿番号が表示された状態で送信ボタンが押されたとき
		if (!empty($yourname)&&!empty($yourcomment)&&!empty($yourpass)) { 		//さらにその中で、氏名とコメント、パスワードが空欄でないと
				$editid = $check;//投稿番号、編集後の名前、コメント、パスワードを変数でおく
				$editnamae = $yourname;
				$editkomento = $yourcomment; 
				$editpass = $yourpass;
				//(4-1-f)
				$sqledit= "update mission4 set namae='$editnamae' , komento='$editkomento' ,date='$hinichi', pass='$editpass' where id = $editid";
				$resultedit = $pdo->query($sqledit);
				echo "【投稿番号".$editid."の内容が編集されました】";
		};
};

?>

<html>
<meta http-equiv="content-type" charset="utf-8">
<body>
<form action="mission_4-1.php" method="post">
<hr size="2" width="300" align="left" color="black" noshade   >
<!-- -->
<!--新規投稿用フォーム -->
<br>
名前:<input type="text" name="nameform"  value="<?php echo $data1;?>" placeholder="名前" > <br>
<!-- value="<?php echo $data1;?>"としておくと、編集機能の時に前の投稿内容が表示される。placeholder="名前"は新規書き込みの時に薄文字で表示（空欄扱い）-->
コメント:<input type="text" name="commentform"  value="<?php echo $data2;?>" placeholder="コメント" > <br>
パスワード: <input type="text" placeholder="パスワード" name="passform">
<input type="submit" value="送信" name="send">
<br>
<!--編集対象番号表示フォーム」-->
<input type="hidden" name="check"  value="<?php echo $data0;?>"> 
<br>
<hr size="2" width="300" align="left" color="black" noshade   >
<br>
<!--コメント削除用フォーム -->
コメントの削除:<input type="text" placeholder="削除対象番号" name="deleteno"> <br>
パスワード: <input type="text" placeholder="パスワード" name="deletepass">
<input type="submit" value="削除" name="delete"> <br>
<br>
<hr size="2" width="300" align="left" color="black" noshade   >
<br>
<!--コメント編集用フォーム -->
コメントの編集:<input type="text" placeholder="編集対象番号" name="editno"> <br>
パスワード: <input type="text" placeholder="パスワード" name="editpass">
<input type="submit" value="編集" name="edit"><br>
<br>
<hr size="2" width="300" align="left" color="black" noshade   >
</form>
</body>
</html>

<?php
header('Content-Type: text/html; charset=UTF-8');//文字コードの指定

//データベースへの接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';		//ユーザー名とパスワードをコンストラクタの2番目と3番目の引数
$pdo = new PDO($dsn,$user,$password);

//ブラウザにコメントを表示(4-1-e)
if($_POST['send'] or $_POST['delete'] or $_POST['edit']){//ボタンが押されたら
			$sql5 = 'SELECT * FROM mission4 ORDER BY id ASC';//指定したテーブル内の中身を投稿番号順に並べ替えて取り出す
			$results5 = $pdo -> query($sql5);//sql5を実行
			foreach ($results5 as $row5){//$rowの中にはテーブルのカラム名が入る
			echo $row5['id'].'&emsp;';
			echo $row5['namae'].'&emsp;';
			echo $row5['komento'].'&emsp;';
			echo $row5['date'].'<br>';
			};
};
?>