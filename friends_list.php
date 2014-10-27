<?php
$dsn = 'mysql:dbname=FriendsDB;host=localhost';
$user = 'root';
$password = 'mangoshake';
$dbh = new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv = "Content-Type" content="text/html;charset=UTF-8">
<title>PHP基礎</title>
</head>
<body>

<?php
// 	$dsn = 'mysql:dbname=FriendsDB;host=localhost';
// 	$user = 'root';
// 	$password = 'mangoshake';
// 	$dbh = new PDO($dsn,$user,$password);
// 	$dbh->query('SET NAMES utf8');



// print '北海道の友達';
// while(1)
// {
// 	$sql ='SELECT * FROM friends_table group by area_table_id';
// 	$stmt = $dbh->prepare($sql);
// 	$stmt->execute();

// 	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
// 	if($rec==false)
// 	{
// 		break;
// 	}
	
// 	print '<ul>';
// 	print '<li>'.$rec['name'].'</li>';
// 	print '</ul>';
// //	print '<br/>';
// }



//$dbh = null;



//先生の答え
?>

<?php

$area_id = $_GET['id'];


	$sql ='SELECT * FROM `friends_table` WHERE `area_table_id` = '.$area_id;
	//echo $sql;
	$stmt = $dbh->prepare($sql);
	$stmt->execute();
echo '<ul>';
while(1)
{
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false)
	{
		break;
	}
	
	echo '<li>';
	echo  $rec['name'];
	echo '<td><input type ="button" value="編集" onclick= "location.href=\'friends_update.php?friends_id='.$rec['id'].'\'"></td>';
	echo '</li>';

}
echo'</ul>';
echo '<tr>';
echo '<td><a href="friends_add.php?area_id='.$area_id.'">追加</a></td>';
echo '</tr><br/>';


//データベースから切断する
$dbh = null;

?>
<a href="index.php">都道府県一覧に戻る</a>

<input type="button" value="追加" onclick="location.href='friends_add.php'">
</body>
</html>