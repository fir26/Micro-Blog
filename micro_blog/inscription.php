<?php
	include("includes/connexion.inc.php");

	if(isset($_POST['email']) && isset($_POST['checkbox'])) {
		$stmt = $pdo->prepare('SELECT COUNT(*) FROM utilisateurs WHERE email = ?');
		$stmt->execute(array($_POST['email']));
			if ($stmt->fetchColumn() != 0) {
				echo "Email déjà inscrit (Vous allez être redirigé...)";
				echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>";
			}else{
				$sql="INSERT INTO utilisateurs (email,mdp) VALUES (:email,:mdp)";
				$prep=$pdo->prepare($sql);
				$prep->bindValue(':email',$_POST['email']);
				$prep->bindValue(':mdp',md5($_POST['password']));
				$prep->execute();


			header("location:index.php");
		}
	}
	else {
		include("includes/haut.inc.php");
?>
<br><br><br><br><br><br>
<section>
	<div class="container">
		<p>Inscription:</p>
		<form class="form-horizontal" action="inscription.php" method="POST">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email">
				</div>
			</div>
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">
					<input type="password" class="form-control" id="inputPassword3" name="password" placeholder="Password">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<div class="checkbox">
						<label>
							<input type="checkbox" name="checkbox"> Valider Inscription </input>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" class="btn btn-default" value="Inscription">
				</div>
			</div>
		</form>
	</div>
</section>
<?php
		include("includes/bas.inc.php");
	}
?>
