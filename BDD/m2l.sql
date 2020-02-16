-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  Dim 16 fév. 2020 à 15:14
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

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
DROP PROCEDURE IF EXISTS `PRC_ADD_SALLE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_ADD_SALLE` (`nbPersonneMax` INT, `nomSalle` VARCHAR(50), `estActive` BIT, `idTypeSalle` INT)  BEGIN
	INSERT INTO SALLE(nbPersonneMax,nomSalle,estActive,idTypeSalle) VALUES(nbPersonneMax,nomSalle,estActive,idTypeSalle);
END$$

DROP PROCEDURE IF EXISTS `PRC_DEL_RESERVATION`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_DEL_RESERVATION` (IN `_idReservation` INT)  BEGIN
        DELETE FROM RESERVER
        WHERE idReservation = _idReservation;
        SELECT _idReservation as idReservation;
END$$

DROP PROCEDURE IF EXISTS `PRC_DEL_SALLE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_DEL_SALLE` (`idSalle` INT)  BEGIN
	DELETE FROM SALLE
	WHERE idSalle = idSalle;
END$$

DROP PROCEDURE IF EXISTS `PRC_EST_ADMIN`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_EST_ADMIN` (`pseudo` VARCHAR(10))  BEGIN
	SELECT idTypeUtilisateur FROM UTILISATEUR WHERE loginUtilisateur = pseudo;
END$$

DROP PROCEDURE IF EXISTS `PRC_GET_LIGUE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_LIGUE` (IN `id_utilisateur` INT)  BEGIN
	SELECT LIGUE.idLigue, LIGUE.nomLigue, LIGUE.estActive FROM LIGUE
	INNER JOIN APPARTENIR ON APPARTENIR.idLigue = LIGUE.idLigue
	WHERE idUtilisateur = id_utilisateur;
END$$

DROP PROCEDURE IF EXISTS `PRC_GET_LIGUES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_LIGUES` ()  BEGIN
	SELECT LIGUE.idLigue
		, nomLigue 
        , estActive
        , APPARTENIR.idUtilisateur
        FROM LIGUE
        LEFT JOIN APPARTENIR ON APPARTENIR.idLigue =  LIGUE.idLigue;
END$$

DROP PROCEDURE IF EXISTS `PRC_GET_RESERVATION`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_RESERVATION` ()  BEGIN
        IF((SELECT COUNT(idReservation) FROM reserver) > 0) THEN
	    SELECT idReservation as 'id'
	    ,CONCAT(nomSalle, ' - ', nomLigue) as 'title'
	    ,heureDebut as 'start'
	    ,heureFin as 'end'
	    ,nomSalle as 'nomSalle'
	    ,nomLigue as 'nomLigue'
	    ,descriptionR as 'descriptionR'
        ,Ligue.idLigue as 'idLigue'
        ,Salle.idSalle as 'idSalle'
	    FROM RESERVER JOIN UTILISATEUR ON RESERVER.idUtilisateur = UTILISATEUR.idUtilisateur
	    JOIN LIGUE ON RESERVER.idLigue = LIGUE.idLigue
	    JOIN SALLE ON RESERVER.idSalle = SALLE.idSalle;
        ELSE
            SELECT '' as id
	    ,'' as title
	    ,'' as start
	    ,'' as end
	    ,'' as nomSalle
	    ,'' as nomLigue
	    ,'' as descriptionR
        ,'' as idLigue
        ,'' as idSalle;
        END IF;

END$$

DROP PROCEDURE IF EXISTS `PRC_GET_RESERVATION_BY_ID`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_RESERVATION_BY_ID` (IN `_idLigue` INT)  NO SQL
BEGIN
        IF((SELECT COUNT(idReservation) FROM reserver) > 0) THEN
	    SELECT idReservation as 'id'
	    ,CONCAT(nomSalle, ' - ', nomLigue) as 'title'
	    ,heureDebut as 'start'
	    ,heureFin as 'end'
	    ,nomSalle as 'nomSalle'
	    ,nomLigue as 'nomLigue'
	    ,descriptionR as 'descriptionR'
        ,Ligue.idLigue as 'idLigue'
        ,Salle.idSalle as 'idSalle'
	    FROM RESERVER 
        JOIN UTILISATEUR ON RESERVER.idUtilisateur = UTILISATEUR.idUtilisateur
	    JOIN LIGUE ON RESERVER.idLigue = LIGUE.idLigue
	    JOIN SALLE ON RESERVER.idSalle = SALLE.idSalle
        WHERE Ligue.idLigue = _idLigue;
        ELSE
            SELECT '' as id
	    ,'' as title
	    ,'' as start
	    ,'' as end
	    ,'' as nomSalle
	    ,'' as nomLigue
	    ,'' as descriptionR
        ,'' as idLigue
        ,'' as idSalle;
        END IF;

END$$

DROP PROCEDURE IF EXISTS `PRC_GET_SALLES`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_SALLES` ()  BEGIN
	SELECT salle.idTypeSalle
    , typesalle.typeSalle
    , nbPersonneMax
    , nomSalle
    , salle.idSalle
    , salle.estActive
	FROM typesalle
	JOIN salle ON typesalle.idTypeSalle = salle.idTypeSalle
	ORDER BY nomSalle;
END$$

DROP PROCEDURE IF EXISTS `PRC_GET_SALLES_RESERVE`$$
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

DROP PROCEDURE IF EXISTS `PRC_GET_USERS`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_USERS` ()  BEGIN
	SELECT *
	FROM UTILISATEUR;
END$$

DROP PROCEDURE IF EXISTS `PRC_GET_USER_BY_ID`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_USER_BY_ID` (IN `_idUtilisateur` INT)  NO SQL
BEGIN
	SELECT * FROM UTILISATEUR WHERE idUtilisateur = _idUtilisateur;
END$$

DROP PROCEDURE IF EXISTS `PRC_GET_USER_BY_LOGIN`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_USER_BY_LOGIN` (IN `_loginUtilisateur` VARCHAR(10))  BEGIN
	SELECT * FROM UTILISATEUR WHERE loginUtilisateur = _loginUtilisateur;
END$$

DROP PROCEDURE IF EXISTS `PRC_RESERVER`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_RESERVER` (IN `_heureDebut` VARCHAR(255), IN `_heureFin` VARCHAR(255), IN `_nomSalle` VARCHAR(10) CHARSET utf8, IN `_idUser` INT, IN `_idLigue` INT, IN `_description` VARCHAR(255) CHARSET utf8)  BEGIN
	DECLARE _idSalle, _idReservation INT;
	SELECT idSalle INTO _idSalle FROM salle WHERE nomSalle = _nomSalle;
    SELECT (IF(COUNT(idReservation) = 0, 0, (MAX(idReservation) + 1))) AS idReservation INTO _idReservation FROM reserver ORDER BY idReservation DESC LIMIT 1;

    INSERT INTO RESERVER(idReservation
                         ,idLigue
                         ,idSalle
                         ,jourReservation
                         ,idUtilisateur
                         ,heureDebut
                         ,heureFin
                         ,descriptionR) VALUES (
                             _idReservation
                             ,_idLigue
                             ,_idSalle
                             	,FROM_UNIXTIME(_heureDebut)
                             ,_idUser
                             ,FROM_UNIXTIME(_heureDebut)
                             ,FROM_UNIXTIME(_heureFin)
                             ,_description
                         );
END$$

DROP PROCEDURE IF EXISTS `PRC_SIGNIN`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_SIGNIN` (IN `pseudo` VARCHAR(10) CHARSET utf8, IN `mdp` VARCHAR(255) CHARSET utf8)  BEGIN
	SELECT COUNT(*) as nbUser FROM UTILISATEUR WHERE loginUtilisateur = pseudo AND passwordUtilisateur = mdp;
END$$

DROP PROCEDURE IF EXISTS `PRC_SIGNUP`$$
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

DROP PROCEDURE IF EXISTS `PRC_UPD_ACTIVE_LIGUE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_ACTIVE_LIGUE` (IN `_idLigue` INT)  NO SQL
BEGIN
	DECLARE _estActive BIT;
	SELECT estActive INTO _estActive FROM ligue WHERE idLigue = _idLigue;

	UPDATE ligue
	SET estActive = NOT _estActive
	WHERE idLigue = _idLigue;
END$$

DROP PROCEDURE IF EXISTS `PRC_UPD_ACTIVE_SALLE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_ACTIVE_SALLE` (IN `_idSalle` INT)  BEGIN
	DECLARE _estActive BIT;
	SELECT estActive INTO _estActive FROM salle WHERE idSalle = _idSalle;

	UPDATE salle
	SET estActive = NOT _estActive
	WHERE idSalle = _idSalle;
END$$

DROP PROCEDURE IF EXISTS `PRC_UPD_INFORMATISEE_SALLE`$$
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

DROP PROCEDURE IF EXISTS `PRC_UPD_NBPLACE_SALLE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_NBPLACE_SALLE` (IN `_idSalle` INT, IN `_nbPersonneMax` INT)  BEGIN
	UPDATE SALLE
	SET nbPersonneMax = _nbPersonneMax
	WHERE idSalle = _idSalle;
END$$

DROP PROCEDURE IF EXISTS `PRC_UPD_NOM_LIGUE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_NOM_LIGUE` (IN `_idLigue` INT, IN `_nomLigue` VARCHAR(50) CHARSET utf8)  NO SQL
BEGIN
	UPDATE LIGUE
	SET nomLigue = _nomLigue
	WHERE idLigue = _idLigue;
END$$

DROP PROCEDURE IF EXISTS `PRC_UPD_NOM_SALLE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_NOM_SALLE` (IN `_idSalle` INT, IN `_nomSalle` VARCHAR(50) CHARSET utf8)  BEGIN
	UPDATE SALLE
	SET nomSalle = _nomSalle
	WHERE idSalle = _idSalle;
END$$

DROP PROCEDURE IF EXISTS `PRC_UPD_RESERVATION`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_RESERVATION` (IN `_heureDebut` DATETIME, IN `_heureFin` DATETIME, IN `_nomSalle` VARCHAR(10) CHARSET utf8, IN `_idUser` INT, IN `_idLigue` INT, IN `_description` VARCHAR(255) CHARSET utf8, IN `_idReservation` INT)  NO SQL
UPDATE reserver
SET idLigue = _idLigue,
idSalle = (SELECT idSalle FROM salle WHERE nomSalle = _nomSalle),
jourReservation = _heureDebut,
idUtilisateur = _idUser,
heureDebut = _heureDebut,
heureFin = _heureFin,
descriptionR = _description
WHERE idReservation = _idReservation$$

DROP PROCEDURE IF EXISTS `PRC_UPD_USER_LIGUE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_USER_LIGUE` (IN `_idLigue` INT, IN `_idUserLigue` INT)  NO SQL
UPDATE appartenir
SET idUtilisateur = _idUserLigue
WHERE idLigue = _idLigue$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

DROP TABLE IF EXISTS `appartenir`;
CREATE TABLE IF NOT EXISTS `appartenir` (
  `idUtilisateur` int(11) NOT NULL,
  `idLigue` int(11) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date DEFAULT NULL,
  PRIMARY KEY (`idUtilisateur`,`idLigue`,`dateDebut`),
  KEY `APPARTENIR_LIGUE_FK` (`idLigue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `appartenir`
--

INSERT INTO `appartenir` (`idUtilisateur`, `idLigue`, `dateDebut`, `dateFin`) VALUES
(3, 0, '2020-02-12', NULL),
(4, 1, '2019-10-17', '2050-12-31'),
(7, 2, '2019-10-17', '2050-12-31');

-- --------------------------------------------------------

--
-- Structure de la table `ligue`
--

DROP TABLE IF EXISTS `ligue`;
CREATE TABLE IF NOT EXISTS `ligue` (
  `idLigue` int(11) NOT NULL AUTO_INCREMENT,
  `nomLigue` varchar(50) NOT NULL,
  `estActive` bit(1) NOT NULL,
  PRIMARY KEY (`idLigue`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ligue`
--

INSERT INTO `ligue` (`idLigue`, `nomLigue`, `estActive`) VALUES
(0, 'ADMIN', b'1'),
(1, 'DeBeaufs', b'1'),
(2, 'DePorts', b'1');

-- --------------------------------------------------------

--
-- Structure de la table `reserver`
--

DROP TABLE IF EXISTS `reserver`;
CREATE TABLE IF NOT EXISTS `reserver` (
  `idReservation` int(11) NOT NULL DEFAULT '0',
  `idLigue` int(11) NOT NULL,
  `idSalle` int(11) NOT NULL,
  `jourReservation` varchar(255) NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `heureDebut` varchar(255) NOT NULL,
  `heureFin` varchar(255) NOT NULL,
  `descriptionR` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idLigue`,`idSalle`,`jourReservation`),
  KEY `RESERVER_SALLE_FK` (`idSalle`),
  KEY `RESERVER_UTILISATEUR_FK` (`idUtilisateur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reserver`
--

INSERT INTO `reserver` (`idReservation`, `idLigue`, `idSalle`, `jourReservation`, `idUtilisateur`, `heureDebut`, `heureFin`, `descriptionR`) VALUES
(4, 1, 56, '2020-02-10 10:00:00', 4, '2020-02-10 10:00:00', '2020-02-10 11:00:00', ''),
(0, 1, 56, '2020-02-11 10:00:00', 3, '2020-02-11 10:00:00', '2020-02-11 11:00:00', ''),
(5, 1, 56, '2020-02-12 10:00:00.000000', 3, '2020-02-12 10:00:00.000000', '2020-02-12 11:00:00.000000', ''),
(2, 1, 56, '2020-02-13 10:00:00', 3, '2020-02-13 10:00:00', '2020-02-13 11:00:00', ''),
(7, 1, 57, '2020-02-10 11:00:00.000000', 3, '2020-02-10 11:00:00.000000', '2020-02-10 12:00:00.000000', ''),
(6, 1, 57, '2020-02-14 10:00:00.000000', 3, '2020-02-14 10:00:00.000000', '2020-02-14 11:00:00.000000', '');

-- --------------------------------------------------------

--
-- Structure de la table `salle`
--

DROP TABLE IF EXISTS `salle`;
CREATE TABLE IF NOT EXISTS `salle` (
  `idSalle` int(11) NOT NULL AUTO_INCREMENT,
  `nbPersonneMax` int(11) NOT NULL,
  `nomSalle` varchar(50) NOT NULL,
  `estActive` bit(1) NOT NULL,
  `idTypeSalle` int(11) NOT NULL,
  PRIMARY KEY (`idSalle`),
  KEY `SALLE_TYPESALLE_FK` (`idTypeSalle`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

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
(59, 18, 'B185', b'1', 1),
(60, 18, 'B184', b'1', 1);

-- --------------------------------------------------------

--
-- Structure de la table `typesalle`
--

DROP TABLE IF EXISTS `typesalle`;
CREATE TABLE IF NOT EXISTS `typesalle` (
  `idTypeSalle` int(11) NOT NULL AUTO_INCREMENT,
  `typeSalle` varchar(50) NOT NULL,
  PRIMARY KEY (`idTypeSalle`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `typeutilisateur`;
CREATE TABLE IF NOT EXISTS `typeutilisateur` (
  `idTypeUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `typeUtilisateur` varchar(10) NOT NULL,
  PRIMARY KEY (`idTypeUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

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

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `nomUtilisateur` varchar(50) NOT NULL,
  `prenomUtilisateur` varchar(50) NOT NULL,
  `mailUtilisateur` varchar(50) NOT NULL,
  `telephoneUtilisateur` varchar(10) NOT NULL,
  `loginUtilisateur` varchar(8) NOT NULL,
  `passwordUtilisateur` varchar(255) NOT NULL,
  `idTypeUtilisateur` int(11) NOT NULL,
  PRIMARY KEY (`idUtilisateur`),
  KEY `UTILISATEUR_TYPEUTILISATEUR_FK` (`idTypeUtilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `nomUtilisateur`, `prenomUtilisateur`, `mailUtilisateur`, `telephoneUtilisateur`, `loginUtilisateur`, `passwordUtilisateur`, `idTypeUtilisateur`) VALUES
(3, 'trudelle', 'florian', 'ftrudell@aifcc.caen', '0666666666', 'ftrudell', 'root', 1),
(4, 'bezos', 'jeff', 'jb@az.co', '0666666666', 'jbezos', 'root', 2),
(7, 'KerHerve', 'Mathieu', 'm.k@makeu.com', '0102030405', 'mkerherv', '123456', 2);

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