-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 20 fév. 2020 à 13:10
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_ADD_LIGUE` (IN `_nomLigue` VARCHAR(255), IN `_userLigue` VARCHAR(255), IN `_estActive` BIT(1))  NO SQL
BEGIN
	DECLARE _idLigue, _idUtilisateur INT;
    
	INSERT INTO ligue(nomLigue,estActive)
    VALUES (_nomLigue,_estActive);
    
    SELECT idLigue INTO _idLigue FROM ligue ORDER BY idLigue DESC LIMIT 1;
    SELECT idUtilisateur INTO _idUtilisateur FROM utilisateur WHERE loginUtilisateur = _userLigue;
    
    INSERT INTO appartenir(idUtilisateur,idLigue,dateDebut,dateFin)
    VALUES(_idUtilisateur,_idLigue,NOW(), NULL);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_ADD_SALLE` (IN `_nbPersonneMax` INT, IN `_nomSalle` VARCHAR(50) CHARSET utf8, IN `_estActive` INT, IN `_idTypeSalle` INT)  BEGIN
	INSERT INTO SALLE(nbPersonneMax,nomSalle,estActive,idTypeSalle)
    VALUES(_nbPersonneMax,_nomSalle,_estActive,_idTypeSalle);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_DEL_RESERVATION` (IN `_idReservation` INT)  BEGIN
        DELETE FROM RESERVER
        WHERE idReservation = _idReservation;
        SELECT _idReservation as idReservation;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_DEL_SALLE` (`idSalle` INT)  BEGIN
	DELETE FROM SALLE
	WHERE idSalle = idSalle;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_EST_ADMIN` (`pseudo` VARCHAR(10))  BEGIN
	SELECT idTypeUtilisateur FROM UTILISATEUR WHERE loginUtilisateur = pseudo;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_LIGUE` (IN `id_utilisateur` INT)  BEGIN
	SELECT LIGUE.idLigue, LIGUE.nomLigue, LIGUE.estActive FROM LIGUE
	INNER JOIN APPARTENIR ON APPARTENIR.idLigue = LIGUE.idLigue
	WHERE idUtilisateur = id_utilisateur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_LIGUES` ()  BEGIN
	SELECT LIGUE.idLigue
		, nomLigue 
        , estActive
        , APPARTENIR.idUtilisateur
        FROM LIGUE
        LEFT JOIN APPARTENIR ON APPARTENIR.idLigue =  LIGUE.idLigue;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_RESERVATION` ()  BEGIN
        IF((SELECT COUNT(idReservation) FROM reserver) > 0) THEN
	    SELECT idReservation as 'id'
	    ,nomSalle as 'title'
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_RESERVATION_BY_ID` (IN `_idLigue` INT)  NO SQL
BEGIN
        IF((SELECT COUNT(idReservation) FROM reserver) > 0) THEN
	    SELECT idReservation as 'id'
	    ,nomSalle as 'title'
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_SALLES_RESERVE` (IN `dateDebut` VARCHAR(255) CHARSET utf8, IN `dateFin` VARCHAR(255) CHARSET utf8)  BEGIN
	SELECT SALLE.idSalle
	FROM SALLE 
	WHERE SALLE.idSalle 
	IN 
	(
		SELECT RESERVER.idSalle FROM RESERVER
		WHERE
        (FROM_UNIXTIME(dateDebut) BETWEEN reserver.heureDebut AND reserver.heureFin)
        OR
        (FROM_UNIXTIME(dateFin) BETWEEN reserver.heureDebut AND reserver.heureFin)
        OR
        (FROM_UNIXTIME(dateDebut) < reserver.heureDebut AND FROM_UNIXTIME(dateFin) > reserver.heureFin)
	);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_USERS` ()  BEGIN
	SELECT *
	FROM UTILISATEUR;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_USER_BY_ID` (IN `_idUtilisateur` INT)  NO SQL
BEGIN
	SELECT * FROM UTILISATEUR WHERE idUtilisateur = _idUtilisateur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_USER_BY_LOGIN` (IN `_loginUtilisateur` VARCHAR(10))  BEGIN
	SELECT * FROM UTILISATEUR WHERE loginUtilisateur = _loginUtilisateur;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_GET_USER_LIBRE` ()  NO SQL
BEGIN
	SELECT idUtilisateur,loginUtilisateur
    FROM utilisateur
    WHERE idUtilisateur NOT IN (SELECT idUtilisateur FROM appartenir);
END$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_ACTIVE_LIGUE` (IN `_idLigue` INT)  NO SQL
BEGIN
	DECLARE _estActive BIT;
	SELECT estActive INTO _estActive FROM ligue WHERE idLigue = _idLigue;

	UPDATE ligue
	SET estActive = NOT _estActive
	WHERE idLigue = _idLigue;
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_NOM_LIGUE` (IN `_idLigue` INT, IN `_nomLigue` VARCHAR(50) CHARSET utf8)  NO SQL
BEGIN
	UPDATE LIGUE
	SET nomLigue = _nomLigue
	WHERE idLigue = _idLigue;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_NOM_SALLE` (IN `_idSalle` INT, IN `_nomSalle` VARCHAR(50) CHARSET utf8)  BEGIN
	UPDATE SALLE
	SET nomSalle = _nomSalle
	WHERE idSalle = _idSalle;
END$$

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

CREATE DEFINER=`root`@`localhost` PROCEDURE `PRC_UPD_USER_LIGUE` (IN `_idLigue` INT, IN `_idUserLigue` INT)  NO SQL
UPDATE appartenir
SET idUtilisateur = _idUserLigue
WHERE idLigue = _idLigue$$

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
(3, 0, '2020-02-12', NULL),
(4, 1, '2019-10-17', '2050-12-31'),
(7, 2, '2019-10-17', '2050-12-31'),
(8, 15, '2020-02-20', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ligue`
--

CREATE TABLE `ligue` (
  `idLigue` int(11) NOT NULL,
  `nomLigue` varchar(50) NOT NULL,
  `estActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ligue`
--

INSERT INTO `ligue` (`idLigue`, `nomLigue`, `estActive`) VALUES
(0, 'ADMIN', b'1'),
(1, 'DeBeaufs', b'1'),
(2, 'DePorts', b'1'),
(15, 'DeJo', b'1');

-- --------------------------------------------------------

--
-- Structure de la table `reserver`
--

CREATE TABLE `reserver` (
  `idReservation` int(11) NOT NULL DEFAULT '0',
  `idLigue` int(11) NOT NULL,
  `idSalle` int(11) NOT NULL,
  `jourReservation` datetime NOT NULL,
  `idUtilisateur` int(11) NOT NULL,
  `heureDebut` datetime NOT NULL,
  `heureFin` datetime NOT NULL,
  `descriptionR` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reserver`
--

INSERT INTO `reserver` (`idReservation`, `idLigue`, `idSalle`, `jourReservation`, `idUtilisateur`, `heureDebut`, `heureFin`, `descriptionR`) VALUES
(4, 1, 56, '2020-02-10 10:00:00', 4, '2020-02-10 10:00:00', '2020-02-10 11:00:00', ''),
(9, 1, 56, '2020-02-10 11:30:00', 4, '2020-02-10 11:30:00', '2020-02-10 12:30:00', ''),
(0, 1, 56, '2020-02-11 10:00:00', 3, '2020-02-11 10:00:00', '2020-02-11 11:00:00', ''),
(8, 1, 56, '2020-02-11 11:00:00', 4, '2020-02-11 11:00:00', '2020-02-11 12:00:00', ''),
(5, 1, 56, '2020-02-12 10:00:00', 3, '2020-02-12 10:00:00', '2020-02-12 11:00:00', ''),
(2, 1, 56, '2020-02-13 10:00:00', 3, '2020-02-13 10:00:00', '2020-02-13 11:00:00', ''),
(10, 1, 56, '2020-02-17 09:00:00', 4, '2020-02-17 09:00:00', '2020-02-17 10:00:00', ''),
(11, 1, 56, '2020-02-18 09:00:00', 4, '2020-02-18 09:00:00', '2020-02-18 10:00:00', ''),
(12, 1, 56, '2020-02-19 09:00:00', 3, '2020-02-19 09:00:00', '2020-02-19 10:00:00', ''),
(16, 1, 56, '2020-02-19 17:00:00', 3, '2020-02-19 17:00:00', '2020-02-19 18:00:00', ''),
(22, 1, 56, '2020-02-21 14:00:00', 3, '2020-02-21 14:00:00', '2020-02-21 15:00:00', ''),
(7, 1, 57, '2020-02-10 11:00:00', 3, '2020-02-10 11:00:00', '2020-02-10 12:00:00', ''),
(6, 1, 57, '2020-02-14 10:00:00', 3, '2020-02-14 10:00:00', '2020-02-14 11:00:00', ''),
(13, 1, 57, '2020-02-18 09:00:00', 3, '2020-02-18 09:00:00', '2020-02-18 10:00:00', ''),
(23, 1, 57, '2020-02-21 13:00:00', 3, '2020-02-21 13:00:00', '2020-02-21 14:00:00', ''),
(21, 1, 57, '2020-02-21 16:00:00', 3, '2020-02-21 16:00:00', '2020-02-21 17:00:00', ''),
(14, 1, 58, '2020-02-18 09:00:00', 3, '2020-02-18 09:00:00', '2020-02-18 10:00:00', ''),
(15, 1, 58, '2020-02-20 09:00:00', 3, '2020-02-20 09:00:00', '2020-02-20 10:00:00', ''),
(24, 1, 58, '2020-02-21 13:00:00', 3, '2020-02-21 13:00:00', '2020-02-21 14:00:00', ''),
(26, 1, 59, '2020-02-21 13:00:00', 3, '2020-02-21 13:00:00', '2020-02-21 14:00:00', ''),
(25, 1, 60, '2020-02-21 13:00:00', 3, '2020-02-21 13:00:00', '2020-02-21 14:00:00', '');

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
(59, 18, 'B185', b'1', 1),
(60, 18, 'B184', b'1', 1),
(61, 50, 'B186', b'1', 1),
(62, 50, 'B306', b'1', 1);

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
(7, 'KerHerve', 'Mathieu', 'm.k@makeu.com', '0102030405', 'mkerherv', '123456', 2),
(8, 'MakeuMobile', 'Makeu', 'mllzae@dsmg.fr', '0690548745', 'mmakeumo', '29061990', 2),
(9, 'lopez', 'tom', 'tom.lopez@tamere.com', '0611111111', 'tlopez', '123456', 2);

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
  MODIFY `idLigue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `salle`
--
ALTER TABLE `salle`
  MODIFY `idSalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

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
  MODIFY `idUtilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
