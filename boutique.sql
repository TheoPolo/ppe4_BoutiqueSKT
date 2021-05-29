-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : sam. 29 mai 2021 à 00:43
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `boutique`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`) VALUES
(25, '8'),
(26, '8.125'),
(27, '8.25');

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

CREATE TABLE `contenir` (
  `id` int(11) NOT NULL,
  `id_produit_id` int(11) NOT NULL,
  `id_panier_id` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `correspondre`
--

CREATE TABLE `correspondre` (
  `id` int(11) NOT NULL,
  `id_tag_id` int(11) NOT NULL,
  `id_produit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201103154606', '2020-11-04 10:12:25', 33),
('DoctrineMigrations\\Version20201104142953', '2020-11-04 14:30:43', 43),
('DoctrineMigrations\\Version20201104145533', '2020-11-04 14:56:17', 33),
('DoctrineMigrations\\Version20201104151808', '2020-11-04 15:18:28', 30),
('DoctrineMigrations\\Version20201104153501', '2020-11-04 15:35:20', 48),
('DoctrineMigrations\\Version20201105081030', '2020-11-05 08:10:53', 45),
('DoctrineMigrations\\Version20201105081532', '2020-11-05 08:15:40', 20),
('DoctrineMigrations\\Version20201105082019', '2020-11-05 08:20:25', 42),
('DoctrineMigrations\\Version20210311101407', '2021-03-11 10:14:51', 245);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `date_creation` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `montant_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `date_creation`, `montant_total`) VALUES
(13, '06/05/21', '0.00');

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `id_categorie_id` int(11) NOT NULL,
  `libelle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tarif` double NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `id_categorie_id`, `libelle`, `tarif`, `image`, `description`) VALUES
(1, 25, 'Jart Boobs', 50, 'images/skate1.jpg', 'Planche fait en bois d\'érable canadien'),
(2, 25, 'Primitive Halloween', 60, 'images/skate2.jpg', 'Planche fait en bois d\'érable canadien'),
(3, 26, 'Almost Ping-Pong', 55, 'images/skate3.jpg', 'Planche fait en bois d\'érable canadien'),
(4, 26, 'Baker Vraiment belle', 55, 'images/skate4.jpg', 'Planche fait en bois d\'érable canadien'),
(5, 27, 'Plan B Lune', 60, 'images/skate5.jpg', 'Planche fait en bois d\'érable canadien'),
(6, 26, 'Jart gradient', 50, 'images/skate6.jpg', 'Planche fait en bois d\'érable canadien'),
(7, 26, 'Almost fleurs', 65, 'images/skate7.jpg', 'Planche fait en bois d\'érable canadien'),
(8, 27, 'Baker biker', 85, 'images/skate8.jpg', 'Planche fait en bois d\'érable canadien'),
(9, 27, 'Almost prière ', 65, 'images/skate9.jpg', 'Planche fait en bois d\'érable canadien'),
(10, 25, 'Jart 404', 45, 'images/skate10.jpg', 'Planche fait en bois d\'érable canadien'),
(11, 25, 'Je sais plus la marque', 70, 'images/skate11.jpg', 'Planche fait en bois d\'érable canadien'),
(12, 26, 'Jart', 75, 'images/skate12.jpg', 'Planche fait en bois d\'érable canadien'),
(13, 26, 'Test', 90, 'images/skate8.jpg', 'rgdrgdrg');

-- --------------------------------------------------------

--
-- Structure de la table `tag`
--

CREATE TABLE `tag` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tag`
--

INSERT INTO `tag` (`id`, `nom`) VALUES
(31, '8'),
(32, '8.25'),
(33, 'Jart'),
(34, 'Almost'),
(35, 'Baker'),
(36, 'Plan B'),
(37, 'Primitive');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `prenom`, `nom`, `email`, `roles`, `password`) VALUES
(1, 'theo', 'polo', 'theo@gmail.com', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$qkYxKoeSa8ImX9R+Z4ZxNQ$PUwBdTsUqsfBbHunfZc1PG67wgGiZm2bFGgfrKMPEGY'),
(2, 'oui', 'oui', 'tasoeur@oui.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$qkYxKoeSa8ImX9R+Z4ZxNQ$PUwBdTsUqsfBbHunfZc1PG67wgGiZm2bFGgfrKMPEGY'),
(3, 'enzo', 'cuny', 'zozo_404@gmail.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$qkYxKoeSa8ImX9R+Z4ZxNQ$PUwBdTsUqsfBbHunfZc1PG67wgGiZm2bFGgfrKMPEGY'),
(4, 'kiki', 'ledep', 'test@test.com', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$O7RY6T0ivDUHLFWs2GBIxQ$H1wUtfZm8oPLrHMXVv/v34XkVX9VtjEgjuwoyHv3s7Q'),
(5, 'test', 'test', 'test@test.fr', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$q1B/b62nfBal8sx7W6Yi2Q$MQQYWvCE4zaoDTDt3m49Cv6VQdkDKYFXmgq+f8X4kWs');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3C914DFDAABEFE2C` (`id_produit_id`),
  ADD KEY `IDX_3C914DFD77482E5B` (`id_panier_id`);

--
-- Index pour la table `correspondre`
--
ALTER TABLE `correspondre`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2AE140C49CE5D6FC` (`id_tag_id`),
  ADD KEY `IDX_2AE140C4AABEFE2C` (`id_produit_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5EC279F34925F` (`id_categorie_id`);

--
-- Index pour la table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `contenir`
--
ALTER TABLE `contenir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `correspondre`
--
ALTER TABLE `correspondre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `FK_3C914DFD77482E5B` FOREIGN KEY (`id_panier_id`) REFERENCES `panier` (`id`),
  ADD CONSTRAINT `FK_3C914DFDAABEFE2C` FOREIGN KEY (`id_produit_id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `correspondre`
--
ALTER TABLE `correspondre`
  ADD CONSTRAINT `FK_2AE140C49CE5D6FC` FOREIGN KEY (`id_tag_id`) REFERENCES `tag` (`id`),
  ADD CONSTRAINT `FK_2AE140C4AABEFE2C` FOREIGN KEY (`id_produit_id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC279F34925F` FOREIGN KEY (`id_categorie_id`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
