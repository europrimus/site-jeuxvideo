<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("UPDATE jeu SET titre = :titre WHERE id = :id");
	$stmt->execute([
		'id' => $_GET['id'],
		'titre' => $_POST['titre']
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
	->setTitre($jeu['titre']);

require_once('../tpl/header.tpl');

?>
<form method="POST">
	<dl>
		<dt>Titre</dt>
		<dd><input type="text" name="titre" value="<?=$j->getTitre()?>"></dd>
	</dl>
	<input type="submit" name="confirmation" value="Modifier"> <a href="view.php?id=<?=$j->getId()?>"><button type="button">Annuler les modifications</button></a>
</form>
<ul>
	<li><a href="delete.php?id=<?=$j->getId()?>">Supprimer</a></li>
	<li><a href="list.php">Retourner à la liste</a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');