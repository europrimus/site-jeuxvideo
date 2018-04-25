<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("DELETE FROM version WHERE id = :id");
	$stmt->execute(['id' => $_GET['id']]);
	header('Location: list.php');
	exit;
}

require_once('../classes/version.class.php');

$stmt = $pdo->prepare("SELECT version.id, COALESCE(version.titre, jeu.titre) titre, console.nom
	FROM version
	JOIN jeu ON jeu.id = version.idjeu
	JOIN console ON console.id = version.idconsole
	WHERE version.id = :id");
$stmt->execute(['id' => $_GET['id']]);
$jeu = $stmt->fetch(PDO::FETCH_ASSOC);

$j = new Version();
$j->setId($jeu['id'])
	->setJeu($jeu['titre'])
	->setConsole($jeu['nom']);

require_once('../tpl/header.tpl');

?>
<h3>Voulez-vous vraiment supprimer la version de <?=$j->getJeu()?> sur <?=$j->getConsole()?></h3>
<ul>
	<li><form method="post"><button type="submit" name="confirmation">Oui, je confirme</button></form></li>
	<li><a href="edit.php?id=<?=$j->getId()?>"><button type="button">Non, je veux juste le modifier</button></a></li>
	<li><a href="list.php"><button type="button">Non, je veux retourner à la liste</button></a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');