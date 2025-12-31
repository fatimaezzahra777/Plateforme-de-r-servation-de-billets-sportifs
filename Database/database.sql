-- Creation de la database
create database BuyMatch;

--Travaille sur cette database
use BuyMatch;

--create table users
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nom varchar(100) NOT NULL,
    email varchar(250) UNIQUE NOT NULL,
    adresse varchar(250) NOT NULL,
    telephone varchar(100) NOT NULL,
    password varchar(255) NOT NULL,
    role enum('acheteur','organisateur','admin'),
    statut ENUM('actif','inactif') DEFAULT 'actif'
);

--create table organisateur
CREATE TABLE organisateur (
    id_user int ,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

--create table acheteur
CREATE TABLE Acheteur (
    id_user int ,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

--create table admin
CREATE TABLE Admin(
    id_user int ,
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);
--create table Match
CREATE TABLE matchs (
    id_match INT AUTO_INCREMENT PRIMARY KEY,
    id_organisateur INT NOT NULL,
    equipe1 VARCHAR(100) NOT NULL,
    logo_equipe1 VARCHAR(255),
    equipe2 VARCHAR(100) NOT NULL,
    logo_equipe2 VARCHAR(255),
    date_match DATE NOT NULL,
    heure_match TIME NOT NULL,
    lieu VARCHAR(150) NOT NULL,
    duree INT DEFAULT 90,
    nb_places INT CHECK (nb_places <= 2000),
    statut ENUM('en_attente','valide','refuse') DEFAULT 'en_attente',
    FOREIGN KEY (id_organisateur) REFERENCES users(id_user)
);


--create table Commentaires
CREATE TABLE Commentaires (
    id_commentaire INT AUTO_INCREMENT PRIMARY KEY,
    id_match INT NOT NULL,
    id_user INT NOT NULL,
    commentaire TEXT,
    note INT CHECK (note BETWEEN 1 AND 5),
    date_commentaire TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_match) REFERENCES matchs(id_match),
    FOREIGN KEY (id_user) REFERENCES users(id_user)
);

--create tabke categories
CREATE TABLE categories (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    id_match INT NOT NULL,
    nom_categorie VARCHAR(50),
    prix DECIMAL(10,2) NOT NULL,
    nb_places INT,
    FOREIGN KEY (id_match) REFERENCES matchs(id_match)
);

--create view
CREATE VIEW Matchs_valides AS
SELECT 
    id_match,
    equipe1,
    equipe2,
    date_match,
    heure_match,
    lieu
FROM matchs
WHERE statut = 'valide';


--create procedure stockée
DELIMITER $$

CREATE PROCEDURE Valider_match(IN idMatch INT)
BEGIN
    UPDATE matchs
    SET statut = 'valide'
    WHERE id_match = idMatch;
END $$

DELIMITER ;

