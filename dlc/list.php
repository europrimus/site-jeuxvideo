<?php

require_once('../inc/connecteur.php');

require_once('../classes/dlc.class.php');


$res = $pdo->query("SELECT dlc.*, jeu.titre jeu
	FROM dlc
	JOIN jeu ON jeu.id = dlc.idjeu")->fetchAll(PDO::FETCH_ASSOC);
$dlcs = [];
foreach ($res as $jeu) {
	$v = new Dlc();
	$v->setId($jeu['id'])
		->setJeu($jeu['jeu'])
		->setTitre($jeu['titre'])
		->setTypecontenu($jeu['typecontenu']);
	$dlcs[] = $v;
}

require_once('../tpl/header.tpl');

?>
<a href="add.php">Ajouter un DLC</a>
<?php if (!count($dlcs)): ?><p>Pas de DLCs dans la base pour l'instant</p><?php else: ?>
<table>
	<thead>
		<tr>
			<th>Jeu</th>
			<th>DLC</th>
			<th>Type de contenu</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($dlcs as $dlc): ?>
		<tr>
			<td><?=$dlc->getJeu()?></td>
			<td><?=$dlc->getTitre()?></td>
			<td><?=$dlc->getTypecontenu()?></td>
			<td><a href="view.php?id=<?=$dlc->getId()?>">Voir</a> <a href="edit.php?id=<?=$dlc->getId()?>">Modifier</a> <a href="delete.php?id=<?=$dlc->getId()?>">Supprimer</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif;

require_once('../tpl/footer.tpl');