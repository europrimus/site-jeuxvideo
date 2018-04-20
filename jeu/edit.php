<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("UPDATE jeu SET titre = :titre, annee = :annee, developpeur = :developpeur, editeur = :editeur WHERE id = :id");
	$stmt->execute([
		'id' => $_GET['id'],
		'titre' => $_POST['titre'],
		'annee' => $_POST['annee'],
		'developpeur' => $_POST['developpeur'],
		'editeur' => $_POST['editeur']
	]);
	header('Location: view.php?id='.$_GET['id']);
	exit;
}

require_once('../classes/jeu.class.php');

$stmt = $pdo->prepare("SELECT * FROM jeu WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);
$jeu = $stmt->fetch(PDO::FETCH_ASSOC);

$j = new Jeu();
$j->setId($jeu['id'])
	->setTitre($jeu['titre'])
	->setAnnee($jeu['annee'])
	->setDeveloppeur($jeu['developpeur'])
	->setEditeur($jeu['editeur']);

require_once('../tpl/header.tpl');

?>
<form method="POST">
	<dl>
		<dt>Titre</dt>
		<dd><input type="text" name="titre" value="<?=$j->getTitre()?>"></dd>
		<dt>Année</dt>
		<dd><input type="number" name="annee" value="<?=$j->getAnnee()?>"></dd>
		<dt>Éditeur</dt>
		<dd><input type="text" name="editeur" value="<?=$j->getEditeur()?>"></dd>
		<dt>Développeur</dt>
		<dd><input type="text" name="developpeur" value="<?=$j->getDeveloppeur()?>"></dd>
	</dl>
	<input type="submit" name="confirmation" value="Modifier">
</form>
<ul>
	<li><a href="view.php?id=<?=$j->getId()?>">Annuler les modifications</a></li>
	<li><a href="delete.php?id=<?=$j->getId()?>">Supprimer</a></li>
	<li><a href="list.php">Retourner à la liste</a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');