<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

require_once('../classes/dlc.class.php');

$stmt = $pdo->prepare("SELECT dlc.*, jeu.titre titrejeu
	FROM dlc
	JOIN jeu ON jeu.id = dlc.idjeu
	WHERE dlc.id = :id");
$stmt->execute(['id' => $_GET['id']]);
$jeu = $stmt->fetch(PDO::FETCH_ASSOC);

$j = new Dlc();
$j->setId($jeu['id'])
	->setJeu($jeu['titrejeu'])
	->setTitre($jeu['titre'])
	->setTypecontenu($jeu['typecontenu']);

require_once('../tpl/header.tpl');

?>
<dl>
	<dt>Jeu</dt>
	<dd><?=$j->getJeu()?></dd>
	<dt>Titre</dt>
	<dd><?=$j->getTitre()?></dd>
	<dt>Type de contenu</dt>
	<dd><?=$j->getTypecontenu()?></dd>
</dl>
<ul>
	<li><a href="edit.php?id=<?=$j->getId()?>">Modifier</a></li>
	<li><a href="delete.php?id=<?=$j->getId()?>">Supprimer</a></li>
	<li><a href="list.php">Retourner à la liste</a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');