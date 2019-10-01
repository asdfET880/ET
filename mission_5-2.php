<?php
$dsn = 'mysql:データベース名;host=localhost';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

if(isset($_POST['comment']) && empty($_POST['secret'])){		//名前・コメント入力
	if($_POST['pass']=="pass"){
		$strn2 = $_POST['name'];
		$strc2 = $_POST['comment'];
		$sql = $pdo -> prepare("INSERT INTO tbmission (name, comment) VALUES (:name, :comment)");
		$sql -> bindParam(':name', $name, PDO::PARAM_STR);
		$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
		$name = $strn2;
		$comment = $strc2;
		$sql -> execute();
	}
	else if($_POST['name']==""){
 		$sql ='SHOW TABLES';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
	}

	else if($_POST['comment']==""){
 		$sql ='SHOW TABLES';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
	}

	else if($_POST['pass']!="pass"){
 		$sql ='SHOW TABLES';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
	}

}


else if(isset($_POST['delete'])){		//消去

	if($_POST['pass2']=="pass2"){
		$dnum = $_POST['delete'];
		$sql = $pdo -> prepare("INSERT INTO tbmission (id,name, comment) VALUES ('$dnum',:name, :comment)");
		$id = $dnum;
		$sql = 'delete from tbmission where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	else if($_POST['delete']==""){
		$sql ='SHOW TABLES';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
	}
	else if($_POST['pass2']!="pass2"){
		$sql ='SHOW TABLES';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
	}
}

else if(isset($_POST['edit'])){	
	if($_POST['pass3']=="pass3"){			//編集行の取得
		$enum = $_POST['edit'];
		$sql ='SHOW TABLES';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			if($row['id'] == $enum){
				//$rowの中にはテーブルのカラム名が入る
				//$enum = $row['id']
				$strn = $row['name'];
				$strc = $row['comment'];
			}
		}
	}
	else if($_POST['edit']==""){
		$sql ='SHOW TABLES';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
	}

	else if($_POST['pass3']!="pass3"){
		$sql ='SHOW TABLES';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
	}
}

else if(isset($_POST['secret']) && $_POST['comment']!="" ){  //編集行書き換え

	if($_POST['pass']=="pass"){
		$strn2 = $_POST['name'];
		$strc2 = $_POST['comment'];
		$enum2 = $_POST['secret'];
		$id = $enum2;
		$name = $strn2;
		$comment = $strc2; //変更したい名前、変更したいコメントは自分で決めること
		$sql = 'update tbmission set name=:name,comment=:comment where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}
	else{
		$sql ='SHOW TABLES';
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
	}
}

?>

<html>
<head>
<meta charset = "utf-8">
</head>
<body>
    <form action="mission_5-1.php" method="post">

	<div><input type="hidden" name="secret"  value="<?php if(isset($enum)){ echo $enum;} ?>" placeholder="確認"><br><input type="hidden" name="comment9"  value="" placeholder=""></div>
       	<div><input type="text" name="name"  value="<?php if(isset($strn)){ echo $strn; }?>" placeholder="名前"><br></div>
	<div><input type="text" name="comment"  value="<?php if(isset($strc)){ echo $strc;} ?>" placeholder="コメント"><br></div>
	<div><input type="password" name="pass"  value="" placeholder="パスワード"><br></div>	

        <button type = "submit">送信</button>
    </form>
    <form action="mission_5-1.php" method="post">
       	<div><input type="number" name="delete"  value="" placeholder="削除対象番号"></div>
	<div><input type="passward" name="pass2"  value="" placeholder="パスワード"><br></div>

        <button type = "submit">削除</button>
    </form>
	<form action="mission_5-1.php" method="post">
       	
	<div><input type="number" name="edit"  value="" placeholder="編集番号指定"></div>
	<div><input type="passward" name="pass3"  value="" placeholder="パスワード"><br></div>

        <button type = "submit">編集</button>
    </form>

</html>
</head>
<?php
if(isset($_POST['comment']) && empty($_POST['secret'])){   //名前・コメント

	if($_POST['pass']=="pass"){
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			///$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}
	else if($_POST['name']==""){
 		echo "名前が入力されていません"."<br>";
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			///$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}

	else if($_POST['comment']==""){
 		echo "コメントが入力されていません"."<br>";
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			///$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}

	else if($_POST['pass']!="pass"){
 		echo "パスワードが入力されていない、または間違っています"."<br>";
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			///$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}

}

else if(isset($_POST['delete'])){           //消去

	if($_POST['pass2']=="pass2"){      
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}
	else if($_POST['delete']==""){
		echo "削除対象番号が入力されていません"."<br>";
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}
	else if($_POST['pass2']!="pass2"){
		echo "パスワードが入力されていない、または間違っています"."<br>";
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}
}

else if(isset($_POST['edit'])){      //編集行取得

	if($_POST['pass3']=="pass3"){
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}
	else if($_POST['edit']==""){
		echo "編集番号が指定されていません"."<br>";
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}

	else if($_POST['pass3']!="pass3"){
		echo "パスワードが入力されていない、または間違っています"."<br>";
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}
}
else if(isset($_POST['secret']) && $_POST['comment']!="" ){    //編集
	if($_POST['pass']=="pass"){
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}
	else{
		echo "もう一度編集番号指定からやり直してください"."<br>";
		$sql = 'SELECT * FROM tbmission';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		foreach ($results as $row){
			//$rowの中にはテーブルのカラム名が入る
			echo $row['id'].',';
			echo $row['name'].',';
			echo $row['comment'].'<br>';
			echo "<hr>";
		}
	}
}


?>