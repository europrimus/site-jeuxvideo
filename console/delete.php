<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("DELETE FROM console WHERE id = :id");
	$stmt->execute(['id' => $_GET['id']]);
	header('Location: list.php');
	exit;
}

require_once('../classes/console.class.php');

$stmt = $pdo->prepare("SELECT id, nom FROM console WHERE id = :id");
$stmt->execute(['id' => $_GET['id']]);
$console = $stmt->fetch(PDO::FETCH_ASSOC);

$c = new Console();
$c->setId($console['id'])
	->setNom($console['nom']);

require_once('../tpl/header.tpl');

?>
<h3>Voulez-vous vraiment supprimer la console <?=$c->getNom()?></h3>
<ul>
	<li><form method="post"><button type="submit" name="confirmation">Oui, je confirme</button></form></li>
	<li><a href="edit.php?id=<?=$c->getId()?>"><button type="button">Non, je veux juste la modifier</button></a></li>
	<li><a href="list.php"><button type="button">Non, je veux retourner à la liste</button></a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');