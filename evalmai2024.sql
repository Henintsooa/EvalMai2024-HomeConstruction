-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 15 mai 2024 à 07:35
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
-- Base de données : `evalmai2024`
--

-- --------------------------------------------------------

--
-- Structure de la table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `idClient` int(11) NOT NULL,
  `numero` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`idClient`, `numero`) VALUES
(1, '0340590098');

-- --------------------------------------------------------

--
-- Structure de la table `demandedevis`
--

CREATE TABLE `demandedevis` (
  `idDemandeDevis` int(11) NOT NULL,
  `idTypeMaison` int(11) DEFAULT NULL,
  `idClient` int(11) DEFAULT NULL,
  `idFinition` int(11) DEFAULT NULL,
  `pourcentage` double(20,2) DEFAULT NULL,
  `DateCreation` datetime DEFAULT NULL,
  `DateDebut` datetime DEFAULT NULL,
  `DateFin` datetime DEFAULT NULL,
  `lieu` varchar(200) NOT NULL,
  `refDevis` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `demandedevis`
--

INSERT INTO `demandedevis` (`idDemandeDevis`, `idTypeMaison`, `idClient`, `idFinition`, `pourcentage`, `DateCreation`, `DateDebut`, `DateFin`, `lieu`, `refDevis`) VALUES
(1, 1, 1, 1, 6.45, '2023-12-22 00:00:00', '2024-01-10 00:00:00', '2024-04-09 00:00:00', 'Imerintsiatosika', 'D001');

-- --------------------------------------------------------

--
-- Structure de la table `devis`
--

CREATE TABLE `devis` (
  `idDevis` int(11) NOT NULL,
  `nomDevis` varchar(100) DEFAULT NULL,
  `idTypeMaison` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `devis`
--

INSERT INTO `devis` (`idDevis`, `nomDevis`, `idTypeMaison`) VALUES
(1, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `devisdetails`
--

CREATE TABLE `devisdetails` (
  `idDeviseDetails` int(11) NOT NULL,
  `idDevis` int(11) DEFAULT NULL,
  `idTravaux` int(11) DEFAULT NULL,
  `quantite` float DEFAULT NULL,
  `pu` float DEFAULT NULL,
  `prixTotal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `devisdetails`
--

INSERT INTO `devisdetails` (`idDeviseDetails`, `idDevis`, `idTravaux`, `quantite`, `pu`, `prixTotal`) VALUES
(1, 1, 1, 18.4, 573216, 10547200),
(2, 1, 2, 781, 8500, 6638500);

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `finition`
--

CREATE TABLE `finition` (
  `idFinition` int(11) NOT NULL,
  `nomFinition` varchar(100) DEFAULT NULL,
  `pourcentage` double(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `finition`
--

INSERT INTO `finition` (`idFinition`, `nomFinition`, `pourcentage`) VALUES
(1, 'Gold', 6.45);

-- --------------------------------------------------------

--
-- Structure de la table `historiquepaiement`
--

CREATE TABLE `historiquepaiement` (
  `idHistorique` int(11) NOT NULL,
  `datePaiement` datetime DEFAULT NULL,
  `payer` float DEFAULT NULL,
  `idDemandeDevis` int(11) DEFAULT NULL,
  `refDevis` varchar(100) DEFAULT NULL,
  `refPaiement` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `historiquepaiement`
--

INSERT INTO `historiquepaiement` (`idHistorique`, `datePaiement`, `payer`, `idDemandeDevis`, `refDevis`, `refPaiement`) VALUES
(1, '2023-12-23 00:00:00', 10000000, 1, 'D001', '3490123'),
(2, '2024-01-02 00:00:00', 4780050, 1, 'D001', 'A4683');

-- --------------------------------------------------------

--
-- Structure de la table `importdevis`
--

CREATE TABLE `importdevis` (
  `client` varchar(100) DEFAULT NULL,
  `refDevis` varchar(100) DEFAULT NULL,
  `typeMaison` varchar(100) DEFAULT NULL,
  `finition` varchar(100) DEFAULT NULL,
  `tauxFinition` double(20,2) DEFAULT NULL,
  `dateDevis` datetime DEFAULT NULL,
  `dateDebut` datetime DEFAULT NULL,
  `lieu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `importdevis`
--

INSERT INTO `importdevis` (`client`, `refDevis`, `typeMaison`, `finition`, `tauxFinition`, `dateDevis`, `dateDebut`, `lieu`) VALUES
('0340590098', 'D001', 'TOKYO', 'Gold', 6.45, '2023-12-22 00:00:00', '2024-01-10 00:00:00', 'Imerintsiatosika');

-- --------------------------------------------------------

--
-- Structure de la table `importmaisontravaux`
--

CREATE TABLE `importmaisontravaux` (
  `typeMaison` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `surface` double(20,2) DEFAULT NULL,
  `codeTravaux` varchar(100) DEFAULT NULL,
  `typeTravaux` varchar(100) DEFAULT NULL,
  `unite` varchar(100) DEFAULT NULL,
  `prixUnitaire` double(20,2) DEFAULT NULL,
  `quantite` double(20,2) DEFAULT NULL,
  `dureeTravaux` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `importmaisontravaux`
--

INSERT INTO `importmaisontravaux` (`typeMaison`, `description`, `surface`, `codeTravaux`, `typeTravaux`, `unite`, `prixUnitaire`, `quantite`, `dureeTravaux`) VALUES
('TOKYO', '2 chambres, 1 living, 1 salle de bain', 128.00, '102', 'beton armée dosée à 350kg/m3', 'm3', 573215.80, 18.40, 90),
('TOKYO', '2 chambres, 1 living, 1 salle de bain', 128.00, '103', 'Armature pour Béton', 'kg', 8500.00, 781.00, 90);

-- --------------------------------------------------------

--
-- Structure de la table `importpaiement`
--

CREATE TABLE `importpaiement` (
  `refDevis` varchar(100) DEFAULT NULL,
  `refPaiement` varchar(100) DEFAULT NULL,
  `datePaiement` datetime DEFAULT NULL,
  `montant` double(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `importpaiement`
--

INSERT INTO `importpaiement` (`refDevis`, `refPaiement`, `datePaiement`, `montant`) VALUES
('D001', '3490123', '2023-12-23 00:00:00', 10000000.00),
('D001', 'A4683', '2024-01-02 00:00:00', 4780050.00);

-- --------------------------------------------------------

--
-- Structure de la table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `maison`
--

CREATE TABLE `maison` (
  `idMaison` int(11) NOT NULL,
  `idTypeMaison` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `surface` double(20,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `maison`
--

INSERT INTO `maison` (`idMaison`, `idTypeMaison`, `description`, `surface`) VALUES
(1, 1, '2 chambres, 1 living, 1 salle de bain', 128.00);

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `prixmaison`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `prixmaison` (
`idDevis` int(11)
,`idMaison` int(11)
,`idTypeMaison` int(11)
,`nomMaison` varchar(100)
,`prixDevisTotal` double
,`description` varchar(200)
);

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5kTuognGFbtnDnYuLKLg9oV1QDRGXraUJVNmgzbr', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia2FEQUF6MEV3d3FDQ3l4S0VXVkpuVjUwSmQ1c01QV3lqUUdMY1dkWSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmRfYWRtaW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1715751339);

-- --------------------------------------------------------

--
-- Structure de la table `travaux`
--

CREATE TABLE `travaux` (
  `idTravaux` int(11) NOT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `numero` varchar(100) DEFAULT NULL,
  `pu` float DEFAULT NULL,
  `unite` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `travaux`
--

INSERT INTO `travaux` (`idTravaux`, `designation`, `numero`, `pu`, `unite`) VALUES
(1, 'beton armée dosée à 350kg/m3', '102', 573216, 'm3'),
(2, 'Armature pour Béton', '103', 8500, 'kg');

-- --------------------------------------------------------

--
-- Structure de la table `typemaison`
--

CREATE TABLE `typemaison` (
  `idTypeMaison` int(11) NOT NULL,
  `nomMaison` varchar(100) DEFAULT NULL,
  `duree` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `typemaison`
--

INSERT INTO `typemaison` (`idTypeMaison`, `nomMaison`, `duree`) VALUES
(1, 'TOKYO', 90);

-- --------------------------------------------------------

--
-- Structure de la table `typetravaux`
--

CREATE TABLE `typetravaux` (
  `idTypeTravaux` int(11) NOT NULL,
  `nomTypeTravaux` varchar(100) DEFAULT NULL,
  `numero` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('admin','user') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', NULL, '$2y$12$zPqWb3PdyYYBz9runZ6TZesz/aB34K1y5G9Qi1jaTUcP4LlkjhIXe', 'admin', NULL, NULL, '2024-05-15 02:32:18');

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewdemandedevisdetails`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `viewdemandedevisdetails` (
`idTypeMaison` int(11)
,`idFinition` int(11)
,`nomFinition` varchar(100)
,`pourcentage` double(20,2)
,`DateCreation` datetime
,`DateDebut` datetime
,`DateFin` datetime
,`idDemandeDevis` int(11)
,`idClient` int(11)
,`numero` varchar(100)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewhistoriquepaiement`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `viewhistoriquepaiement` (
`payer` double
,`idDemandeDevis` int(11)
,`refDevis` varchar(100)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewlistedevis_paiement`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `viewlistedevis_paiement` (
`idTypeMaison` int(11)
,`idFinition` int(11)
,`nomFinition` varchar(100)
,`pourcentage` double(20,2)
,`DateCreation` datetime
,`DateDebut` datetime
,`DateFin` datetime
,`idDemandeDevis` int(11)
,`idClient` int(11)
,`numero` varchar(100)
,`prixDevisTotal` double
,`idDevis` int(11)
,`prixTotal` double
,`prixPourcentage` double
,`payer` double
,`resteAPayer` double
,`etatPaiement` varchar(8)
,`pourcentagePaye` double
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `viewlistedevis_prix`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `viewlistedevis_prix` (
`idTypeMaison` int(11)
,`idFinition` int(11)
,`nomFinition` varchar(100)
,`pourcentage` double(20,2)
,`DateCreation` datetime
,`DateDebut` datetime
,`DateFin` datetime
,`idDemandeDevis` int(11)
,`idClient` int(11)
,`numero` varchar(100)
,`prixDevisTotal` double
,`idDevis` int(11)
,`prixTotal` double
,`prixPourcentage` double
);

-- --------------------------------------------------------

--
-- Structure de la vue `prixmaison`
--
DROP TABLE IF EXISTS `prixmaison`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `prixmaison`  AS SELECT `d`.`idDevis` AS `idDevis`, `m`.`idMaison` AS `idMaison`, `tm`.`idTypeMaison` AS `idTypeMaison`, `tm`.`nomMaison` AS `nomMaison`, sum(`dd`.`prixTotal`) AS `prixDevisTotal`, `m`.`description` AS `description` FROM (((`maison` `m` join `typemaison` `tm` on(`m`.`idTypeMaison` = `tm`.`idTypeMaison`)) join `devis` `d` on(`tm`.`idTypeMaison` = `d`.`idTypeMaison`)) join `devisdetails` `dd` on(`d`.`idDevis` = `dd`.`idDevis`)) GROUP BY `m`.`idMaison`, `d`.`idDevis`, `tm`.`idTypeMaison`, `tm`.`nomMaison`, `m`.`description` ;

-- --------------------------------------------------------

--
-- Structure de la vue `viewdemandedevisdetails`
--
DROP TABLE IF EXISTS `viewdemandedevisdetails`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewdemandedevisdetails`  AS SELECT `demande`.`idTypeMaison` AS `idTypeMaison`, `f`.`idFinition` AS `idFinition`, `f`.`nomFinition` AS `nomFinition`, `demande`.`pourcentage` AS `pourcentage`, `demande`.`DateCreation` AS `DateCreation`, `demande`.`DateDebut` AS `DateDebut`, `demande`.`DateFin` AS `DateFin`, `demande`.`idDemandeDevis` AS `idDemandeDevis`, `c`.`idClient` AS `idClient`, `c`.`numero` AS `numero` FROM ((`demandedevis` `demande` join `finition` `f` on(`f`.`idFinition` = `demande`.`idFinition`)) join `client` `c` on(`c`.`idClient` = `demande`.`idClient`)) ORDER BY `demande`.`idDemandeDevis` ASC ;

-- --------------------------------------------------------

--
-- Structure de la vue `viewhistoriquepaiement`
--
DROP TABLE IF EXISTS `viewhistoriquepaiement`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewhistoriquepaiement`  AS SELECT sum(`historiquepaiement`.`payer`) AS `payer`, `historiquepaiement`.`idDemandeDevis` AS `idDemandeDevis`, `historiquepaiement`.`refDevis` AS `refDevis` FROM `historiquepaiement` GROUP BY `historiquepaiement`.`idDemandeDevis`, `historiquepaiement`.`refDevis` ;

-- --------------------------------------------------------

--
-- Structure de la vue `viewlistedevis_paiement`
--
DROP TABLE IF EXISTS `viewlistedevis_paiement`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewlistedevis_paiement`  AS SELECT `v`.`idTypeMaison` AS `idTypeMaison`, `v`.`idFinition` AS `idFinition`, `v`.`nomFinition` AS `nomFinition`, `v`.`pourcentage` AS `pourcentage`, `v`.`DateCreation` AS `DateCreation`, `v`.`DateDebut` AS `DateDebut`, `v`.`DateFin` AS `DateFin`, `v`.`idDemandeDevis` AS `idDemandeDevis`, `v`.`idClient` AS `idClient`, `v`.`numero` AS `numero`, `v`.`prixDevisTotal` AS `prixDevisTotal`, `v`.`idDevis` AS `idDevis`, `v`.`prixTotal` AS `prixTotal`, `v`.`prixPourcentage` AS `prixPourcentage`, coalesce(`h`.`payer`,0) AS `payer`, `v`.`prixTotal`- coalesce(`h`.`payer`,0) AS `resteAPayer`, CASE WHEN coalesce(`h`.`payer`,0) = 0 THEN 'Non payé' WHEN coalesce(`h`.`payer`,0) < `v`.`prixTotal` THEN 'En cours' ELSE 'Payé' END AS `etatPaiement`, coalesce(`h`.`payer`,0) / `v`.`prixTotal` * 100 AS `pourcentagePaye` FROM (`viewlistedevis_prix` `v` left join `viewhistoriquepaiement` `h` on(`h`.`idDemandeDevis` = `v`.`idDemandeDevis`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `viewlistedevis_prix`
--
DROP TABLE IF EXISTS `viewlistedevis_prix`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viewlistedevis_prix`  AS SELECT `d`.`idTypeMaison` AS `idTypeMaison`, `d`.`idFinition` AS `idFinition`, `d`.`nomFinition` AS `nomFinition`, `d`.`pourcentage` AS `pourcentage`, `d`.`DateCreation` AS `DateCreation`, `d`.`DateDebut` AS `DateDebut`, `d`.`DateFin` AS `DateFin`, `d`.`idDemandeDevis` AS `idDemandeDevis`, `d`.`idClient` AS `idClient`, `d`.`numero` AS `numero`, `p`.`prixDevisTotal` AS `prixDevisTotal`, `p`.`idDevis` AS `idDevis`, CASE WHEN `d`.`pourcentage` = 1 OR `d`.`pourcentage` = 0 THEN `p`.`prixDevisTotal` WHEN `d`.`pourcentage` <> 1 THEN `p`.`prixDevisTotal`* `d`.`pourcentage` / 100 + `p`.`prixDevisTotal` END AS `prixTotal`, CASE WHEN `d`.`pourcentage` = 1 THEN 0 ELSE `p`.`prixDevisTotal`* `d`.`pourcentage` / 100 END AS `prixPourcentage` FROM (`viewdemandedevisdetails` `d` join `prixmaison` `p` on(`p`.`idTypeMaison` = `d`.`idTypeMaison`)) ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`),
  ADD UNIQUE KEY `numero` (`numero`);

--
-- Index pour la table `demandedevis`
--
ALTER TABLE `demandedevis`
  ADD PRIMARY KEY (`idDemandeDevis`),
  ADD KEY `idTypeMaison` (`idTypeMaison`),
  ADD KEY `idClient` (`idClient`),
  ADD KEY `idFinition` (`idFinition`);

--
-- Index pour la table `devis`
--
ALTER TABLE `devis`
  ADD PRIMARY KEY (`idDevis`),
  ADD KEY `idTypeMaison` (`idTypeMaison`);

--
-- Index pour la table `devisdetails`
--
ALTER TABLE `devisdetails`
  ADD PRIMARY KEY (`idDeviseDetails`),
  ADD KEY `idDevis` (`idDevis`),
  ADD KEY `idTravaux` (`idTravaux`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `finition`
--
ALTER TABLE `finition`
  ADD PRIMARY KEY (`idFinition`);

--
-- Index pour la table `historiquepaiement`
--
ALTER TABLE `historiquepaiement`
  ADD PRIMARY KEY (`idHistorique`),
  ADD KEY `idDemandeDevis` (`idDemandeDevis`);

--
-- Index pour la table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Index pour la table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `maison`
--
ALTER TABLE `maison`
  ADD PRIMARY KEY (`idMaison`),
  ADD KEY `idTypeMaison` (`idTypeMaison`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Index pour la table `travaux`
--
ALTER TABLE `travaux`
  ADD PRIMARY KEY (`idTravaux`);

--
-- Index pour la table `typemaison`
--
ALTER TABLE `typemaison`
  ADD PRIMARY KEY (`idTypeMaison`);

--
-- Index pour la table `typetravaux`
--
ALTER TABLE `typetravaux`
  ADD PRIMARY KEY (`idTypeTravaux`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `demandedevis`
--
ALTER TABLE `demandedevis`
  MODIFY `idDemandeDevis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `devis`
--
ALTER TABLE `devis`
  MODIFY `idDevis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `devisdetails`
--
ALTER TABLE `devisdetails`
  MODIFY `idDeviseDetails` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `finition`
--
ALTER TABLE `finition`
  MODIFY `idFinition` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `historiquepaiement`
--
ALTER TABLE `historiquepaiement`
  MODIFY `idHistorique` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `maison`
--
ALTER TABLE `maison`
  MODIFY `idMaison` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `travaux`
--
ALTER TABLE `travaux`
  MODIFY `idTravaux` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `typemaison`
--
ALTER TABLE `typemaison`
  MODIFY `idTypeMaison` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `typetravaux`
--
ALTER TABLE `typetravaux`
  MODIFY `idTypeTravaux` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `demandedevis`
--
ALTER TABLE `demandedevis`
  ADD CONSTRAINT `demandedevis_ibfk_1` FOREIGN KEY (`idTypeMaison`) REFERENCES `typemaison` (`idTypeMaison`),
  ADD CONSTRAINT `demandedevis_ibfk_2` FOREIGN KEY (`idClient`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `demandedevis_ibfk_3` FOREIGN KEY (`idFinition`) REFERENCES `finition` (`idFinition`);

--
-- Contraintes pour la table `devis`
--
ALTER TABLE `devis`
  ADD CONSTRAINT `devis_ibfk_1` FOREIGN KEY (`idTypeMaison`) REFERENCES `typemaison` (`idTypeMaison`);

--
-- Contraintes pour la table `devisdetails`
--
ALTER TABLE `devisdetails`
  ADD CONSTRAINT `devisdetails_ibfk_1` FOREIGN KEY (`idDevis`) REFERENCES `devis` (`idDevis`),
  ADD CONSTRAINT `devisdetails_ibfk_2` FOREIGN KEY (`idTravaux`) REFERENCES `travaux` (`idTravaux`);

--
-- Contraintes pour la table `historiquepaiement`
--
ALTER TABLE `historiquepaiement`
  ADD CONSTRAINT `historiquepaiement_ibfk_1` FOREIGN KEY (`idDemandeDevis`) REFERENCES `demandedevis` (`idDemandeDevis`);

--
-- Contraintes pour la table `maison`
--
ALTER TABLE `maison`
  ADD CONSTRAINT `maison_ibfk_1` FOREIGN KEY (`idTypeMaison`) REFERENCES `typemaison` (`idTypeMaison`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
