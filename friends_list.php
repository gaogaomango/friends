<?php
$dsn = 'mysql:dbname=FriendsDB;host=localhost';
$user = 'root';
$password = 'mangoshake';
$dbh = new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');


$area_id = $_GET['id'];

//削除フラグの状態を調べて、存在する場合削除処理を行う。
if(isset($_GET['del_flag'])){
	$del_sql = 'DELETE FROM `friends_table` WHERE `id` = '.$_GET['friends_id'];
	//echo $sql;
	$del_stmt = $dbh->prepare($del_sql);
	$del_stmt->execute();
	$rec = $del_stmt->fetch(PDO::FETCH_ASSOC);
}

//男性の数
$number_of_male = 0;

//女性の数
$number_of_female = 0;

//SQLで選んだ都道府県の友達を選択する指令をだす
$sql_friends = 'SELECT * FROM `friends_table` WHERE `area_table_id` = '.$area_id;
//echo $sql;
$stmt2 = $dbh->prepare($sql_friends);

$stmt2->execute();

//配列の初期化
$friends_array = array();

while(1){
	$rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
	if ($rec2 == false) {
		break;
	}
	$friends_array[] = $rec2; 

	if ($rec2['gender'] == '男'){
		$number_of_male += 1;
	}else{
		$number_of_female += 1;
	}
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv = "Content-Type" content="text/html;charset=UTF-8">
<title>PHP基礎</title>
<script type="text/javascript">//javascriptの書き方
	function fnc_delbutton(area_id,friends_id){
		if(confirm ('削除しますか？')){
			location.href = 'friends_list.php?id=' + $area_id +'&friends_id=' + $friends_each['id'] +'&del_flag=1';
		
			return = true;
		}

		return false;
	}
</script>
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

// $sql ='SELECT * FROM `friends_table` WHERE `area_table_id` = '.$area_id;
// 	//echo $sql;
// $stmt = $dbh->prepare($sql);
// $stmt->execute();

$sql_name ='SELECT name FROM `area_table` WHERE `id` = '.$area_id;
	//echo $sql;
$stmt_name = $dbh->prepare($sql_name);
$stmt_name->execute();
$area_name = $stmt_name->fetch(PDO::FETCH_ASSOC);


//うまく行かなかったSQL文、二つの性別を結合させたかった
// $sql_friends_men = 'SELECT `area_table`.`name`,`area_table`.`gender_type_men`, COUNT(`friends_table`.`gender`)';
// $sql_friends_men .= 'AS`counter_gender_men` from( SELECT *,\'男\'AS `gender_type_men` FROM `area_table`)';
// $sql_friends_men .='`area_table` LEFT outer Join `friends_table` on `friends_table`.`area_table_id` = `area_table`.`id` ';
// $sql_friends_men .='Group by `area_table`.`name`,`area_table`.`gender_type_men` Order by `area_table`.`id`';

// $sql_friends_women = 'SELECT `area_table`.`name`,`area_table`.`gender_type_women`, COUNT(`friends_table`.`gender`)';
// $sql_friends_women .= 'AS`counter_gender_women` from( SELECT *,\'女\'AS `gender_type_women` FROM `area_table`)';
// $sql_friends_women .='`area_table` LEFT outer Join `friends_table` on `friends_table`.`area_table_id` = `area_table`.`id` ';
// $sql_friends_women .='Group by `area_table`.`name`,`area_table`.`gender_type_women` Order by `area_table`.`id`';

// $stmt_friends_men = $dbh->prepare($sql_friends_men);
// $stmt_friends_men->execute();
// $rec_friends_men = $stmt_friends_men->fetch(PDO::FETCH_ASSOC);

// $stmt_friends_women = $dbh->prepare($sql_friends_women);
// $stmt_friends_women->execute();
// $rec_friends_women = $stmt_friends_women->fetch(PDO::FETCH_ASSOC);

//echo $sql_friends_men;
//echo $sql_friends_women;

echo $area_name['name'].'のお友達リスト<br/>';
echo '男性'.$number_of_male.'名、女性'.$number_of_female.'名<br/>';
// echo '男性'.$rec_friends_men['counter_gender_men'].':名<br/>'; //10/26日分のテキストの参照
// echo '女性'.$rec_friends_women['counter_gender_women'].':名<br/>';

//先生の解答男性、女性の数をそれぞれ出す方法


//echo '<ul>';
// while(1)
// {
// 	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
// 	if($rec==false)
// 	{
// 		break;
// 	}
	
// 	echo '<li>';
// 	echo  $rec['name'];
// 	echo '<td><input type ="button" value="編集" onclick= "location.href=\'friends_update.php?friends_id='.$rec['id'].'\'"></td>';
// 	echo '</li>';

// }
echo '<ul>';
foreach ($friends_array as $friends_each) {
	echo '<li>';
	echo $friends_each['name'];
	echo '<input type="button" value="編集" onclick="location.href=\'friends_update.php?friends_id='.$friends_each['id'].'\'">';
	echo '<input type="button" value="削除画面に飛ばすやり方で削除" onclick="location.href=\'friends_delete.php?friends_id='.$friends_each['id'].'\'">';
	

	//echo '<input type="button" value="削除画面に飛ばさずに削除" onclick="if (confirm (\'削除しますか？\'))location.href=\'friends_list.php?id='.$area_id.'&friends_id='.$friends_each['id'].'&del_flag=1\'">';	
	//関数を呼び出して削除
	echo'<input type="button" value="関数を使って削除" onclick="fnc_delbutton('.$area_id.','.$friends_each['id'].');">';

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