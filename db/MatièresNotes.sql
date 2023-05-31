-- Contient l'ensemble des matières
CREATE TABLE Matieres (
	NoMat SERIAL PRIMARY KEY,
	NomMat VARCHAR(20) NOT NULL CHECK (
		NomMat IN (
			'Informatique',
			'Electronique',
			'Télécoms',
			'Réseaux',
			'Anglais',
			'Culture & Com',
			'Mathématiques'
		)
	)
);

-- Contient l'ensemble des notes avec leur nom
CREATE TABLE Notes (
	NoNote SERIAL NOT NULL PRIMARY KEY,
	NomNote VARCHAR(20) NOT NULL CHECK (NomNote IN ('TP', 'QCM', 'Oral', 'DS', 'TestTP'))
);

-- Contient les notes des étudiants
CREATE TABLE IF NOT EXISTS "NotesMatieres" (
	id SERIAL NOT NULL PRIMARY KEY,
	login VARCHAR NOT NULL,
	noMat INTEGER NOT NULL,
	noNote INTEGER NOT NULL,
	note INTEGER NOT NULL CHECK (
		note >= 0
		AND note <= 20
	),
	Coefficient INTEGER NOT NULL CHECK(
		Coefficient >= 1
		AND Coefficient <= 5
	),
	CONSTRAINT fk_Matieres FOREIGN KEY (noMat) REFERENCES Matieres (noMat) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_Notes FOREIGN KEY (noNote) REFERENCES Notes (noNote) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT fk_Utilisateurs FOREIGN KEY (login) REFERENCES Comptes (login) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Contient les utilisateurs
CREATE TABLE Comptes (
	login VARCHAR PRIMARY KEY NOT NULL,
	motdepasse VARCHAR DEFAULT 'lannion' NOT NULL,
	statut VARCHAR NOT NULL DEFAULT 'utilisateur' NOT NULL,
	CONSTRAINT chk_statut CHECK (
		statut IN ('administrateur', 'professeur', 'utilisateur')
	)
);

INSERT INTO
	Comptes (login, motdepasse, statut)
VALUES
	('admin@iut.fr', 'admin', 'administrateur'),
	('prof1@iut.fr', 'prof1', 'professeur'),
	('etu1@iut.fr', 'etu1', 'utilisateur'),
	('etu2@iut.fr', 'etu2', 'utilisateur'),
	('etu3@iut.fr', 'etu3', 'utilisateur');

INSERT INTO
	Matieres (NomMat)
VALUES
	('Informatique'),
	('Electronique'),
	('Télécoms'),
	('Réseaux'),
	('Anglais'),
	('Culture & Com'),
	('Mathématiques');

INSERT INTO
	Notes (NomNote)
VALUES
	('TP'),
	('QCM'),
	('Oral'),
	('DS'),
	('TestTP');
	
INSERT INTO
	NotesMatieres(login, noMat, noNote, note, Coefficient)
VALUES
	('etu1@iut.fr', 1, 1, 12, 1),
	('etu1@iut.fr', 1, 2, 14, 1),
	('etu1@iut.fr', 2, 1, 15, 2),
	('etu1@iut.fr', 4, 1, 16, 5),
	('etu1@iut.fr', 2, 2, 17, 1),
	('etu1@iut.fr', 4, 2, 18, 4);

UPDATE sqlite_sequence SET seq = 0;