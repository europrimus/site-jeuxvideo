<?php

class Jeu {

	private $id;
	private $titre;
	private $annee;
	private $developpeur;
	private $editeur;

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

	public function getAnnee() {
		return $this->annee;
	}

	public function setAnnee($annee) {
		$this->annee = $annee;
		return $this;
	}

	public function getDeveloppeur() {
		return $this->developpeur;
	}

	public function setDeveloppeur($developpeur) {
		$this->developpeur = $developpeur;
		return $this;
	}

	public function getEditeur() {
		return $this->editeur;
	}

	public function setEditeur($editeur) {
		$this->editeur = $editeur;
		return $this;
	}
}