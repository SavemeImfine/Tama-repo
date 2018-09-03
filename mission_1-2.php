<?php
$filename='mission_1-2_Tamakawa.txt';	//ファイル名の定義
$fp=fopen($filename,'w');//ファイルをオープンして処理できる状態にする。wの意味は書き出しのみでオープンするということ。ファイルポインタをファイルの先頭に置き、ファイルサイズをゼロにする。ファイルが存在しない場合には、 作成を試みる。
fwrite($fp,'Hello World!');	//ファイルポインタにHello worldと書き込む。
fclose($fp);	//ファイルポインタを閉じる。
?>