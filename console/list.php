<?php

require_once('../inc/connecteur.php');

require_once('../classes/console.class.php');

$res = $pdo->query("SELECT * FROM console")->fetchAll(PDO::FETCH_ASSOC);
$consoles = [];
foreach ($res as $console) {
	$c = new Console();
	$c->setId($console['id'])
		->setNom($console['nom'])
		->setSigle($console['sigle'])
		->setPuissance($console['puissance'])
		->setDatesortie($console['datesortie'])
		->setConstructeur($console['constructeur']);
	$consoles[] = $c;
}

require_once('../tpl/header.tpl');

?>
<a href="add.php">Ajouter une console</a>
<table>
	<thead>
		<tr>
			<th>Nom (sigle)</th>
			<th>Puissance</th>
			<th>Constructeur / Date de sortie</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($consoles as $console): ?>
		<tr>
			<td><?=$console->getNom()." (".$console->getSigle().")"?></td>
			<td><?=$console->getPuissance()?></td>
			<td><?=$console->getConstructeur()." / ".$console->getDatesortie(true)?></td>
			<td><a href="view.php?id=<?=$console->getId()?>">Voir</a> <a href="edit.php?id=<?=$console->getId()?>">Modifier</a> <a href="delete.php?id=<?=$console->getId()?>">Supprimer</a></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php

require_once('../tpl/footer.tpl');