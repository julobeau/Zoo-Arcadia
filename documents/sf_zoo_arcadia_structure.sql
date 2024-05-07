SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `sf_zoo_arcadia` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `sf_zoo_arcadia`;

CREATE TABLE `animal` (
  `id` int NOT NULL,
  `race_id` int NOT NULL,
  `habitat_id` int NOT NULL,
  `firstname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `food_given` (
  `id` int NOT NULL,
  `animal_id` int NOT NULL,
  `soigneur_id` int NOT NULL,
  `food` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `food_quantity` decimal(10,0) NOT NULL,
  `date` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `habitat` (
  `id` int NOT NULL,
  `nom` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `resume` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `images_animaux` (
  `id` int NOT NULL,
  `animal_id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `images_habitat` (
  `id` int NOT NULL,
  `habitat_id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `race` (
  `id` int NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `species` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `rapport_veterinaire_animal` (
  `id` int NOT NULL,
  `animal_id` int NOT NULL,
  `date` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `rapport` longtext COLLATE utf8mb4_unicode_ci,
  `etat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nourriture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantite_nourriture` decimal(10,2) NOT NULL,
  `veterinaire_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `rapport_veterinaire_habitat` (
  `id` int NOT NULL,
  `habitat_id` int NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `etat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rapport` longtext COLLATE utf8mb4_unicode_ci,
  `veterinaire_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `review` (
  `id` int NOT NULL,
  `pseudo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `note` smallint NOT NULL,
  `is_validated` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `service` (
  `id` int NOT NULL,
  `nom` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `service_image` (
  `id` int NOT NULL,
  `service_id` int NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `cover` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `user` (
  `id` int NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


ALTER TABLE `animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6AAB231F6E59D40D` (`race_id`),
  ADD KEY `IDX_6AAB231FAFFE2D26` (`habitat_id`);

ALTER TABLE `food_given`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B883E67C8E962C16` (`animal_id`),
  ADD KEY `IDX_B883E67CECF1F665` (`soigneur_id`);

ALTER TABLE `habitat`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `images_animaux`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5C3072F8E962C16` (`animal_id`);

ALTER TABLE `images_habitat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_A44AAC8AAFFE2D26` (`habitat_id`);

ALTER TABLE `race`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `rapport_veterinaire_animal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_174040268E962C16` (`animal_id`),
  ADD KEY `IDX_174040265C80924` (`veterinaire_id`);

ALTER TABLE `rapport_veterinaire_habitat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_644FD183AFFE2D26` (`habitat_id`),
  ADD KEY `IDX_644FD1835C80924` (`veterinaire_id`);

ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `service`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `service_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6C4FE9B8ED5CA9E6` (`service_id`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`);


ALTER TABLE `animal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `food_given`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `habitat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `images_animaux`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `images_habitat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `race`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `rapport_veterinaire_animal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `rapport_veterinaire_habitat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `review`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `service`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `service_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `animal`
  ADD CONSTRAINT `FK_6AAB231F6E59D40D` FOREIGN KEY (`race_id`) REFERENCES `race` (`id`),
  ADD CONSTRAINT `FK_6AAB231FAFFE2D26` FOREIGN KEY (`habitat_id`) REFERENCES `habitat` (`id`);

ALTER TABLE `food_given`
  ADD CONSTRAINT `FK_B883E67C8E962C16` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`),
  ADD CONSTRAINT `FK_B883E67CECF1F665` FOREIGN KEY (`soigneur_id`) REFERENCES `user` (`id`);

ALTER TABLE `images_animaux`
  ADD CONSTRAINT `FK_5C3072F8E962C16` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`);

ALTER TABLE `images_habitat`
  ADD CONSTRAINT `FK_A44AAC8AAFFE2D26` FOREIGN KEY (`habitat_id`) REFERENCES `habitat` (`id`);

ALTER TABLE `rapport_veterinaire_animal`
  ADD CONSTRAINT `FK_174040265C80924` FOREIGN KEY (`veterinaire_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_174040268E962C16` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`);

ALTER TABLE `rapport_veterinaire_habitat`
  ADD CONSTRAINT `FK_644FD1835C80924` FOREIGN KEY (`veterinaire_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_644FD183AFFE2D26` FOREIGN KEY (`habitat_id`) REFERENCES `habitat` (`id`);

ALTER TABLE `service_image`
  ADD CONSTRAINT `FK_6C4FE9B8ED5CA9E6` FOREIGN KEY (`service_id`) REFERENCES `service` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
