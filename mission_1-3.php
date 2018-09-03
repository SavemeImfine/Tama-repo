<?php
$filename='mission_1-2_Tamakawa.txt';	//ファイルを変数に格納
$content=file_get_contents ($filename);// ファイルを読み込み変数に格納
echo $content; //中身を表示する
?>