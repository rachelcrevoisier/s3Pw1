/**
TABLES Projet Web 1 - Session 3
**/
CREATE TABLE usagers(
    id_usager SMALLINT UNSIGNED AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    adresse VARCHAR(300) NOT NULL,
    codePostal VARCHAR(10) NOT NULL,
    ville VARCHAR(50) NOT NULL,
    pays VARCHAR(50) NOT NULL,
    courriel VARCHAR(50) NOT NULL ,
    telephone VARCHAR(50) NOT NULL,
    mdp VARCHAR(255) NOT NULL,
    renouvelermdp VARCHAR(255) NOT NULL,
    idprofil VARCHAR(30) NOT NULL,
    FOREIGN KEY(idprofil) REFERENCES profils(profils),
    PRIMARY KEY(id_usager, courriel)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE profils(
    profils VARCHAR(30),
    PRIMARY KEY(profils)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE conditions(
    conditions VARCHAR(30),
    PRIMARY KEY(conditions)
);
CREATE TABLE timbres(
    id_timbre SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    pays VARCHAR(50) NOT NULL,
    certifie VARCHAR(3) NOT NULL,
    annee YEAR NOT NULL,
    couleur VARCHAR(50) NOT NULL,
    idenchere SMALLINT UNSIGNED NOT NULL,
    idcondition VARCHAR(30) NOT NULL,
    FOREIGN KEY(idcondition) REFERENCES conditions(conditions),
    FOREIGN KEY(idenchere) REFERENCES encheres(id_enchere)
);

CREATE TABLE images(
    id_image SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    lien VARCHAR(150) NOT NULL,
    typeVisuel VARCHAR(15) NOT NULL,
    idtimbre SMALLINT UNSIGNED NOT NULL,
    FOREIGN KEY(idtimbre) REFERENCES timbres(id_timbre)
);
CREATE TABLE encheres(
    id_enchere SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    dateDebut DATE NOT NULL,
    dateFin DATE NOT NULL,
    tarifBase FLOAT NOT NULL,
    choixLord VARCHAR(3),
    idusager SMALLINT UNSIGNED,
    FOREIGN KEY(idusager) REFERENCES usagers(id_usager) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE favoris(
    id_favori SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    idusager SMALLINT UNSIGNED NOT NULL,
    idenchere SMALLINT UNSIGNED NOT NULL,
    FOREIGN KEY(idusager) REFERENCES usagers(id_usager),
    FOREIGN KEY(idenchere) REFERENCES encheres(id_enchere)
);

CREATE TABLE mises(
    id_mise SMALLINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    dateMise DATE,
    montant FLOAT,
    idusager SMALLINT UNSIGNED,
    idenchere SMALLINT UNSIGNED,
    FOREIGN KEY(idusager) REFERENCES usagers(id_usager) ON DELETE SET NULL ON UPDATE CASCADE,
    FOREIGN KEY(idenchere) REFERENCES encheres(id_enchere) ON DELETE SET NULL ON UPDATE CASCADE
);

--Insertion usagers
INSERT INTO usagers VALUES (1, "Lord", "Stampee", "Lordship Ln", "N17 8NU","London", "Royaume-Uni", "lord.regina@stampee.com", "+44 20 8489 4250", SHA2("Pa110747", 512),"oui", "administrateur"),(2, "Crevoisier", "Rachel", "3114 rue de Cadillac", "H1N 2V7","Montréal", "Canada", "rachelcrevoisier@gmail.com", "438 497 56 28", SHA2("Pa110747", 512),"oui", "administrateur"),(3, "Roux", "Valentin", "Avenue de Fontaineroux", "77880","Fontaineroux", "France", "valentinroux@gmail.com", "06 78 76 54 32", SHA2("Pa110747", 512),"oui", "membre"),(4, "Moucheux", "David", "2bis villa de Lhermitage", "75020","Paris", "France", "davidmoucheux@gmail.com", "06 78 76 54 32", SHA2("Pa110747", 512),"oui", "membre"),(5, "Antonini", "Pierre", "21 Avenue Jean Jaurès", "92120","Montrouge", "France", "pierreantonini@gmail.com", "06 78 76 54 32", SHA2("Pa110747", 512),"oui", "membre");