<?php

require_once('../inc/connecteur.php');

require_once('../classes/jeu.class.php');

$res = $pdo->query("SELECT * FROM jeu")->fetchAll(PDO::FETCH_ASSOC);
$jeux = [];
foreach ($res as $jeu) {
	$j = new Jeu();
	$j->setId($jeu['id'])
		->setTitre($jeu['titre']);
	$jeux[] = $j;
}


require_once('../tpl/header.tpl');

?>
<a href="add.php">Ajouter un jeu</a>
<?php if (!count($jeux)): ?><p>Pas de jeux dans la base pour l'instant</p><?php else: ?>
<table>
	<thead>
		<tr>
			<th>Titre (année)</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($jeux as $jeu): ?>
		<tr>
			<td><?=$jeu->getTitre()?></td>
			<td><a href="view.php?id=<?=$jeu->getId()?>">Voir</a> <a href="edit.php?id=<?=$jeu->getId()?>">Modifier</a> <a href="delete.php?id=<?=$jeu->getId()?>">Supprimer</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif;

require_once('../tpl/footer.tpl');