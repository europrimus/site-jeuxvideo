<?php

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	if (isset($_POST['devedi'])) $_POST['developpeur'] = $_POST['editeur'];
	$stmt = $pdo->prepare("INSERT INTO jeu (titre, annee, developpeur, editeur) VALUES (:titre, :annee, :developpeur, :editeur)");
	$stmt->execute([
		'titre' => $_POST['titre'],
		'annee' => $_POST['annee'],
		'developpeur' => $_POST['developpeur'],
		'editeur' => $_POST['editeur']
	]);
	header('Location: view.php?id='.$pdo->lastInsertId());
	exit;
}

require_once('../tpl/header.tpl');

?>
<form method="POST">
	<dl>
		<dt>Titre</dt>
		<dd><input type="text" name="titre"></dd>
		<dt>Année</dt>
		<dd><input type="number" name="annee"></dd>
		<dt>Éditeur</dt>
		<dd><input type="text" name="editeur"></dd>
		<dt>Développeur (<input type="checkbox" name="devedi"> = éditeur)</dt>
		<dd><input type="text" name="developpeur"></dd>
	</dl>
	<input type="submit" name="confirmation" value="Ajouter"> <a href="list.php"><button type="button">Retourner à la liste</button></a>
</form>

<?php

require_once('../tpl/footer.tpl');