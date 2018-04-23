<?php

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("INSERT INTO version (idjeu, idconsole, typesortie, datesortie) VALUES (:idjeu, :idconsole, :typesortie, :datesortie)");
	$stmt->execute([
		'idjeu' => $_POST['jeu'],
		'idconsole' => $_POST['console'],
		'typesortie' => $_POST['typesortie'],
		'datesortie' => $_POST['datesortie']
	]);
	header('Location: view.php?id='.$pdo->lastInsertId());
	exit;
}

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
			<option value="<?=$id?>"><?=$nom?></option>
			<?php endforeach; ?>
		</select></dd>
		<dt>Console</dt>
		<dd><select name="console">
			<?php foreach ($consoles as $id => $nom): ?>
			<option value="<?=$id?>"><?=$nom?></option>
			<?php endforeach; ?>
		</select></dd>
		<dt>Date de sortie</dt>
		<dd><input type="date" name="datesortie"></dd>
		<dt>Type</dt>
		<dd><select name="typesortie">
			<?php foreach ($types as $libelle): ?>
			<option value="<?=$libelle?>"><?=$libelle?></option>
			<?php endforeach; ?>
		</select></dd>
	</dl>
	<input type="submit" name="confirmation" value="Ajouter"> <a href="list.php"><button type="button">Retourner à la liste</button></a>
</form>

<?php

require_once('../tpl/footer.tpl');