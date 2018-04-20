<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

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
<dl>
	<dt>Titre</dt>
	<dd><?=$j->getTitre()?></dd>
	<dt>Année</dt>
	<dd><?=$j->getAnnee()?></dd>
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