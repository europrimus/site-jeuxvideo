<?php

require_once('../inc/connecteur.php');

require_once('../classes/jeu.class.php');

$res = $pdo->query("SELECT * FROM jeu")->fetchAll(PDO::FETCH_ASSOC);
$jeux = [];
foreach ($res as $jeu) {
	$j = new Jeu();
	$j->setId($jeu['id'])
		->setTitre($jeu['titre'])
		->setAnnee($jeu['annee'])
		->setDeveloppeur($jeu['developpeur'])
		->setEditeur($jeu['editeur']);
	$jeux[] = $j;
}


require_once('../tpl/header.tpl');

?>
<table>
	<thead>
		<tr>
			<th>Nom (année)</th>
			<th>Editeur / Développeur</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($jeux as $jeu): ?>
		<tr>
			<td><?=$jeu->getTitre()." (".$jeu->getAnnee().")"?></td>
			<td><?=$jeu->getEditeur()." / ".$jeu->getDeveloppeur()?></td>
			<td><a href="view.php?id=<?=$jeu->getId()?>">Voir</a> <a href="edit.php?id=<?=$jeu->getId()?>">Modifier</a> <a href="delete.php?id=<?=$jeu->getId()?>">Supprimer</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php

require_once('../tpl/footer.tpl');