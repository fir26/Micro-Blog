<?php
	include('includes/haut.inc.php');
	include('includes/connexion.inc.php');
?>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-text">
                        <span class="name">Le fil</span>
                        <hr class="star-light">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section>
        <div class="container">
            <div class="row">              
                <form method="POST" action="message.php?a=add">
                    <div class="col-sm-10">  
                        <div class="form-group">
                            <textarea id="message" name="message" class="form-control" placeholder="Message"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success btn-lg">Envoyer</button>
                    </div>                        
                </form>
            </div>
			


            <div class="row">
                <div class="col-md-12">
					<?php
						$sql="SELECT * FROM messages";
						$stmt=$pdo->query($sql);
						while($data=$stmt->fetch()) {
					?>
					<blockquote>
						<p>
					<?php echo $data['contenu']; ?>
                            
						</p>
						<footer>
					<?php echo date('d/m/Y H:i:s',$data['date']); ?>
						</footer>
                    <span><a href="message.php?a=sup&id=<?= $data['id'] ?>">Supprimer</a>
                        <a href="index.php?id=<?= $data['id'] ?>">Modifier</a></span>
                        <?php
                            if(isset($_GET['id'])){
                        ?>
                                <div class="form-group">
                                    <textarea id="message" name="message" class="form-control" placeholder="Message"></textarea>
                                </div>
                        
                        <?php
                            }
                        ?>
                        
                        
                    </blockquote>
					<?php
						}
					?>
                </div>
            </div>
        </div>
    </section>

<?php
	include('includes/bas.inc.php');
?>