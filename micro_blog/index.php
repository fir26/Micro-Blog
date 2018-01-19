<?php
	include('includes/haut.inc.php');
	include('includes/connexion.inc.php');
	include('includes/verif_util.inc.php');

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
                <form method="POST" action="article.php<?php if(isset($_GET['id'])) echo "?a=upd&id=".$_GET['id']; ?>">
                    <div class="col-sm-10">
                        <div class="form-group">
							<textarea id="message" name="message" class="form-control" placeholder="Message"><?php if(isset($_GET['id'])) { $sql="SELECT contenu FROM messages WHERE id=:id";$prep=$pdo->prepare($sql);$prep->bindValue(':id',$_GET['id']);$prep->execute();$data=$prep->fetch();echo $data['contenu']; } ?></textarea>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <button type="submit" class="btn btn-success btn-lg" <?php if(!$connect_util) echo "disabled"; ?>>
							<?php if(isset($_GET['id'])) { ?>
							Modifier
							<?php } else { ?>
							Envoyer
							<?php } ?>
						</button>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col-md-12">
					<?php
						$page = (!empty($_GET['page']) ? $_GET['page'] : 1);
						$limite = 5;
						$debut = ($page - 1) * $limite;
						$query = 'SELECT * FROM messages LIMIT :limite OFFSET :debut';
						$query = $pdo->prepare($query);
						$query->bindValue('limite', $limite, PDO::PARAM_INT);
						/* On lie aussi la valeur */
						$query->bindValue('debut', $debut, PDO::PARAM_INT);
						$query->execute();
						while ($data = $query->fetch()) {
					?>
					<blockquote>
						<p><?= $data['contenu'] ?></p>
						<footer><?= date('d/m/Y H:i:s',$data['date']) ?></footer>
                    </blockquote>
					<?php
							if($connect_util) {
					?>
					<a href="index.php?id=<?= $data['id'] ?>" class="btn btn-primary btn-xs">Modifier</a>
					<a href="article.php?a=del&id=<?= $data['id'] ?>" class="btn btn-danger btn-xs">Supprimer</a>
					<?php
							}
					?>
					<hr>
					<?php
						}
					?>
                </div>
            </div>
        </div>
    </section>
		<?php
		// Partie "Requête"
$debut = ($page - 1) * $limite;
/* Ne pas oublier d'adapter notre requête */
$query = 'SELECT SQL_CALC_FOUND_ROWS * FROM `my_table` LIMIT :limite OFFSET :debut';
$query = $pdo->prepare($query);
$query->bindValue('debut', $debut, PDO::PARAM_INT);
$query->bindValue('limite', $limite, PDO::PARAM_INT);
$query->execute();

/* Ici on récupère le nombre d'éléments total. Comme c'est une requête, il ne
 * faut pas oublier qu'on ne récupère pas directement le nombre.
 * De plus, comme la requête ne contient aucune donnée client pour fonctionner,
 * on peut l'exécuter ainsi directement */
$resultFoundRows = $pdo->query('SELECT found_rows()');
/* On doit extraire le nombre du jeu de résultat */
$nombredElementsTotal = $resultFoundRows->fetchColumn();
		// Partie "Liens"
		/* On calcule le nombre de pages */
		$nombreDePages = ceil($nombredElementsTotal / $limite);

		/* Si on est sur la première page, on n'a pas besoin d'afficher de lien
		 * vers la précédente. On va donc l'afficher que si on est sur une autre
		 * page que la première */
		if ($page > 1):
		    ?><a href="?page=<?php echo $page - 1; ?>">Page précédente</a> — <?php
		endif;

		/* On va effectuer une boucle autant de fois que l'on a de pages */
		for ($i = 1; $i <= $nombreDePages; $i++):
		    ?><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a> <?php
		endfor;

		/* Avec le nombre total de pages, on peut aussi masquer le lien
		 * vers la page suivante quand on est sur la dernière */
		if ($page < $nombreDePages):
		    ?>— <a href="?page=<?php echo $page + 1; ?>">Page suivante</a><?php
		endif;
		?>

<?php
	include('includes/bas.inc.php');
?>
