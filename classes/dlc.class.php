<?php

class Dlc {

	private $id;
	private $jeu;
	private $typecontenu;
	private $titre;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		if (is_null($this->id)) {
			$this->id = $id;
		}
		return $this;
	}

	public function getJeu() {
		return $this->jeu;
	}

	public function setJeu($jeu) {
		$this->jeu = $jeu;
		return $this;
	}

	public function getTypecontenu() {
		return $this->typecontenu;
	}

	public function setTypecontenu($typecontenu) {
		$this->typecontenu = $typecontenu;
		return $this;
	}

	public function getTitre() {
		return $this->titre;
	}

	public function setTitre($titre) {
		$this->titre = $titre;
		return $this;
	}
}