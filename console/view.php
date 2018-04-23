<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

require_once('../classes/console.class.php');

$stmt = $pdo->prepare("SELECT * FROM console WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);
$console = $stmt->fetch(PDO::FETCH_ASSOC);

$c = new Console();
$c->setId($console['id'])
	->setNom($console['nom'])
	->setSigle($console['sigle'])
	->setPuissance($console['puissance'])
	->setDatesortie($console['datesortie'])
	->setConstructeur($console['constructeur']);

require_once('../tpl/header.tpl');

?>
<dl>
	<dt>Nom</dt>
	<dd><?=$c->getNom()?></dd>
	<dt>Sigle</dt>
	<dd><?=$c->getSigle()?></dd>
	<dt>Puissance</dt>
	<dd><?=$c->getPuissance()?></dd>
	<dt>Constructeur</dt>
	<dd><?=$c->getConstructeur()?></dd>
	<dt>Date de sortie</dt>
	<dd><?=$c->getDatesortie(true)?></dd>
</dl>
<ul>
	<li><a href="edit.php?id=<?=$c->getId()?>">Modifier</a></li>
	<li><a href="delete.php?id=<?=$c->getId()?>">Supprimer</a></li>
	<li><a href="list.php">Retourner à la liste</a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');