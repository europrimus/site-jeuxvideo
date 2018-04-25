<?php

if (!isset($_GET['id'])) {
	header('Location:list.php');
	exit;
}

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("UPDATE dlc SET typecontenu = :typecontenu, idjeu = :idjeu, titre = :titre WHERE id = :id");
	$stmt->execute([
		'id' => $_GET['id'],
		'titre' => $_POST['titre'],
		'typecontenu' => $_POST['typecontenu'],
		'idjeu' => $_POST['jeu']
	]);
	header('Location: view.php?id='.$_GET['id']);
	exit;
}

require_once('../classes/dlc.class.php');

$stmt = $pdo->prepare("SELECT dlc.*, jeu.id idjeu, jeu.titre titrejeu
	FROM dlc
	JOIN jeu ON jeu.id = dlc.idjeu
	WHERE dlc.id = :id");
$stmt->execute(['id' => $_GET['id']]);
$jeu = $stmt->fetch(PDO::FETCH_ASSOC);

$j = new Dlc();
$j->setId($jeu['id'])
	->setTitre($jeu['titre'])
	->setJeu(['id' => $jeu['idjeu'], 'titre' => $jeu['titrejeu']])
	->setTypecontenu($jeu['typecontenu']);

$jeux = array_map('reset', $pdo->query("SELECT id, titre FROM jeu")->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP));
$types = $pdo->query("SELECT unnest(enum_range(null::typedlc))")->fetchAll(PDO::FETCH_COLUMN);

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
		<dd><input type="text" name="titre" value="<?=$j->getTitre()?>"></dd>
		<dt>Type de contenu</dt>
		<dd><select name="typecontenu">
			<?php foreach ($types as $libelle): ?>
			<option <?php if($libelle === $j->getTypecontenu()):?>selected<?php endif; ?> value="<?=$libelle?>"><?=$libelle?></option>
			<?php endforeach; ?>
		</select></dd>
	</dl>
	<input type="submit" name="confirmation" value="Modifier"> <a href="view.php?id=<?=$j->getId()?>"><button type="button">Annuler les modifications</button></a>
</form>
<ul>
	<li><a href="delete.php?id=<?=$j->getId()?>">Supprimer</a></li>
	<li><a href="list.php">Retourner à la liste</a></li>
</ul>
<?php

require_once('../tpl/footer.tpl');