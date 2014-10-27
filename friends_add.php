<?php
$dsn = 'mysql:dbname=FriendsDB;host=localhost';
$user = 'root';
$password = 'mangoshake';
$dbh = new PDO($dsn,$user,$password);
$dbh->query('SET NAMES utf8');

$area_id = $_GET['area_id'];

if(isset($_POST['name'])){
	echo 'POST送信された！';
$name = $_POST['name'];
$gender = $_POST['gender'];
$age = $_POST['age'];
	//INSERT文

$sql = 'INSERT INTO friends_table (area_table_id,name,gender,age) VALUE("';
$sql .= $area_id.'","'.$name.'","'.$gender.'","'.$age.'")';

$stmt = $dbh->prepare($sql);
$stmt->execute();
//処理が全て終わった後、都道府県一覧に戻る
	header('Location: http://' .$_SERVER['HTTP_HOST'] .'/friends/index.php');

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



$sql ='SELECT * FROM `area_table`';
	//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();

?>
 <form method="post">
	名前
<input name = "name" type = "text"style="width:100px ;height:30px"><br/>
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
	if($area_id== $rec['id']){
	
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
	<option value="男">男性</option>
	<option value="女">女性</option>
</select><br/>
	年齢
<input name="age" type="text" style="width:300px"><br/>
	<br/>
<input type="submit"value="保存" onclick="location.href='friends_list.php'">
<input type="submit"value="キャンセル" onclick="location.href='friends_list.php'">
</form>

<?php

$dbh = null;


?>
</body>
</html>