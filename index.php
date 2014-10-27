<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv = "Content-Type" content="text/html;charset=UTF-8">
<title>FriendsSystem</title>
</head>
<body>

<?php
$dsn = 'mysql:dbname=FriendsDB;host=localhost';
$user = 'root';
$password = 'mangoshake';
$dbh = new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');

$sql ='SELECT * FROM area_table';
$stmt = $dbh->prepare($sql);
$stmt->execute();

$sql_friends = 'SELECT `area_table`.`name`,`area_table`.`number_of_people`,COUNT(`friends_table`.`area_table_id`)';
$sql_friends .= 'AS`counter_area_table` from( SELECT *,\'人数\' AS `number_of_people` FROM `area_table`)';
$sql_friends .= '`area_table` LEFT outer Join `friends_table` on `friends_table`.`area_table_id` = `area_table`.`id`';
$sql_friends .= 'Group by `area_table`.`name`, `area_table`.`number_of_people`Order by `area_table`.`id`';
	//echo $sql;
$stmt_friends = $dbh->prepare($sql_friends);
$stmt_friends->execute();

// print '都道府県一覧';
// while(1)
// {
// 	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
// 	if($rec==false)
// 	{
// 		break;
// 	}
	
// 	print '<table>';
// 	print '<tr>';
// 		print '<td>'.$rec['id'].'</td>';
// 	print'<form method="post"action="friends_list.php">';
// 	print'<input name = '.$rec['name'].' type = "hidden" value = "' .$rec['name'].'">';
// 	print'<a href="friends_list.php">'.$rec['name'].'の友達を表示</a>';
// 	print'</form>';
// 		print '<td>'.$rec['name'].'</td>';
// 	print '</tr>';
// 	print '</table>';
// 	print '<br/>';
// }

//先生の答え
echo '<table>';
while(1)
{
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	$rec_friends = $stmt_friends->fetch(PDO::FETCH_ASSOC);
	if($rec==false)
	{
		break;
	}
	
	echo '<tr>';
		echo  '<td>'.$rec['id'].'</td>';
		echo '<td><a href="friends_list.php?id='.$rec['id'].'">'.$rec['name'].'</a></td>';
		echo  '<td>('.$rec_friends['counter_area_table'].')</td>'; 
	echo '</tr>';
}
echo'</table>';


//データベースから切断する
$dbh = null;
?>

</body>
</html>