<?php
$dsn = 'mysql:dbname=FriendsDB;host=localhost';
$user = 'root';
$password = 'mangoshake';
$dbh = new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');


$id = $_GET['friends_id'];
echo $id;

//SQLで削除する指令をだす
$sql = 'DELETE FROM `friends_table` WHERE `friends_table`.`id` = '.$id;
echo $sql;
//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();
$rec = $stmt->fetch(PDO::FETCH_ASSOC);
//データベースから切断する
$dbh = null;


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv = "Content-Type" content="text/html;charset=UTF-8">
<title>PHP基礎</title>
</head>
<body>

削除しました。<br/>

<a href="index.php">都道府県一覧に戻る</a>

</body>
</html>