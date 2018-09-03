<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<html>
<body>
<form action="mission_1-4.php" method="post">
<input type="text" name="com" value="コメント">
<input type="submit" value="送信" name="sub">
</form>
<?php
if (isset($_POST['sub'])) {
$htmlspecialchars = $_POST['com'];
$date=date('Y年m月d日H時i分');
echo"ご入力ありがとうございます。<br>".$date."に".$htmlspecialchars."を受け付けました。";}
?>
</body>
</html>