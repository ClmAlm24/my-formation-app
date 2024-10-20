

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_app`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_tokens`
--

DROP TABLE IF EXISTS `auth_tokens`;
CREATE TABLE IF NOT EXISTS `auth_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `expiration` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `auth_tokens`
--

INSERT INTO `auth_tokens` (`id`, `user_id`, `token`, `expiration`, `created_at`) VALUES
(1, 1, 'a6af159af08f88bf43d77cd5d181e388', '2024-09-19 17:59:43', '2024-09-19 16:59:43'),
(2, 1, '3eb89c9ad9f9ab884ab24ee33c330204', '2024-09-19 20:08:37', '2024-09-19 17:08:37'),
(3, 1, '76e54ce4b9b524034f8c131b8edc4eda', '2024-09-19 20:19:00', '2024-09-19 17:19:00'),
(4, 1, 'c566f98cbc71dcb2425df9d5eb9eac38', '2024-09-19 20:39:47', '2024-09-19 17:39:47'),
(5, 1, 'b58ab972f4dbb28e3038912e24624f3e', '2024-09-19 20:46:02', '2024-09-19 17:46:02'),
(6, 1, '4e35f952620f95e5b1b5e2d3ab12be26', '2024-09-19 20:47:58', '2024-09-19 17:47:58'),
(7, 1, '23381452e25b216498ac5814e6807d7e', '2024-09-20 15:00:08', '2024-09-20 12:00:08'),
(8, 1, '2ac384b8fd20036d1ae84df715742cb8', '2024-09-20 17:07:26', '2024-09-20 14:07:26'),
(9, 1, '9e0ec4c02d3d06b96a584be97cbcab2c', '2024-09-20 17:08:13', '2024-09-20 14:08:13'),
(10, 3, '8d03d1a60099b78d1f0131085165efef', '2024-09-23 17:49:28', '2024-09-23 14:49:28'),
(11, 4, '9ee8810a2a22e8414782d86d10f30f7b', '2024-09-25 19:35:21', '2024-09-25 16:35:21'),
(12, 4, '997d1bcf9cc1208091108668a1d7b8bb', '2024-09-25 20:34:05', '2024-09-25 17:34:05'),
(13, 1, '92626013c565bf8934896b12eee4b264', '2024-09-25 21:49:29', '2024-09-25 18:49:29'),
(14, 5, '6268176eee365c942d14ac6fcae18d5c', '2024-09-25 21:52:28', '2024-09-25 18:52:28'),
(15, 7, 'cde0c6fd0596b674ac8847731558517b', '2024-09-26 16:03:52', '2024-09-26 13:03:52'),
(16, 7, '8cd1a1d3d9794aca4a883ea5de3a6bfe', '2024-09-26 19:51:24', '2024-09-26 16:51:24'),
(17, 7, '47b0975c9634bc4d566e5f0b2e5d49cc', '2024-10-09 15:55:43', '2024-10-09 12:55:43'),
(18, 7, '00f5cff6f6ed9d7a2ffc19eae6b8f62c', '2024-10-09 16:06:46', '2024-10-09 13:06:46'),
(19, 7, 'b0db10c4f13df076fb544e05827df979', '2024-10-09 16:13:15', '2024-10-09 13:13:15'),
(20, 10, '646bbf6df8576dcff68722556ed2bcea', '2024-10-09 16:24:56', '2024-10-09 13:24:56');

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

DROP TABLE IF EXISTS `challenges`;
CREATE TABLE IF NOT EXISTS `challenges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `vuln_id` int NOT NULL,
  `flag` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_solved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `vuln_id` (`vuln_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `challenges`
--

INSERT INTO `challenges` (`id`, `description`, `vuln_id`, `flag`, `link`, `created_at`, `updated_at`, `is_solved`) VALUES
(1, 'Description du challengeDescription du challengeDescription du challengeDescription du challengeDescription du challengeDescription du challengeDescription du challengeDescription du challengeDescription du challengeDescription du challengeDescription du challengeDescription du challengeDescription du challengeDescription du challenge', 1, 'FLAG{FAKE_FLAG}', 'http://zero2hero.emes.bj:7775/', '2024-09-19 18:05:49', '2024-09-25 19:11:29', 1),
(2, 'Exploit SQL Injection pour accéder à la base de données', 1, 'FLB{SQL_INJECTION}', '', '2024-09-20 14:53:22', '2024-10-09 13:34:02', 0),
(6, 'Dans ce challenge, un jeune membre de la famille explore une plateforme de gestion de budget, désireux de tester ses défenses. À l\'aide d\'une méthode discrète, il injecte un code dans un champ de saisie, visant à provoquer une réaction de l\'application. Votre mission consiste à percer les mystères de cette vulnérabilité pour dénicher un flag, tout en scrutant les cookies laissés derrière.', 2, 'FLB{X5S_R3FLECH1_V1CT0IRE}', 'http://localhost:8003', '2024-09-25 18:50:40', '2024-09-25 18:51:19', 1),
(4, 'Envoyer un mail indésirable en utilisant CSRF.', 3, 'FLB{Sup3r_S3cr3t_Flag_f0r_Sup3ri0r_Us3rs}', 'http://localhost:8002/', '2024-09-23 15:03:31', '2024-09-23 15:04:10', 1),
(5, 'Changer les informations de l\'administrateur en utilisant CSRF.', 3, 'FLB{Admin_Access_Gr4nt3d_4_Us3rs}\r\n', 'http://localhost:8001', '2024-09-23 15:03:31', '2024-09-23 15:03:31', 0),
(7, 'Dans ce challenge, vous devez exploiter une vulnérabilité d\'Insecure Direct Object Reference (IDOR) dans une application de gestion de factures. Modifiez l\'ID dans l\'URL pour accéder à des factures cachées. Pour prouver votre succès, trouvez le flag en identifiant le bon ID, en vous basant sur les premières valeurs ascii.', 4, 'FLB{f4ctur3_vUlN3r4bl3_4cc3ss_57a2f9b1}', 'http://localhost:8004', '2024-09-26 13:05:02', '2024-09-26 13:05:02', 0),
(8, 'Dans ce challenge, vous devez exploiter une vulnérabilité de Contrôle d\'Accès Défaillant dans une application de gestion des utilisateurs. Essayez d\'accéder au tableau de bord ou à la page d\'administration sans être authentifié pour prouver votre succès.', 5, 'FLB{S3cur3P@ssw0rd!}', 'http://localhost:8005', '2024-09-26 16:59:35', '2024-09-26 16:59:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `cours`
--

DROP TABLE IF EXISTS `cours`;
CREATE TABLE IF NOT EXISTS `cours` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vuln_id` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `contenu` text NOT NULL,
  `is_finished` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `vuln_id` (`vuln_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cours`
--

INSERT INTO `cours` (`id`, `vuln_id`, `titre`, `contenu`, `is_finished`, `created_at`, `updated_at`) VALUES
(1, 1, 'Introduction à l\'Injection SQL', 'Contenu théorique sur l\'injection SQL.', 1, '2024-09-20 14:28:00', '2024-09-20 15:57:39'),
(2, 1, 'Introduction à xss', 'Contenu théorique sur xss.', 1, '2024-09-20 15:47:16', '2024-09-20 15:57:39'),
(3, 3, 'Introduction à l\'Injection SQL', 'Contenu théorique sur l\'injection SQL.', 0, '2024-09-20 15:50:22', '2024-09-20 15:50:22');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `expiration` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`, `expiration`) VALUES
('colombea@d.com', '6e56995d112d2ab68ecdcc01e204c044', '2024-09-19 19:19:35', '2024-09-19 20:19:35'),
('colombealimi@gmail.com', '32950cdb9c82dc3abf365d81d210add9', '2024-09-19 19:27:52', '2024-09-19 20:27:52'),
('colombealimi@gmail.com', '717cd456ec099534dcaed7e03eace999', '2024-09-19 19:35:08', '2024-09-19 20:35:08'),
('colombealimi@gmail.com', '4b7f6ced3a97739d13d4c6e71fb484c8', '2024-09-19 19:36:11', '2024-09-19 20:36:11'),
('colombealimi@gmail.com', '36af5373815e2dc9352210f588098e95', '2024-09-19 19:43:26', '2024-09-19 22:43:26'),
('colombea@d.com', '7b6176ab2817775435b5f5299a4c7e2c', '2024-09-19 19:45:30', '2024-09-19 22:45:30'),
('colombea@d.com', 'c8dcdfe4fb1415f85eee107383250488', '2024-09-19 19:55:24', '2024-09-19 22:55:24'),
('colombea@d.com', '683d65578c01cb87e2f922541755b8c5', '2024-09-25 17:25:33', '2024-09-25 20:25:33'),
('colombea@d.com', '3a3630b67e5a397ee0eb487f159377ef', '2024-09-25 17:42:32', '2024-09-25 20:42:32');

-- --------------------------------------------------------

--
-- Table structure for table `progression`
--

DROP TABLE IF EXISTS `progression`;
CREATE TABLE IF NOT EXISTS `progression` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `vuln_id` int NOT NULL,
  `cours_termine` int DEFAULT '0',
  `challenges_reussis` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `vuln_id` (`vuln_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `progression`
--

INSERT INTO `progression` (`id`, `user_id`, `vuln_id`, `cours_termine`, `challenges_reussis`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 0, '2024-09-20 14:43:52', '2024-09-20 15:57:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(191) NOT NULL,
  `pseudo` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pseudo`, `password`, `created_at`, `updated_at`) VALUES
(1, 'colombea@d.ccom', 'coco1', '$2y$10$NZ54iz3O0IHeb5vuyGcoGuJf3t01oiX6.DXj3Zfw.gx84lIHGykYW', '2024-09-19 16:52:42', '2024-09-20 14:14:17'),
(10, 'colombealimi@gmail.com', 'ketie', '$2y$10$ssr25DUt2yQLa4TiKC71yeaFwXD0zMHcgfZQVknPaByQq4HPfLuPy', '2024-10-09 13:24:47', '2024-10-09 13:53:09'),
(4, 'colombea@d.com', 'coco4', '$2y$10$bFuTyfwkm8j1tKINYbNAMeqklpNSR6gjMj0scfnPpRI5P4gefwmRa', '2024-09-25 16:35:14', '2024-09-25 18:49:22'),
(5, 'colombe3@gl.com', 'erd', '$2y$10$ArxjRo8EzeXMJh6uIkn73.kqi.oSpwXPooZMQSelRuhVtQN03YWVK', '2024-09-25 18:52:21', '2024-09-25 18:52:21'),
(7, 'colombealimi@d.com', 'ket', '$2y$10$.Q1N3INdOCXtPX9fNCxIqut4jwvuOn2eiwpXLRaKzegB9M6VqzN0i', '2024-09-26 13:03:43', '2024-09-26 13:03:43'),
(8, 'colombealimi@gd.com', 'rfty', '$2y$10$cJDl9Onwk0spjZS8i6gDze.kEJsUglndJoijvTmZQSc5ZEOHj997u', '2024-10-09 13:04:55', '2024-10-09 13:04:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_challenges`
--

DROP TABLE IF EXISTS `user_challenges`;
CREATE TABLE IF NOT EXISTS `user_challenges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `challenge_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `challenge_id` (`challenge_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_challenges`
--

INSERT INTO `user_challenges` (`id`, `user_id`, `challenge_id`, `created_at`) VALUES
(2, 1, 2, '2024-09-25 19:36:46'),
(3, 1, 6, '2024-09-25 19:40:28'),
(4, 7, 7, '2024-09-26 13:06:23'),
(5, 10, 6, '2024-10-09 13:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `vulnerabilites`
--

DROP TABLE IF EXISTS `vulnerabilites`;
CREATE TABLE IF NOT EXISTS `vulnerabilites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `slug` varchar(191) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `vulnerabilites`
--

INSERT INTO `vulnerabilites` (`id`, `slug`, `nom`, `description`, `created_at`, `updated_at`) VALUES
(1, 'sqli', 'SQL Injection', 'Une vulnérabilité critique permettant d\'exécuter des commandes SQL malveillantes dans l\'application.', '2024-09-19 17:51:20', '2024-09-19 18:21:11'),
(2, 'xss', 'Cross-Site Scripting (XSS)', 'Une vulnérabilité qui permet à un attaquant d\'injecter des scripts malveillants dans les pages vues par d\'autres utilisateurs.', '2024-09-19 17:51:20', '2024-09-19 17:51:20'),
(3, 'csrf', 'Cross-Site Request Forgery (CSRF)', 'Une vulnérabilité permettant à un attaquant de tromper un utilisateur authentifié pour exécuter des actions non autorisées.', '2024-09-19 17:51:20', '2024-09-19 17:51:20'),
(4, 'idor', 'Insecure Direct Object Reference', 'Vulnérabilité permettant d\'accéder à des objets non autorisés en manipulant des identifiants dans l\'URL.', '2024-09-26 13:04:21', '2024-09-26 13:04:21'),
(5, 'broken-access-control', 'Broken Access Control', 'Vulnérabilité résultant d\'une gestion inadéquate des autorisations, permettant aux utilisateurs non autorisés d\'accéder à des ressources.', '2024-09-26 16:56:37', '2024-09-26 16:56:37'),
(6, 'css-injection', 'CSS Injection', 'Vulnérabilité permettant d\'injecter des styles malveillants via des entrées utilisateur, modifiant l\'apparence d\'une page ou compromettant la sécurité.', '2024-10-09 13:13:07', '2024-10-09 13:13:07');
