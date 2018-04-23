<?php

require_once('../inc/connecteur.php');

require_once('../classes/version.class.php');
require_once('../classes/jeu.class.php');
require_once('../classes/console.class.php');


$res = $pdo->query("SELECT *
	FROM version
	JOIN jeu ON jeu.id = version.idjeu
	JOIN console ON console.id = version.idconsole")->fetchAll(PDO::FETCH_NAMED);
$jeux = [];
foreach ($res as $jeu) {
	$j = new Jeu();
	$j->setId($jeu['idjeu'])
		->setTitre($jeu['titre'])
		->setDeveloppeur($jeu['developpeur'])
		->setEditeur($jeu['editeur']);

	$c = new Console();
	$c->setId($jeu['idconsole'])
		->setNom($jeu['nom'])
		->setSigle($jeu['sigle'])
		->setPuissance($jeu['puissance'])
		->setDatesortie($jeu['datesortie'][1])
		->setConstructeur($jeu['constructeur']);

	$v = new Version();
	$v->setId($jeu['id'][0])
		->setJeu($j)
		->setConsole($c)
		->setDatesortie($jeu['datesortie'][0])
		->setTypesortie($jeu['typesortie']);
	$jeux[] = $v;
}

require_once('../tpl/header.tpl');

?>
<a href="add.php">Ajouter une version</a>
<table>
	<thead>
		<tr>
			<th>Titre</th>
			<th>Console (sigle)</th>
			<th>Type de sortie</th>
			<th>Date de sortie</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($jeux as $jeu): ?>
		<tr>
			<td><?=$jeu->getJeu()->getTitre()?></td>
			<td><?=$jeu->getConsole()->getNom()." (".$jeu->getConsole()->getSigle().")"?></td>
			<td><?=$jeu->getTypesortie()?></td>
			<td><?=$jeu->getDatesortie(true)?></td>
			<td><a href="view.php?id=<?=$jeu->getId()?>">Voir</a> <a href="edit.php?id=<?=$jeu->getId()?>">Modifier</a> <a href="delete.php?id=<?=$jeu->getId()?>">Supprimer</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php

require_once('../tpl/footer.tpl');