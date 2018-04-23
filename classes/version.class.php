<?php

class Version {

	private $id;
	private $jeu;
	private $console;
	private $datesortie;
	private $typesortie;

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

	public function getConsole() {
		return $this->console;
	}

	public function setConsole($console) {
		$this->console = $console;
		return $this;
	}

	public function getDatesortie($nice = false) {
		if (!$nice) return $this->datesortie->format('Y-m-d');
		else return $this->datesortie->format('d/m/Y');
	}

	public function setDatesortie($datesortie) {
		$this->datesortie = new DateTime($datesortie);
		return $this;
	}

	public function getTypesortie() {
		return $this->typesortie;
	}

	public function setTypesortie($typesortie) {
		$this->typesortie = $typesortie;
		return $this;
	}
}