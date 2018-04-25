<?php

require_once('../inc/connecteur.php');

if (isset($_POST['confirmation'])) {
	$stmt = $pdo->prepare("INSERT INTO jeu (titre) VALUES (:titre)");
	$stmt->execute([
		'titre' => $_POST['titre']
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
	</dl>
	<input type="submit" name="confirmation" value="Ajouter"> <a href="list.php"><button type="button">Retourner à la liste</button></a>
</form>

<?php

require_once('../tpl/footer.tpl');