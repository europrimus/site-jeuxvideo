<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

require_once('../classes/version.class.php');

$stmt = $pdo->prepare("SELECT version.*, jeu.titre titrejeu, console.nom nomconsole
	FROM version
	JOIN jeu ON jeu.id = version.idjeu
	JOIN console ON console.id = version.idconsole
	WHERE version.id = :id");
$stmt->execute(['id' => $_GET['id']]);
$jeu = $stmt->fetch(PDO::FETCH_ASSOC);

$j = new Version();
$j->setId($jeu['id'])
	->setJeu($jeu['titrejeu'])
	->setConsole($jeu['nomconsole'])
	->setDatesortie($jeu['datesortie'])
	->setTypesortie($jeu['typesortie'])
	->setDeveloppeur($jeu['developpeur'])
	->setEditeur($jeu['editeur']);

require_once('../tpl/header.tpl');

?>
<dl>
	<dt>Jeu</dt>
	<dd><?=$j->getJeu()?></dd>
	<dt>Console</dt>
	<dd><?=$j->getConsole()?></dd>
	<dt>Date de sortie</dt>
	<dd><?=$j->getDatesortie(true)?></dd>
	<dt>Type</dt>
	<dd><?=$j->getTypesortie()?></dd>
	<dt>Éditeur</dt>
	<dd><?=$j->getEditeur()?></dd>
	<dt>Développeur</dt>
	<dd><?=$j->getDeveloppeur()?></dd>
</dl>
<ul>
	<li><a href="edit.php?id=<?=$j->getId()?>">Modifier</a></li>
	<li><a href="delete.php?id=<?=$j->getId()?>">Supprimer</a></li>
	<li><a href="list.php">Retourner à la liste</a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');