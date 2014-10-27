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

$sql_friends = 'SELECT `area_table`.`name`,`area_table`.`gender_type`, COUNT(`friends_table`.`gender`)';
$sql_friends .= 'AS`counter_gender`from( SELECT *,\'男\'AS `gender_type` FROM `area_table` UNION SELECT *,\'女\'AS `gender_type` FROM `area_table`)';
$sql_friends .= '`area_table` LEFT outer Join `friends_table` on `friends_table`.`area_table_id` = `area_table`.`id`';
$sql_friends .= 'Group by `area_table`.`name`,`area_table`.`gender_type` WHERE '.$area_id.' Order by `area_table`.`id`';

$stmt_friends = $dbh->prepare($sql_friends);
$stmt_friends->execute();
$rec_friends = $stmt->fetch(PDO::FETCH_ASSOC);

echo $sql_friends;

echo $rec_friends['name'].'のお友達リスト<br/>';
echo '男性'.$rec_friends['counter_gender'].':名<br/>';
echo '女性'.$rec_friends['counter_gender'].':名<br/>';

//先生の解答男性、女性の数をそれぞれ出す方法


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