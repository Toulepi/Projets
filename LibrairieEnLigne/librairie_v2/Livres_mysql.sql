CREATE DATABASE IF NOT EXISTS `LIVRES` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `LIVRES`;

CREATE TABLE `CATEGORIE` (
  `idcategorie` VARCHAR(42),
  `description` VARCHAR(42),
  PRIMARY KEY (`idcategorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `EVENEMENT` (
  `idauteur` VARCHAR(42),
  `theme` VARCHAR(42),
  `date` VARCHAR(42),
  PRIMARY KEY (`idauteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `PREPARER` (
  `idauteur` VARCHAR(42),
  `idauteur_1` VARCHAR(42),
  PRIMARY KEY (`idauteur`, `idauteur_1`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `AUTEUR` (
  `idauteur` VARCHAR(42),
  `nom` VARCHAR(42),
  `prenom` VARCHAR(42),
  `titre` VARCHAR(42),
  `theme` VARCHAR(42),
  `collection` VARCHAR(42),
  PRIMARY KEY (`idauteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `TRAVAILLER` (
  `idauteur` VARCHAR(42),
  `idediteur` VARCHAR(42),
  PRIMARY KEY (`idauteur`, `idediteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `EDITEUR` (
  `idediteur` VARCHAR(42),
  `isbn` VARCHAR(42),
  `maison_edition` VARCHAR(42),
  `date_parution` VARCHAR(42),
  `idlivre` VARCHAR(42),
  PRIMARY KEY (`idediteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `LIVRE` (
  `idlivre` VARCHAR(42),
  `titre` VARCHAR(42),
  `prix` VARCHAR(42),
  `isbn` VARCHAR(42),
  `date_parution` VARCHAR(42),
  `img` VARCHAR(42),
  `maison_edition` VARCHAR(42),
  `auteur` VARCHAR(42),
  `idcategorie` VARCHAR(42),
  PRIMARY KEY (`idlivre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `EXEMPLAIRE` (
  `idexemplaire` VARCHAR(42),
  `idcommande` VARCHAR(42),
  `quantite` VARCHAR(42),
  `idlivre` VARCHAR(42),
  `quantité` VARCHAR(42),
  PRIMARY KEY (`idexemplaire`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `COMMANDE` (
  `idcommande` VARCHAR(42),
  `numero` VARCHAR(42),
  `idclient` VARCHAR(42),
  `datecommande` VARCHAR(42),
  PRIMARY KEY (`idcommande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `CLIENT` (
  `idclient` VARCHAR(42),
  `nom` VARCHAR(42),
  `email` VARCHAR(42),
  `mdp` VARCHAR(42),
  PRIMARY KEY (`idclient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `REDIGER` (
  `idlivre` VARCHAR(42),
  `idauteur` VARCHAR(42),
  PRIMARY KEY (`idlivre`, `idauteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `PREPARER` ADD FOREIGN KEY (`idauteur_1`) REFERENCES `AUTEUR` (`idauteur`);
ALTER TABLE `PREPARER` ADD FOREIGN KEY (`idauteur`) REFERENCES `EVENEMENT` (`idauteur`);
ALTER TABLE `TRAVAILLER` ADD FOREIGN KEY (`idediteur`) REFERENCES `EDITEUR` (`idediteur`);
ALTER TABLE `TRAVAILLER` ADD FOREIGN KEY (`idauteur`) REFERENCES `AUTEUR` (`idauteur`);
ALTER TABLE `EDITEUR` ADD FOREIGN KEY (`idlivre`) REFERENCES `LIVRE` (`idlivre`);
ALTER TABLE `LIVRE` ADD FOREIGN KEY (`idcategorie`) REFERENCES `CATEGORIE` (`idcategorie`);
ALTER TABLE `EXEMPLAIRE` ADD FOREIGN KEY (`idlivre`) REFERENCES `LIVRE` (`idlivre`);
ALTER TABLE `EXEMPLAIRE` ADD FOREIGN KEY (`idcommande`) REFERENCES `COMMANDE` (`idcommande`);
ALTER TABLE `COMMANDE` ADD FOREIGN KEY (`idclient`) REFERENCES `CLIENT` (`idclient`);
ALTER TABLE `REDIGER` ADD FOREIGN KEY (`idauteur`) REFERENCES `AUTEUR` (`idauteur`);
ALTER TABLE `REDIGER` ADD FOREIGN KEY (`idlivre`) REFERENCES `LIVRE` (`idlivre`);