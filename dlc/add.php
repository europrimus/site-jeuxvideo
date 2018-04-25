<?php

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("INSERT INTO dlc (idjeu, typecontenu, titre) VALUES (:idjeu, :typecontenu, :titre)");
	$stmt->execute([
		'idjeu' => $_POST['jeu'],
		'titre' => $_POST['titre'],
		'typecontenu' => $_POST['typecontenu']
	]);
	header('Location: view.php?id='.$pdo->lastInsertId());
	exit;
}

$jeux = array_map('reset', $pdo->query("SELECT id, titre FROM jeu")->fetchAll(PDO::FETCH_COLUMN|PDO::FETCH_GROUP));
$types = $pdo->query("SELECT unnest(enum_range(null::typedlc))")->fetchAll(PDO::FETCH_COLUMN);

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
		<dt>Titre</dt>
		<dd><input type="text" name="titre"></dd>
		<dt>Type de contenu</dt>
		<dd><select name="typecontenu">
			<?php foreach ($types as $libelle): ?>
			<option value="<?=$libelle?>"><?=$libelle?></option>
			<?php endforeach; ?>
		</select></dd>
	</dl>
	<input type="submit" name="confirmation" value="Ajouter"> <a href="list.php"><button type="button">Retourner à la liste</button></a>
</form>

<?php

require_once('../tpl/footer.tpl');