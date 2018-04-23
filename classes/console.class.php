<?php

class Console {

	private $id;
	private $nom;
	private $sigle;
	private $puissance;
	private $datesortie;
	private $constructeur;

	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		if (is_null($this->id)) {
			$this->id = $id;
		}
		return $this;
	}

	public function getNom() {
		return $this->nom;
	}

	public function setNom($nom) {
		$this->nom = $nom;
		return $this;
	}

	public function getSigle() {
		return $this->sigle;
	}

	public function setSigle($sigle) {
		$this->sigle = $sigle;
		return $this;
	}

	public function getPuissance() {
		return $this->puissance;
	}

	public function setPuissance($puissance) {
		$this->puissance = $puissance;
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

	public function getConstructeur() {
		return $this->constructeur;
	}

	public function setConstructeur($constructeur) {
		$this->constructeur = $constructeur;
		return $this;
	}
}