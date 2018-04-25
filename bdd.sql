-- r1

CREATE TABLE jeu (
	id serial PRIMARY KEY,
	titre varchar(200) UNIQUE NOT NULL,
	editeur varchar(50) NOT NULL,
	developpeur varchar(50) NOT NULL,
	annee date NOT NULL
);

-- r2

CREATE TABLE console (
	id serial PRIMARY KEY,
	nom varchar(50) UNIQUE NOT NULL,
	sigle varchar(8) UNIQUE NOT NULL,
	puissance int NOT NULL CHECK (round(log(2, puissance)) = log(2, puissance)),
	datesortie date NOT NULL,
	constructeur varchar(50) NOT NULL
);

CREATE TYPE typesortie AS ENUM ('initiale', 'portage', 'remaster', 'remake');

CREATE TABLE version (
	id serial PRIMARY KEY,
	datesortie date NOT NULL,
	typesortie typesortie NOT NULL DEFAULT 'initiale'::typesortie,
	idjeu int NOT NULL REFERENCES jeu(id),
	idconsole int NOT NULL REFERENCES console(id)
);

INSERT INTO console (nom, sigle, puissance, datesortie, constructeur)
VALUES ('Nintendo', 'NES', 8, '1985-07-15', 'Nintendo'),
('Super Nintendo', 'SNES', 16, '1990-11-21', 'Nintendo'),
('PlayStation', 'PSX', 32, '1994-12-03', 'Sony');

INSERT INTO version(datesortie, idjeu, idconsole)
SELECT annee, id, 1 FROM jeu;

ALTER TABLE jeu DROP COLUMN annee;

-- r3

ALTER TABLE version ADD COLUMN editeur varchar(50) NOT NULL DEFAULT 'edi', ADD COLUMN developpeur varchar(50) NOT NULL DEFAULT 'dev';

UPDATE version
SET editeur = jeu.editeur, developpeur = jeu.developpeur
FROM jeu
WHERE jeu.id = version.idjeu;

ALTER TABLE version ALTER COLUMN editeur DROP DEFAULT, ALTER COLUMN developpeur DROP DEFAULT;

ALTER TABLE jeu DROP COLUMN editeur, DROP COLUMN developpeur;

-- r4

ALTER TYPE typesortie ADD VALUE 'compilation' AFTER 'portage';

CREATE TYPE typedlc AS ENUM ('pack de démarrage', 'objet', 'personnage', 'option supplémentaire', 'chapitre');

CREATE TABLE dlc (
	id serial PRIMARY KEY,
	titre varchar(200) NOT NULL,
	idjeu int NOT NULL REFERENCES jeu(id),
	typecontenu typedlc NOT NULL DEFAULT 'objet'
);

ALTER TABLE version ADD COLUMN titre varchar(200) DEFAULT NULL;