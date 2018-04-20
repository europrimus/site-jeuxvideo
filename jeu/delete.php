<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("DELETE FROM jeu WHERE id = :id");
	$stmt->execute(['id' => $_GET['id']]);
	header('Location: list.php');
	exit;
}

require_once('../classes/jeu.class.php');

$stmt = $pdo->prepare("SELECT id, titre FROM jeu WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);
$jeu = $stmt->fetch(PDO::FETCH_ASSOC);

$j = new Jeu();
$j->setId($jeu['id'])
	->setTitre($jeu['titre']);

require_once('../tpl/header.tpl');

?>
<h3>Voulez-vous vraiment supprimer le jeu <?=$j->getTitre()?></h3>
<ul>
	<li><form method="post"><button type="submit" name="confirmation">Oui, je confirme</button></form></li>
	<li><a href="edit.php?id=<?=$j->getId()?>"><button type="button">Non, je veux juste le modifier</button></a></li>
	<li><a href="list.php"><button type="button">Non, je veux retourner à la liste</button></a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');