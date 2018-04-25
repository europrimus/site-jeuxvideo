<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("UPDATE version SET datesortie = :datesortie, typesortie = :typesortie, idjeu = :idjeu, idconsole = :idconsole, developpeur = :developpeur, editeur = :editeur, titre = :titre WHERE id = :id");
	$stmt->execute([
		'id' => $_GET['id'],
		'titre' => $_POST['titre']?:null,
		'datesortie' => $_POST['datesortie'],
		'typesortie' => $_POST['typesortie'],
		'idjeu' => $_POST['jeu'],
		'idconsole' => $_POST['console'],
		'developpeur' => $_POST['developpeur'],
		'editeur' => $_POST['editeur']
	]);
	header('Location: view.php?id='.$_GET['id']);
	exit;
}

require_once('../classes/version.class.php');

$stmt = $pdo->prepare("SELECT version.*, jeu.id idjeu, jeu.titre titrejeu, console.id idconsole, console.nom nomconsole
	FROM version
	JOIN jeu ON jeu.id = version.idjeu
	JOIN console ON console.id = version.idconsole
	WHERE version.id = :id");
$stmt->execute(['id' => $_GET['id']]);
$jeu = $stmt->fetch(PDO::FETCH_ASSOC);

$j = new Version();
$j->setId($jeu['id'])
	->setTitre($jeu['titre'])
	->setJeu(['id' => $jeu['idjeu'], 'titre' => $jeu['titrejeu']])
	->setConsole(['id' => $jeu['idconsole'], 'nom' => $jeu['nomconsole']])
	->setDatesortie($jeu['datesortie'])
	->setTypesortie($jeu['typesortie'])
	->setDeveloppeur($jeu['developpeur'])
	->setEditeur($jeu['editeur']);

$consoles = array_map('reset', $pdo->query("SELECT id, nom FROM console")->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP));
$jeux = array_map('reset', $pdo->query("SELECT id, titre FROM jeu")->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP));
$types = $pdo->query("SELECT unnest(enum_range(null::typesortie))")->fetchAll(PDO::FETCH_COLUMN);

require_once('../tpl/header.tpl');

?>
<form method="POST">
	<dl>
		<dt>Jeu</dt>
		<dd><select name="jeu">
			<?php foreach ($jeux as $id => $nom): ?>
			<option <?php if($id === $j->getJeu()['id']):?>selected<?php endif; ?> value="<?=$id?>"><?=$nom?></option>
			<?php endforeach; ?>
		</select></dd>
		<dt>Titre</dt>
		<dd><input type="text" name="titre" <?php if (!is_array($j->getTitre(false))): ?>value="<?=$j->getTitre(false)?>"<?php endif; ?>></dd>
		<dt>Console</dt>
		<dd><select name="console">
			<?php foreach ($consoles as $id => $nom): ?>
			<option <?php if($id === $j->getConsole()['id']):?>selected<?php endif; ?> value="<?=$id?>"><?=$nom?></option>
			<?php endforeach; ?>
		</select></dd>
		<dt>Date de sortie</dt>
		<dd><input type="date" name="datesortie" value="<?=$j->getDatesortie()?>"></dd>
		<dt>Type</dt>
		<dd><select name="typesortie">
			<?php foreach ($types as $libelle): ?>
			<option <?php if($libelle === $j->getTypesortie()):?>selected<?php endif; ?> value="<?=$libelle?>"><?=$libelle?></option>
			<?php endforeach; ?>
		</select></dd>
		<dt>Éditeur</dt>
		<dd><input type="text" name="editeur" value="<?=$j->getEditeur()?>"></dd>
		<dt>Développeur</dt>
		<dd><input type="text" name="developpeur" value="<?=$j->getDeveloppeur()?>"></dd>
	</dl>
	<input type="submit" name="confirmation" value="Modifier"> <a href="view.php?id=<?=$j->getId()?>"><button type="button">Annuler les modifications</button></a>
</form>
<ul>
	<li><a href="delete.php?id=<?=$j->getId()?>">Supprimer</a></li>
	<li><a href="list.php">Retourner à la liste</a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');