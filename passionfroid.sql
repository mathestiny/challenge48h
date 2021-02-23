-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 23 fév. 2021 à 13:38
-- Version du serveur :  10.4.14-MariaDB
-- Version de PHP : 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `passionfroid`
--

-- --------------------------------------------------------

--
-- Structure de la table `annonce`
--

CREATE TABLE `annonce` (
  `id_annonce` int(5) NOT NULL,
  `id_compte` int(5) DEFAULT NULL,
  `titre` varchar(50) DEFAULT NULL,
  `descript` text DEFAULT NULL,
  `nomrue` varchar(50) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `codepostal` int(5) DEFAULT NULL,
  `prix` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `annonce`
--

INSERT INTO `annonce` (`id_annonce`, `id_compte`, `titre`, `descript`, `nomrue`, `ville`, `codepostal`, `prix`) VALUES
(35, 20, '2131321', '321312', NULL, NULL, NULL, NULL),
(42, 20, 'hello', 'hello', NULL, NULL, NULL, NULL),
(48, 21, '123', '321', NULL, NULL, NULL, NULL),
(49, 20, 'test2', 'test2', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id_compte` int(5) NOT NULL,
  `prenom` varchar(20) DEFAULT NULL,
  `nom` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `tel` varchar(14) DEFAULT NULL,
  `mdp` varchar(50) DEFAULT NULL,
  `nomphoto` text DEFAULT NULL,
  `solde` int(5) DEFAULT NULL,
  `presentation` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id_compte`, `prenom`, `nom`, `email`, `tel`, `mdp`, `nomphoto`, `solde`, `presentation`) VALUES
(20, 'Régional', 'Test', 'annonces.test@gmail.com', '01 23 45 67 89', 'test', 'female-place-holder-profile-image.jpg', 2242, 'Compte de test responsable de la cr&eacute;ation d&#039;annonces ~ '),
(21, 'National', 'Test', 'client.test@gmail.com', '01 23 45 67 89', 'test', 'person-gray-photo-placeholder-man-vector-22808082.jpg', 98757, 'Compte de test responsable de la location de biens'),
(23, 'Mat', 'Test', 'shinady93@gmail.com', 'Non renseigné', '123123', 'profilepicture.jpg', 123, 'Non renseignée');

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `id_photo` int(5) NOT NULL,
  `id_annonce` int(5) DEFAULT NULL,
  `nomphoto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`id_photo`, `id_annonce`, `nomphoto`) VALUES
(69, 35, '1006_Cuisse de canard de Barbarie VF 280 380 g.jpg'),
(76, 42, '1006_Cuisse de canard de Barbarie VF 280 380 g.jpg'),
(77, 42, '1099_Cuisse de lapin 175 225 g.jpg'),
(78, 42, '1547_Poêlée de riz cantonnais à la dinde Paysan Breton.jpg'),
(79, 42, '7419-4_Crème légère liquide 18� MG UHT 1 litre PassionFroid.jpg'),
(80, 42, '9922-RC_Tournedos de filet de canard de Barbarie VF 140160 g.jpg'),
(81, 42, '12249_Salade coleslaw PassionFroid.jpg'),
(82, 42, '14451.jpg'),
(83, 42, '16660-2-RC_Maroilles AOP 26 � MG 750 g.jpg'),
(84, 42, '20089-Ciboulette coupée 500 g PassionFroid.jpg'),
(85, 42, '20090_Persil plat haché 500 g PassionFroid.jpg'),
(86, 42, '21909_Steak de requin peau bleue sans peau sans cartilage 140 160 g.jpg'),
(87, 42, '24728-2_Pain suédois rond 15,5 cm - 55 g.jpg'),
(93, 48, '221575.jpg'),
(94, 49, '26212_Légumes pour couscous PassionFroid.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD PRIMARY KEY (`id_annonce`),
  ADD KEY `id_compte` (`id_compte`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id_compte`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `id_annonce` (`id_annonce`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `annonce`
--
ALTER TABLE `annonce`
  MODIFY `id_annonce` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `id_compte` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id_photo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `annonce`
--
ALTER TABLE `annonce`
  ADD CONSTRAINT `annonce_ibfk_1` FOREIGN KEY (`id_compte`) REFERENCES `compte` (`id_compte`);

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`id_annonce`) REFERENCES `annonce` (`id_annonce`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
