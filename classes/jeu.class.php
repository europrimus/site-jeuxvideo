<?php

class Jeu {

	private $id;
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

	public function getTitre() {
		return $this->titre;
	}

	public function setTitre($titre) {
		$this->titre = $titre;
		return $this;
	}
}