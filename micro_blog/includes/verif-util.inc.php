<?php
	include("connexion.inc.php");

	
	if(isset($_COOKIE['sid'])){
		$connect_util=true;
		$sql="SELECT email FROM utilisateurs where sid=:sid";
		$stmt=$pdo->prepare($sql);
		$stmt->bindValue(':sid',$_COOKIE['sid']);
		$stmt->execute();
		while($data=$stmt->fetch()){
			$email_util=$data['email'];
		}
	}
	else{
		$connect_util=false;
	}

?>