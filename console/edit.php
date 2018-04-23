<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("UPDATE console SET nom = :nom, sigle = :sigle, puissance = :puissance, datesortie = :datesortie, constructeur = :constructeur WHERE id = :id");
	$ok = $stmt->execute([
		'id' => $_GET['id'],
		'nom' => $_POST['nom'],
		'sigle' => $_POST['sigle'],
		'puissance' => $_POST['puissance'],
		'datesortie' => $_POST['datesortie'],
		'constructeur' => $_POST['constructeur']
	]);
	if (!$ok) {
		var_dump($stmt->errorInfo());
		exit;
	}
	header('Location: view.php?id='.$_GET['id']);
	exit;
}

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
<form method="POST">
	<dl>
		<dt>Nom</dt>
		<dd><input type="text" name="nom" value="<?=$c->getNom()?>"></dd>
		<dt>Sigle</dt>
		<dd><input type="text" name="sigle" value="<?=$c->getSigle()?>"></dd>
		<dt>Puissance</dt>
		<dd><input type="number" name="puissance" value="<?=$c->getPuissance()?>"></dd>
		<dt>Constructeur</dt>
		<dd><input type="text" name="constructeur" value="<?=$c->getConstructeur()?>"></dd>
		<dt>Datesortie</dt>
		<dd><input type="date" name="datesortie" value="<?=$c->getDatesortie()?>"></dd>
	</dl>
	<input type="submit" name="confirmation" value="Modifier"> <a href="view.php?id=<?=$c->getId()?>"><button type="button">Annuler les modifications</button></a>
</form>
<ul>
	<li><a href="delete.php?id=<?=$c->getId()?>">Supprimer</a></li>
	<li><a href="list.php">Retourner à la liste</a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');