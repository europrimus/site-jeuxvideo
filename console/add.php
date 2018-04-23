<?php

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("INSERT INTO console (nom, sigle, puissance, datesortie, constructeur) VALUES (:nom, :sigle, :puissance, :datesortie, :constructeur)");
	$stmt->execute([
		'nom' => $_POST['nom'],
		'sigle' => $_POST['sigle'],
		'puissance' => $_POST['puissance'],
		'datesortie' => $_POST['datesortie'],
		'constructeur' => $_POST['constructeur']
	]);
	header('Location: view.php?id='.$pdo->lastInsertId());
	exit;
}

require_once('../tpl/header.tpl');

?>
<form method="POST">
	<dl>
		<dt>Nom</dt>
		<dd><input type="text" name="nom"></dd>
		<dt>Sigle</dt>
		<dd><input type="text" name="sigle"></dd>
		<dt>Puissance</dt>
		<dd><input type="number" name="puissance"></dd>
		<dt>Constructeur</dt>
		<dd><input type="text" name="constructeur"></dd>
		<dt>Datesortie</dt>
		<dd><input type="date" name="datesortie"></dd>
	</dl>
	<input type="submit" name="confirmation" value="Ajouter"> <a href="list.php"><button type="button">Retourner à la liste</button></a>
</form>

<?php

require_once('../tpl/footer.tpl');