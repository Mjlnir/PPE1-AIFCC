-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 20 déc. 2019 à 16:49
-- Version du serveur :  10.1.38-MariaDB
-- Version de PHP :  7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `m2l`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_ADD_SALLE` (`nbPersonneMax` INT, `nomSalle` VARCHAR(50), `estActive` BIT, `idTypeSalle` INT)  BEGIN
	INSERT INTO SALLE(nbPersonneMax,nomSalle,estActive,idTypeSalle) VALUES(nbPersonneMax,nomSalle,estActive,idTypeSalle);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_DEL_RESERVATION` (`idReservation` INT)  BEGIN
	DELETE FROM RESERVER
    WHERE numReservation = idReservation;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_DEL_SALLE` (`idSalle` INT)  BEGIN
	DELETE FROM SALLE
	WHERE idSalle = idSalle;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_EST_ADMIN` (`pseudo` VARCHAR(10))  BEGIN
	SELECT idTypeUtilisateur FROM UTILISATEUR WHERE loginUtilisateur = pseudo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_LIGUE` (`id_utilisateur` INT)  BEGIN
	SELECT LIGUE.idLigue, LIGUE.nomLigue FROM LIGUE
	INNER JOIN APPARTENIR ON APPARTENIR.idLigue = LIGUE.idLigue
	WHERE idUtilisateur = id_utilisateur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_LIGUES` ()  BEGIN
	SELECT LIGUE.idLigue
		, nomLigue 
        , APPARTENIR.idUtilisateur
        FROM LIGUE
        LEFT JOIN APPARTENIR ON APPARTENIR.idLigue =  LIGUE.idLigue;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_RESERVATION` ()  BEGIN
	SELECT numReservation as 'id'
	,CONCAT(nomSalle, ' - ', nomLigue) as 'title'
	,heureDebut as 'start'
	,heureFin as 'end'
	,nomSalle as 'nomSalle'
	,nomLigue as 'nomLigue'
	,descriptionR as 'descriptionR'
	FROM RESERVER JOIN UTILISATEUR ON RESERVER.idUtilisateur = UTILISATEUR.idUtilisateur
	JOIN LIGUE ON RESERVER.idLigue = LIGUE.idLigue
	JOIN SALLE ON RESERVER.idSalle = SALLE.idSalle;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_SALLES` ()  BEGIN
	SELECT typeSalle, nbPersonneMax, nomSalle, typesalle.idTypeSalle, salle.idSalle, salle.estActive
	FROM typesalle
	JOIN salle ON typesalle.idTypeSalle = salle.idTypeSalle
	ORDER BY nomSalle;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_SALLES_RESERVE` (`dateDebut` DATETIME, `dateFin` DATETIME)  BEGIN
	SELECT nomSalle
	FROM SALLE 
	WHERE SALLE.idSalle 
	IN 
	(
		SELECT RESERVER.idSalle FROM RESERVER
		WHERE
		-- Commence avant, termine après
		(dateDebut <= RESERVER.heureDebut 
			AND dateFin >= RESERVER.heureFin)
		OR
		-- Commence pendant, termine pendant
		(dateDebut >= RESERVER.heureDebut 
			AND dateFin <= RESERVER.heureFin)
		OR
		-- Commence avant, termine pendant
		(dateDebut < RESERVER.heureDebut 
			AND dateFin > RESERVER.heureDebut
			AND dateFin < RESERVER.heureFin)
		OR
		-- Commence pendant, termine après
		(dateDebut > RESERVER.heureDebut 
			AND dateDebut < RESERVER.heureFin
			AND dateFin > RESERVER.heureFin)
	);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_USER` (`pseudo` VARCHAR(10))  BEGIN
	SELECT * FROM UTILISATEUR WHERE loginUtilisateur = pseudo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_UTILISATEUR` (IN `_idUtilisateur` INT)  BEGIN
	SELECT nomUtilisateur
		, nomUtilisateur
		, mailUtilisateur
		, telephoneUtilisateur
		, loginUtilisateur
		, TYPEUTILISATEUR.typeUtilisateur
	FROM UTILISATEUR
	INNER JOIN TYPEUTILISATEUR ON TYPEUTILISATEUR.idTypeUtilisateur = UTILISATEUR.idTypeUtilisateur
	WHERE idUtilisateur = _idUtilisateur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_RESERVER` (IN `_heureDebut` DATETIME, IN `_heureFin` DATETIME, IN `_nomSalle` VARCHAR(10) CHARSET utf8, IN `_idUser` INT, IN `_idLigue` INT, IN `_description` VARCHAR(255) CHARSET utf8)  BEGIN
	DECLARE _idSalle, _numReservation INT;
	SELECT idSalle INTO _idSalle FROM salle WHERE nomSalle = _nomSalle;
    SELECT numReservation FROM reserver ORDER BY numReservation DESC LIMIT 1 INTO _numReservation;

	INSERT INTO RESERVER(idLigue
						,idSalle
						,jourReservation
						,idUtilisateur
						,heureDebut
						,heureFin
                        ,numReservation
						,descriptionR) VALUES (
    					_idLigue, 
						_idSalle, 
						_heureDebut,
						_idUser,
						_heureDebut,
						_heureFin,
                        _numReservation,
						_description
                        );
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_SIGNIN` (IN `pseudo` VARCHAR(10) CHARSET utf8, IN `mdp` VARCHAR(255) CHARSET utf8)  BEGIN
	SELECT COUNT(*) as nbUser FROM UTILISATEUR WHERE loginUtilisateur = pseudo AND passwordUtilisateur = mdp;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_SIGNUP` (IN `prenom` VARCHAR(50), IN `nom` VARCHAR(50), IN `mail` VARCHAR(50), IN `tel` VARCHAR(50), IN `mdp` VARCHAR(255))  BEGIN
	DECLARE _return int;
	DECLARE _CountUser int;
	SELECT Count(loginUtilisateur) INTO _CountUser FROM UTILISATEUR WHERE LOWER(loginUtilisateur) = LOWER(CONCAT(SUBSTRING(prenom, 1, 1), SUBSTRING(nom, 1, 7)));
	IF _CountUser > 0
    THEN
    	SET _return = -999;
    ELSE 
		INSERT INTO UTILISATEUR(nomUtilisateur, prenomUtilisateur, mailUtilisateur,telephoneUtilisateur, loginUtilisateur, passwordUtilisateur, idTypeUtilisateur)
		VALUES (nom, prenom, mail, tel, LOWER(CONCAT(SUBSTRING(prenom, 1, 1), SUBSTRING(nom, 1, 7))), mdp, 2);
		SET _return = 1;
	END IF;
	SELECT _return;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_ACTIVE_SALLE` (IN `_idSalle` INT)  BEGIN
	DECLARE _estActive BIT;
	SELECT estActive INTO _estActive FROM salle WHERE idSalle = _idSalle;

	UPDATE salle
	SET estActive = NOT _estActive
	WHERE idSalle = _idSalle;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_INFORMATISEE_SALLE` (IN `_idSalle` INT)  BEGIN
	DECLARE _idTypeSalle INT;
	SELECT idTypeSalle INTO _idTypeSalle FROM SALLE WHERE idSalle = _idSalle;
	IF _idTypeSalle = 1
    THEN
		SET _idTypeSalle = 2;
	ELSE
		SET _idTypeSalle = 1;
	END IF;
	UPDATE salle
	SET idTypeSalle = _idTypeSalle
	WHERE idSalle = _idSalle;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_NBPLACE_SALLE` (IN `_idSalle` INT, IN `_nbPersonneMax` INT)  BEGIN
	UPDATE SALLE
	SET nbPersonneMax = _nbPersonneMax
	WHERE idSalle = _idSalle;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_NOM_SALLE` (IN `_idSalle` INT, IN `_nomSalle` VARCHAR(50) CHARSET utf8)  BEGIN
	UPDATE SALLE
	SET nomSalle = _nomSalle
	WHERE idSalle = _idSalle;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

CREATE TABLE `appartenir` (
  `idUtilisateur` int(11) NOT NULL,
  `idLigue` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `appartenir`
--

INSERT INTO `appartenir` (`idUtilisateur`, `idLigue`, `dateDebut`, `dateFin`) VALUES
(4, 1, '2019-10-17', '2050-12-31'),
(7, 2, '2019-10-17', '2050-12-31');

-- --------------------------------------------------------

--
-- Structure de la table `ligue`
--

CREATE TABLE `ligue` (
  `idLigue` int(11) NOT NULL,
  `nomLigue` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ligue`
--

INSERT INTO `ligue` (`idLigue`, `nomLigue`) VALUES
(1, 'DeBeaufs'),
(2, 'DePorts');

-- --------------------------------------------------------

--
-- Structure de la table `reserver`
--

CREATE TABLE `reserver` (
  `idLigue` int(11) NOT NULL,
  `idSalle` int(11) NOT NULL,
  `jourReservation` datetime NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `heureDebut` datetime NOT NULL,
  `heureFin` datetime NOT NULL,
  `numReservation` int(11) DEFAULT NULL,
  `descriptionR` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reserver`
--

INSERT INTO `reserver` (`idLigue`, `idSalle`, `jourReservation`, `idUtilisateur`, `heureDebut`, `heureFin`, `numReservation`, `descriptionR`) VALUES
(1, 56, '2019-12-16 08:00:00', 3, '2019-12-16 08:00:00', '2019-12-16 10:00:00', 1, ''),
(1, 56, '2019-12-17 10:00:00', 3, '2019-12-17 10:00:00', '2019-12-17 16:00:00', 1, ''),
(1, 56, '2019-12-18 10:00:00', 3, '2019-12-18 10:00:00', '2019-12-18 16:00:00', 1, ''),
(1, 57, '2019-12-17 10:00:00', 3, '2019-12-17 10:00:00', '2019-12-17 16:00:00', 1, '');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

CREATE TABLE `salle` (
  `idSalle` int(11) NOT NULL,
  `nbPersonneMax` int(11) NOT NULL,
  `nomSalle` varchar(50) NOT NULL,
  `estActive` bit(1) NOT NULL,
  `idTypeSalle` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `salle`
--

INSERT INTO `salle` (`idSalle`, `nbPersonneMax`, `nomSalle`, `estActive`, `idTypeSalle`) VALUES
(46, 18, 'I181', b'1', 2),
(47, 18, 'I182', b'1', 2),
(48, 18, 'I183', b'1', 2),
(49, 18, 'I184', b'1', 2),
(50, 18, 'I185', b'1', 2),
(51, 30, 'B301', b'1', 1),
(52, 30, 'B302', b'1', 1),
(53, 30, 'B303', b'1', 1),
(54, 30, 'B304', b'1', 1),
(55, 30, 'B305', b'1', 1),
(56, 18, 'B181', b'1', 1),
(57, 18, 'B182', b'1', 1),
(58, 18, 'B183', b'1', 1),
(59, 18, 'B184', b'1', 1),
(60, 18, 'B185', b'1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `typesalle`
--

CREATE TABLE `typesalle` (
  `idTypeSalle` int(11) NOT NULL,
  `typeSalle` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typesalle`
--

INSERT INTO `typesalle` (`idTypeSalle`, `typeSalle`) VALUES
(1, 'Banalisée'),
(2, 'Informatisée');

-- --------------------------------------------------------

--
-- Structure de la table `typeutilisateur`
--

CREATE TABLE `typeutilisateur` (
  `idTypeUtilisateur` int(11) NOT NULL,
  `typeUtilisateur` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `typeutilisateur`
--

INSERT INTO `typeutilisateur` (`idTypeUtilisateur`, `typeUtilisateur`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUtilisateur` int(11) NOT NULL,
  `nomUtilisateur` varchar(50) NOT NULL,
  `prenomUtilisateur` varchar(50) NOT NULL,
  `mailUtilisateur` varchar(50) NOT NULL,
  `telephoneUtilisateur` varchar(10) NOT NULL,
  `loginUtilisateur` varchar(8) NOT NULL,
  `passwordUtilisateur` varchar(255) NOT NULL,
  `idTypeUtilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `nomUtilisateur`, `prenomUtilisateur`, `mailUtilisateur`, `telephoneUtilisateur`, `loginUtilisateur`, `passwordUtilisateur`, `idTypeUtilisateur`) VALUES
(3, 'trudelle', 'florian', 'ftrudell@aifcc.caen', '0666666666', 'ftrudell', 'root', 1),
(4, 'bezos', 'jeff', 'jb@az.co', '0666666666', 'jbezos', 'root', 2),
(7, 'KerHerve', 'Mathieu', 'm.k@makeu.com', '0102030405', 'mkerherv', '123456', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD PRIMARY KEY (`idUtilisateur`,`idLigue`,`dateDebut`),
  ADD KEY `APPARTENIR_LIGUE_FK` (`idLigue`);

--
-- Index pour la table `ligue`
--
ALTER TABLE `ligue`
  ADD PRIMARY KEY (`idLigue`);

--
-- Index pour la table `reserver`
--
ALTER TABLE `reserver`
  ADD PRIMARY KEY (`idLigue`,`idSalle`,`jourReservation`),
  ADD KEY `RESERVER_SALLE_FK` (`idSalle`),
  ADD KEY `RESERVER_UTILISATEUR_FK` (`idUtilisateur`);

--
-- Index pour la table `salle`
--
ALTER TABLE `salle`
  ADD PRIMARY KEY (`idSalle`),
  ADD KEY `SALLE_TYPESALLE_FK` (`idTypeSalle`);

--
-- Index pour la table `typesalle`
--
ALTER TABLE `typesalle`
  ADD PRIMARY KEY (`idTypeSalle`);

--
-- Index pour la table `typeutilisateur`
--
ALTER TABLE `typeutilisateur`
  ADD PRIMARY KEY (`idTypeUtilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`),
  ADD KEY `UTILISATEUR_TYPEUTILISATEUR_FK` (`idTypeUtilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ligue`
--
ALTER TABLE `ligue`
  MODIFY `idLigue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `idSalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT pour la table `typesalle`
--
ALTER TABLE `typesalle`
  MODIFY `idTypeSalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `typeutilisateur`
--
ALTER TABLE `typeutilisateur`
  MODIFY `idTypeUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartenir`
--
ALTER TABLE `appartenir`
  ADD CONSTRAINT `APPARTENIR_LIGUE_FK` FOREIGN KEY (`idLigue`) REFERENCES `ligue` (`idLigue`),
  ADD CONSTRAINT `APPARTENIR_UTILISATEUR_FK` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`);

--
-- Contraintes pour la table `reserver`
--
ALTER TABLE `reserver`
  ADD CONSTRAINT `RESERVER_LIGUE_FK` FOREIGN KEY (`idLigue`) REFERENCES `ligue` (`idLigue`),
  ADD CONSTRAINT `RESERVER_SALLE_FK` FOREIGN KEY (`idSalle`) REFERENCES `salle` (`idSalle`),
  ADD CONSTRAINT `RESERVER_UTILISATEUR_FK` FOREIGN KEY (`idUtilisateur`) REFERENCES `utilisateur` (`idUtilisateur`);

--
-- Contraintes pour la table `salle`
--
ALTER TABLE `salle`
  ADD CONSTRAINT `SALLE_TYPESALLE_FK` FOREIGN KEY (`idTypeSalle`) REFERENCES `typesalle` (`idTypeSalle`);

--
-- Contraintes pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD CONSTRAINT `UTILISATEUR_TYPEUTILISATEUR_FK` FOREIGN KEY (`idTypeUtilisateur`) REFERENCES `typeutilisateur` (`idTypeUtilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
