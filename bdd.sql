-- r1

CREATE TABLE jeu (
	id serial PRIMARY KEY,
	titre varchar(200) UNIQUE NOT NULL,
	editeur varchar(50) NOT NULL,
	developpeur varchar(50) NOT NULL,
	annee date NOT NULL
);
