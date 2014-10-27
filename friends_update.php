<?php
$dsn = 'mysql:dbname=FriendsDB;host=localhost';
$user = 'root';
$password = 'mangoshake';
$dbh = new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');

//$area_id = $_GET['area_id'];
$friends_id = $_GET['friends_id'];

if(isset($_POST['name'])){
	echo 'POST送信された！';
	$area_table_id = $_POST['area_table_id'];
	$name = $_POST['name'];
	$gender = $_POST['gender'];
	$age = $_POST['age'];
	
$sql = 'UPDATE friends_table SET ';
$sql .= 'area_table_id =' .$area_table_id.',name = "'.$name.'",gender ="';
$sql .= $gender.'",age ='.$age.' WHERE id ='.$friends_id;
//echo $sql;

$stmt = $dbh->prepare($sql);
$stmt->execute();
//insert文が入るところ

}else{
	echo 'POST送信されてない';
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<meta http-equiv = "Content-Type" content="text/html;charset=UTF-8">
<title>入力フォーム</title>
</head>
<body>

<?php



$sql_friends ='SELECT * FROM `friends_table` WHERE id =' .$friends_id;
	//echo $sql;
$stmt_friends = $dbh->prepare($sql_friends);
$stmt_friends->execute();
$rec_friends = $stmt_friends->fetch(PDO::FETCH_ASSOC);

$area_table_id = $rec_friends['area_table_id'];
$name = $rec_friends['name'];
$gender = $rec_friends['gender'];
$age = $rec_friends['age'];


$sql ='SELECT * FROM `area_table`';
$stmt = $dbh->prepare($sql);
$stmt->execute();


?>
  <form method="post">
	名前
	<input name = "name" type = "text"style="width:100px ;height:30px;"maxlength="20" value="<?php echo $name; ?>"><br/>
	出身地
	<select name="area_table_id">
	<?php
while(1)
{
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	if($rec==false)
	{
		break;
	}
	if($area_table_id== $rec['id']){
	
		echo '<option value="'.$rec['id'].'" selected>';
	
	}else{
	
		echo '<option value="'.$rec['id'].'">';
	
	}
	echo $rec['name'];
	echo '</option>';
}	
	?>
	</select><br/>
	性別
	<select name="gender">
		<?php
		if($gender == '男'){
		echo '<option value="男" selected>男性</option>';
		echo '<option value="女">女性</option>';
		}else{
		echo '<option value="男">男性</option>';
		echo '<option value="女" selected>女性</option>';
		}
		?>
	</select><br/>
	年齢
	<input name = "age" type = "text"style="width:100px ;height:30px;"maxlength="10" value="<?php echo $age; ?>"><br/>
	<br/>
	<input type="submit"value="保存" onclick="location.href='friends_list.php'">
	<input type="submit"value="キャンセル" onclick="location.href='friends_list.php'">
</form>

<?php

$dbh = null;


?>
</body>
</html>