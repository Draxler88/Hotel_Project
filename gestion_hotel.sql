-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 24 août 2024 à 02:38
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestion_hotel`
--

-- --------------------------------------------------------

--
-- Structure de la table `capacité_chambre`
--

CREATE TABLE `capacité_chambre` (
  `Id_capacité` int(11) NOT NULL,
  `Titre_capacite` varchar(100) DEFAULT NULL,
  `Numero_capacite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `capacité_chambre`
--

INSERT INTO `capacité_chambre` (`Id_capacité`, `Titre_capacite`, `Numero_capacite`) VALUES
(1, 'Single Room', 1),
(2, 'Double Room', 2),
(3, 'Family Room', 4),
(4, 'Suite', 3),
(5, 'Dormitory', 6);

-- --------------------------------------------------------

--
-- Structure de la table `chambre`
--

CREATE TABLE `chambre` (
  `Id_chambre` int(11) NOT NULL,
  `Numéro_chambre` varchar(50) DEFAULT NULL,
  `Nombre_adultes_enfants_ch` int(11) DEFAULT NULL,
  `Renfort_chambre` tinyint(1) DEFAULT NULL,
  `Etage_chambre` int(11) DEFAULT NULL,
  `Nbr_lits_chambre` int(11) DEFAULT NULL,
  `Id_type` int(11) DEFAULT NULL,
  `Id_capacité` int(11) DEFAULT NULL,
  `Id_tarif` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `chambre`
--

INSERT INTO `chambre` (`Id_chambre`, `Numéro_chambre`, `Nombre_adultes_enfants_ch`, `Renfort_chambre`, `Etage_chambre`, `Nbr_lits_chambre`, `Id_type`, `Id_capacité`, `Id_tarif`) VALUES
(1, '101', 2, 0, 1, 1, 2, 2, 1),
(2, '102', 4, 1, 1, 2, 3, 3, 3),
(3, '201', 1, 0, 2, 1, 1, 1, 5),
(4, '202', 2, 0, 2, 1, 4, 2, 2),
(5, '301', 3, 0, 3, 2, 4, 4, 4),
(6, '9', 3, 1, 4, 2, 1, 3, 4);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `Id_Client` int(11) NOT NULL ,
  `Nom_complet` varchar(255) DEFAULT NULL,
  `Sexe` varchar(50) DEFAULT NULL,
  `Date_naissance` date DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Pays` varchar(100) DEFAULT NULL,
  `Ville` varchar(100) DEFAULT NULL,
  `Adresse` varchar(255) DEFAULT NULL,
  `Telephone` varchar(50) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Autres_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`Id_Client`, `Nom_complet`, `Sexe`, `Date_naissance`, `Age`, `Pays`, `Ville`, `Adresse`, `Telephone`, `Email`, `Autres_details`) VALUES
(1, 'Mbarek', 'Man', '1993-06-25', 38, 'Morocco', 'Larache', 'centre ville Larache', '0637014060', 'bovix33455@wuzak.com', 'walo'),
(2, 'Qasosan', 'Man', '1982-06-05', 42, 'Antarctica', 'simido', '', '0687345352', 'ghasali@gmail.com', ''),
(4, 'Alice Johnson', 'Female', '1985-04-12', 39, 'USA', 'New York', '123 Main St', '+1-555-1234', 'alice.johnson@example.com', 'Regular customer, prefers non-smoking rooms'),
(5, 'Bob Smith', 'Man', '1990-08-23', 34, 'Canada', 'Toronto', '456 Elm St', '+1-555-5678', 'bob.smith@example.com', 'VIP member, requests early check-in'),
(6, 'Carla Brown', 'Female', '1978-11-05', 45, 'UK', 'London', '789 Oak St', '+44-20-1234-5678', 'carla.brown@example.co.uk', 'Prefers rooms on higher floors');

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `Id_reservation` int(11) NOT NULL,
  `Code_reservation` varchar(100) DEFAULT NULL,
  `Date_heure_reservation` datetime DEFAULT NULL,
  `Date_arrivée` date DEFAULT NULL,
  `Date_départ` date DEFAULT NULL,
  `Nbr_jours` int(11) DEFAULT NULL,
  `Nbr_adultes_enfants` int(11) DEFAULT NULL,
  `Montant_total` decimal(10,2) DEFAULT NULL,
  `Etat` varchar(50) DEFAULT NULL,
  `Id_Client` int(11) DEFAULT NULL,
  `Id_Chambre` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`Id_reservation`, `Code_reservation`, `Date_heure_reservation`, `Date_arrivée`, `Date_départ`, `Nbr_jours`, `Nbr_adultes_enfants`, `Montant_total`, `Etat`, `Id_Client`, `Id_Chambre`) VALUES
(1, '1', '2024-08-23 16:07:22', '2024-08-24', '2024-08-27', 3, 4, 450.00, 'Planifiée', 2, 2),
(2, '3', '2024-08-24 02:06:00', '2024-08-01', '2024-08-03', 2, 3, 500.00, 'Terminée', 5, 6);

-- --------------------------------------------------------

--
-- Structure de la table `tarif_chambre`
--

CREATE TABLE `tarif_chambre` (
  `Id_tarif` int(11) NOT NULL,
  `Prix_base_nuit` decimal(10,2) DEFAULT NULL,
  `Prix_base_passage` decimal(10,2) DEFAULT NULL,
  `N_Prix_nuit` decimal(10,2) DEFAULT NULL,
  `N_Prix_passage` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tarif_chambre`
--

INSERT INTO `tarif_chambre` (`Id_tarif`, `Prix_base_nuit`, `Prix_base_passage`, `N_Prix_nuit`, `N_Prix_passage`) VALUES
(1, 100.00, 50.00, 90.00, 45.00),
(2, 200.00, 100.00, 180.00, 90.00),
(3, 150.00, 75.00, 135.00, 67.50),
(4, 250.00, 125.00, 225.00, 112.50),
(5, 80.00, 40.00, 72.00, 36.00);

-- --------------------------------------------------------

--
-- Structure de la table `type_chambre`
--

CREATE TABLE `type_chambre` (
  `Id_type` int(11) NOT NULL,
  `Type_chambre` varchar(100) DEFAULT NULL,
  `Description_type` text DEFAULT NULL,
  `Photos` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_chambre`
--

INSERT INTO `type_chambre` (`Id_type`, `Type_chambre`, `Description_type`, `Photos`) VALUES
(1, 'Lux', 'Luxurious rooms with premium amenities and services', '44146554.jpg'),
(2, 'Standard', 'Standard rooms with basic amenities', '232571300 (1).jpg'),
(3, 'Suite', 'Spacious suites with separate living areas and extra features', '232571262 (1).jpg'),
(4, 'VIP', 'Exclusive VIP rooms with top-tier services and privacy', 'lobby.jpg'),
(6, 'aaaa', 'aaaa', '232571300 (1).jpg');

-- --------------------------------------------------------

--
-- Structure de la table `users_app`
--

CREATE TABLE `users_app` (
  `Id_user` int(11) NOT NULL,
  `Nom` varchar(100) DEFAULT NULL,
  `Prénom` varchar(100) DEFAULT NULL,
  `Username` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `Etat` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users_app`
--

INSERT INTO `users_app` (`Id_user`, `Nom`, `Prénom`, `Username`, `Password`, `Type`, `Etat`) VALUES
(1, 'Ferhat', 'Mohamed', 'Admin', '123', 'manager', 'active'),
(3, 'oussama', 'Qas', 'Qasdan', '123', 'receptionniste', 'active');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `capacité_chambre`
--
ALTER TABLE `capacité_chambre`
  ADD PRIMARY KEY (`Id_capacité`);

--
-- Index pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD PRIMARY KEY (`Id_chambre`),
  ADD KEY `Id_type_ch` (`Id_type`),
  ADD KEY `Id_capacité` (`Id_capacité`),
  ADD KEY `fk_tarif_chambre` (`Id_tarif`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`Id_Client`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`Id_reservation`),
  ADD KEY `Id_Client` (`Id_Client`),
  ADD KEY `Id_Chambre` (`Id_Chambre`);

--
-- Index pour la table `tarif_chambre`
--
ALTER TABLE `tarif_chambre`
  ADD PRIMARY KEY (`Id_tarif`);

--
-- Index pour la table `type_chambre`
--
ALTER TABLE `type_chambre`
  ADD PRIMARY KEY (`Id_type`);

--
-- Index pour la table `users_app`
--
ALTER TABLE `users_app`
  ADD PRIMARY KEY (`Id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `capacité_chambre`
--
ALTER TABLE `capacité_chambre`
  MODIFY `Id_capacité` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `chambre`
--
ALTER TABLE `chambre`
  MODIFY `Id_chambre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `Id_Client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `Id_reservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tarif_chambre`
--
ALTER TABLE `tarif_chambre`
  MODIFY `Id_tarif` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `type_chambre`
--
ALTER TABLE `type_chambre`
  MODIFY `Id_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users_app`
--
ALTER TABLE `users_app`
  MODIFY `Id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `chambre`
--
ALTER TABLE `chambre`
  ADD CONSTRAINT `chambre_ibfk_1` FOREIGN KEY (`Id_type`) REFERENCES `type_chambre` (`Id_type`),
  ADD CONSTRAINT `chambre_ibfk_2` FOREIGN KEY (`Id_capacité`) REFERENCES `capacité_chambre` (`Id_capacité`),
  ADD CONSTRAINT `fk_tarif_chambre` FOREIGN KEY (`Id_tarif`) REFERENCES `tarif_chambre` (`Id_tarif`);

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`Id_Client`) REFERENCES `client` (`Id_Client`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`Id_Chambre`) REFERENCES `chambre` (`Id_chambre`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
