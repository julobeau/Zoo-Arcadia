SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE DATABASE IF NOT EXISTS `sf_zoo_arcadia` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `sf_zoo_arcadia`;

INSERT INTO `animal` (`id`, `race_id`, `habitat_id`, `firstname`, `description`) VALUES
(1, 1, 1, 'Alex', 'Un gentil lion'),
(2, 2, 1, 'Melman', 'Une grande girafe'),
(3, 3, 1, 'Marty', 'Marty est un jeune zèbre énergique et joueur qui vit au zoo Arcadia. Avec ses rayures noires et blanches distinctives, il fait le bonheur des visiteurs du zoo grâce à son comportement vif et amical. Toujours en mouvement, il aime courir et jouer avec ses compagnons de zoo.'),
(4, 4, 2, 'Kevin', 'Kevin est un macaque très actif et curieux qui vit au zoo d\'Arcadia. Il est connu pour son agilité et son intelligence. Les visiteurs adorent le regarder grimper et jouer dans son habitat spacieux.'),
(7, 5, 3, 'Gustave', 'Gustave est un imposant crocodile résidant au zoo Arcadia. Mesurant plus de 6 mètres de long et pesant environ une tonne, il est craint et respecté par les visiteurs. Son allure majestueuse et sa taille impressionnante en font l\'une des principales attractions du parc.'),
(11, 6, 3, 'Gloria', 'Gloria est un hippopotame résident au zoo Arcadia. C\'est un mammifère imposant, avec un corps massif et une peau épaisse de couleur grise. Elle est connue pour sa taille impressionnante et sa personnalité calme et tranquille. Les visiteurs du zoo apprécient souvent la voir barboter dans l\'eau de son enclos ou se prélasser au soleil.');

INSERT INTO `food_given` (`id`, `animal_id`, `soigneur_id`, `food`, `food_quantity`, `date`) VALUES
(1, 1, 3, 'viande', '7000', '2024-05-03 08:11:10'),
(2, 2, 3, 'foin', '40000', '2024-05-03 09:08:54'),
(3, 1, 3, 'viande', '7000', '2024-05-04 11:49:00'),
(4, 3, 3, 'foin', '10000', '2024-05-04 13:45:00');

INSERT INTO `habitat` (`id`, `nom`, `resume`, `description`) VALUES
(1, 'Savane', 'Venez vous aventurer au cœur de la savane au Zoo Arcadia et découvrez nos habitats incroyables!', '<p>L\'habitat savane du zoo Arcadia est un vaste espace naturel « à ciel ouvert » qui reproduit fidèlement les vastes plaines herbeuses de la savane africaine. Ce lieu offre une expérience unique aux visiteurs en les plongeant au cœur de la faune et la flore caractéristiques de ce biome.</p>\r\n\r\n<p>Dans cet habitat, les visiteurs peuvent admirer une grande variété d\'animaux emblématiques de la savane, tels que les lions, les girafes, les zèbres, les éléphants, les gazelles, les autruches et bien d\'autres. Les espaces de vie ont été conçus de manière à offrir aux animaux un environnement stimulant, semblable à celui qu\'ils pourraient rencontrer dans la nature.</p>'),
(2, 'Jungle', 'Plongez au cœur de la luxuriante jungle d\'Arcadia et découvrez une expérience unique au plus près de la nature sauvage.', '<p>Bienvenue dans l\'habitat jungle du zoo Arcadia ! Venez découvrir un environnement luxuriant et exotique où nos animaux vivent dans des conditions proches de leur habitat naturel.</p>\r\n\r\n<p>Dans cet espace verdoyant, vous pourrez observer une grande variété d\'espèces végétales et animales, des singes aux oiseaux exotiques en passant par les serpents et les lézards.</p>\r\n\r\n<p>Les visiteurs auront l\'impression de se retrouver au cœur de la jungle, grâce au feuillage dense, aux cascades et aux différents niveaux de végétation. Vous pourrez également admirer nos animaux dans des enclos spacieux et enrichis, offrant à chacun d\'eux des conditions de vie optimales.</p>\r\n\r\n<p>N\'hésitez pas à vous promener tranquillement dans cet espace enchanteur et à vous émerveiller devant la diversité et la beauté de la faune et de la flore de la jungle. Une expérience immersive et inoubliable vous attend à l\'habitat jungle du zoo Arcadia !</p>'),
(3, 'Marais', 'Plongez au cœur de la nature sauvage avec l\'habitat marais du zoo Arcadia, une expérience immersive et fascinante à ne pas manquer !', '<p>Bienvenue à l\'habitat marais du zoo Arcadia, un endroit où vous pouvez explorer et découvrir la diversité des espèces qui habitent les zones humides. Dans cet habitat, vous pourrez observer de près des animaux fascinants tels que les alligators, les tortues, les grenouilles, les oiseaux aquatiques et bien d\'autres encore.</p>\r\n\r\n<p>L\'habitat marais est conçu pour recréer l\'environnement naturel de ces animaux, en leur offrant des espaces spacieux et variés pour se déplacer et interagir. Vous pourrez vous promener le long des sentiers bordés de végétation luxuriante et admirer la beauté et la diversité de la faune et de la flore des marais.</p>\r\n\r\n<p>Les soigneurs du zoo sont présents pour répondre à vos questions et partager des informations fascinantes sur les espèces présentes dans cet habitat. Ils veillent également au bien-être des animaux et travaillent activement à leur conservation et à leur préservation.</p>\r\n\r\n<p>Nous vous invitons à venir découvrir l\'habitat marais du zoo Arcadia et à plonger dans l\'univers mystérieux et fascinant des marais et de leurs habitants. Vous repartirez avec des souvenirs inoubliables et une meilleure compréhension de l\'importance de préserver ces écosystèmes fragiles.</p>');

INSERT INTO `images_animaux` (`id`, `animal_id`, `image`, `cover`) VALUES
(1, 1, 'Alex.webp', 1),
(2, 2, 'Melman.webp', 1),
(3, 3, '3-20abbf833ff2.webp', 1),
(4, 4, '4-bdea1a6ea4af.webp', 1),
(6, 7, '7-953052a5872b.webp', 1),
(9, 11, '11-293332e89c42.webp', 1),
(11, 1, '1-e7fbea915486.webp', 0);

INSERT INTO `images_habitat` (`id`, `habitat_id`, `image`, `cover`) VALUES
(1, 1, 'savane-david-clode-jJWBM15E1AA-unsplash.webp', 1),
(2, 2, 'jungle-justin-clark-H7JiEU8Slnw-unsplash.webp', 1),
(3, 3, 'marais-tim-foster-eYeESGYSZoY-unsplash.webp', 1),
(4, 1, 'savane-pexels-hendrik-cornelissen-2862070.webp', 0),
(5, 1, 'savane-pexels-follow-alice-667205.webp', 0),
(6, 2, 'jungle-pexels-jacob-colvin-1757363.webp', 0),
(7, 2, 'jungle-pexels-mingche-lee-3852009.webp', 0),
(8, 2, 'jungle-pexels-nandkumar-patel-2950929.webp', 0);

INSERT INTO `race` (`id`, `label`, `species`, `description`) VALUES
(1, 'Lion', 'Panthera leo', '<p>Le Lion (Panthera leo) est une espèce de mammifères carnivores de la famille des Félidés. La femelle du lion est la lionne, son petit est le lionceau. Le mâle adulte, aisément reconnaissable à son importante crinière, accuse une masse moyenne qui peut être variable selon les zones géographiques où il se trouve, allant de 145 à 180 kg pour les lions d\'Asie à plus de 225 kg pour les lions d\'Afrique. Certains spécimens très rares peuvent dépasser exceptionnellement 300 kg. Un mâle adulte se nourrit de 7 kg de viande chaque jour contre 5 kg chez la femelle. Le lion est un animal grégaire, c\'est-à-dire qu\'il vit en larges groupes familiaux, contrairement aux autres félins. Son espérance de vie, à l\'état sauvage, est comprise entre 7 et 12 ans pour le mâle et 14 à 20 ans pour la femelle, mais il dépasse fréquemment les 30 ans en captivité.</p><p>Le lion mâle ne chasse qu\'occasionnellement, il est chargé de combattre les intrusions sur le territoire et les menaces contre la troupe. Le lion rugit. Il n\'existe plus à l\'état sauvage que 16 500 à 30 000 individus dans la savane africaine, répartis en deux sous-espèces, et environ 300 dans le parc national de Gir Forest (nord-ouest de l\'Inde). Il est surnommé « le roi des animaux » car sa crinière lui donne un aspect semblable au Soleil, qui apparaît comme « le roi des astres ». Entre 1993 et 2017, sa population a baissé de 43 %.</p>'),
(2, 'Girafe', 'Giraffa camelopardalis', '<p>La Girafe (Giraffa camelopardalis) est une espèce de mammifères ongulés artiodactyles, du groupe des ruminants, vivant dans les savanes africaines et répandue du Tchad jusqu\'en Afrique du Sud. Son nom commun vient de l\'arabe زرافة, zarāfah, mais l\'animal fut anciennement appelé camélopard, du latin camelopardus, contraction de camelus (chameau) en raison du long cou et de pardus (léopard) en raison des taches recouvrant son corps. Après des millions d\'années d\'évolution, la girafe a acquis une anatomie unique avec un cou particulièrement allongé qui lui permet notamment de brouter haut dans les arbres.</p>\r\n<p>Neuf populations, se différenciant par leurs robes et formes, ont été décrites par les naturalistes depuis le XIXe siècle parfois comme espèces à part entière, mais généralement considérées comme simples sous-espèces jusqu\'au XXIe siècle. Cependant, la taxonomie des girafes est actuellement débattue parmi les scientifiques.</p>\r\n<p>L\'espèce est considérée comme vulnérable par l\'UICN2 : il y avait 155 000 individus en 1985 et il n\'y en a plus que 97 000 en 20153, soit une diminution approchant 40 % en 30 ans.</p>'),
(3, 'Zèbre', 'Equus quagga', '<p>Le zèbre des plaines est de taille moyenne, plus petit en moyenne que le zèbre de Grévy, mais plus grand que le zèbre de montagne, épais avec des pattes relativement courtes. Les adultes des deux sexes mesurent entre 1,10 et 1,45 m de hauteur au garrot, de 2,17 à 2,46 m de longueur, sans compter une queue de 47 à 56 cm, et pèsent entre 175 et 385 kg. Les mâles peuvent peser 10 % de plus que les femelles.</p>\r\n<p>Ce zèbre possède généralement des bandes noires relativement larges, qui sont verticales sur le corps, mais deviennent horizontales sur l\'arrière-train. La présence de bandes horizontales sur les pattes et le croupion est toutefois variable, l\'extension des bandes de pattes diminuant du nord au sud de l\'aire de répartition de l\'espèce. Dans certaines populations, il peut également y avoir de légères rayures « d\'ombre » brunes entre les bandes principales.</p>'),
(4, 'Macaque', 'Macaca', '<p>Macaca, le Macaque, est un genre de primates de la famille des Cercopithecidae.</p>\r\n<p>Ces singes catarhiniens sont largement répandus en Asie, de l\'Inde jusqu\'au Japon et à la ligne Wallace, ainsi qu\'en Afrique du Nord et à Gibraltar. Ce sont en effet les seuls primates, à l\'exception de l\'Homme, qui soient présents sur deux (voire trois) continents et surtout qui se soient acclimatés largement au-dessus de la zone intertropicale.</p>'),
(5, 'Crocodile', 'Crocodylinae', 'Les Crocodiles, Crocodylinae, sont une sous-famille de crocodiliens de la famille des Crocodilidés.\nLes crocodiles vivent dans les régions chaudes. Toutes les espèces fréquentent les eaux douces (même le crocodile marin, en particulier durant les saisons tropicales humides). Ils vivent immergés dans des cours d\'eau stagnante où ils passent leurs journées à guetter leurs proies. Ils peuvent rester 50 minutes sous l\'eau, soit assez de temps pour préparer des embuscades. Ils sont très agiles dans l\'eau, mais plutôt maladroits sur la terre ferme, bien qu\'ils puissent courir assez rapidement. Les crocodiles sont parfaitement adaptés à la vie aquatique. Leurs poumons peuvent se déplacer vers l\'avant ou l\'arrière de leur corps. Cette capacité leur permet de garder leur tête au-dessous de l\'eau et leur corps immergé, complètement cachés dans les marécages boueux. Leurs yeux, leurs oreilles et leurs narines sont placés très haut sur le crâne, ce qui leur permet de voir, de respirer et d\'entendre ce qui se passe aux alentours alors qu\'ils passent inaperçus auprès de leurs proies. Certains crocodiles sont parmi les plus grands reptiles.'),
(6, 'Hippopotame', 'Hippopotamus amphibius', 'L\'Hippopotame amphibie ou Hippopotame commun (Hippopotamus amphibius) est une espèce de mammifère semi-aquatique d\'Afrique subsaharienne et l’une des deux dernières espèces existantes au sein de la famille des Hippopotamidae, l’autre étant l’Hippopotame nain. L\'Hippopotame commun est reconnaissable à son buste en forme de baril, sa gueule qu’il peut très largement ouvrir pour révéler de grandes canines, son corps dépourvu de poils, ses membres semblables à des colonnes et leur grande taille ; les adultes pèsent en moyenne 1 500 kg pour les mâles et 1 300 kg pour les femelles, et certains spécimens atteignent jusqu\'à 2,7 tonnes, ce qui en fait l’une des espèces de mammifères terrestres les plus imposantes après les trois espèces d’éléphants, le rhinocéros blanc et le rhinocéros indien. Sa hauteur au garrot est d\'environ 1,5 m et il peut mesurer 3,5 m de longueur. En dépit de son aspect trapu et de ses courts membres, il est capable de courir à 30 km/h sur de courtes distances.');

INSERT INTO `rapport_veterinaire_animal` (`id`, `animal_id`, `date`, `rapport`, `etat`, `nourriture`, `quantite_nourriture`, `veterinaire_id`) VALUES
(1, 2, '2024-04-17 08:02:54', 'RAS', 'En bonne santé', 'foin', '40000.00', 2),
(2, 1, '2024-04-17 09:06:05', 'A de la fièvre.\r\nProbablement un rhume de cerveau', 'Malade', 'viande', '7000.00', 2),
(3, 11, '2024-04-26 10:11:13', NULL, 'En bonne santé', '', '0.00', 2),
(4, 7, '2024-04-26 10:42:29', 'Rapport initial', 'Rapport initial', '', '0.00', NULL),
(5, 4, '2024-04-26 10:54:54', 'Rapport initial', 'Rapport initial', '', '0.00', NULL),
(6, 3, '2024-04-26 14:16:58', 'Rapport initial', 'Rapport initial', '', '0.00', NULL),
(7, 1, '2024-05-03 10:13:56', 'Va mieux', 'Bonne santé', 'Viande', '7000.00', 2),
(8, 3, '2024-05-04 13:31:00', 'RAS', 'bon', 'foin', '10000.00', 2),
(9, 4, '2024-05-04 13:32:00', 'RAS', 'bon', 'bananes', '500.00', 2),
(10, 7, '2024-05-04 13:33:00', 'Trop de dents', 'bon', 'viande', '10000.00', 2);

INSERT INTO `rapport_veterinaire_habitat` (`id`, `habitat_id`, `created_at`, `etat`, `rapport`, `veterinaire_id`) VALUES
(1, 1, '2024-04-29 08:41:44', 'bon', NULL, 2),
(2, 2, '2024-04-29 08:42:17', 'moyen', 'Arbre tombé', 2),
(3, 3, '2024-04-29 08:43:01', 'bon', NULL, 2);

INSERT INTO `review` (`id`, `pseudo`, `comment`, `created_at`, `note`, `is_validated`) VALUES
(1, 'julo', 'c\'etait super', '2024-04-14 14:07:11', 4, 1),
(2, 'neko', 'j\'ai adoré', '2024-04-14 14:32:51', 5, 1),
(3, 'ronchon', 'pas mal mais j\'aime pas les animaux en cage alors c\'est po top quoi', '2024-04-14 15:19:38', 2, 1),
(4, 'test', 'très bien', '2024-04-15 13:15:43', 4, 1),
(6, 'marmotte', 'Les animaux ont l\'air bien traités', '2024-04-17 09:19:13', 4, 1),
(9, 'test', 'test', '2024-05-03 12:24:13', 4, 0),
(10, 'test2', 'comm', '2024-05-03 12:24:39', 4, 0),
(11, 'popo', 'iohj', '2024-05-03 12:26:49', 4, 0);

INSERT INTO `service` (`id`, `nom`, `description`, `created_at`, `updated_at`) VALUES
(1, 'restauration', '<p>Bienvenue au service de restauration du zoo Arcadia ! Nous sommes ravis de vous accueillir dans notre établissement où vous pourrez déguster de délicieux plats tout en profitant de la vue magnifique sur les animaux du zoo.</p>\r\n<p>Notre menu propose une variété de plats savoureux, allant des classiques comme les hot dogs et les hamburgers aux options plus exotiques inspirées par la faune du zoo. Vous pourrez également vous régaler avec des salades fraîches, des sandwiches gourmands et des desserts alléchants.</p>\r\n<p>Nous mettons un point d\'honneur à utiliser des ingrédients de qualité et locaux autant que possible, car nous croyons qu\'une alimentation saine et équilibrée est essentielle pour profiter pleinement de votre journée au zoo.</p>\r\n<p>Que vous soyez en famille, entre amis ou simplement en solo, notre service de restauration saura satisfaire toutes vos envies culinaires. N\'hésitez pas à venir nous rendre visite lors de votre prochaine visite au zoo Arcadia. Bon appétit !</p>', '2024-04-11 10:03:31', NULL),
(2, 'Visite guidée', '<p>Bienvenue au Zoo Arcadia ! Nous sommes ravis de vous proposer un service de visite des habitats avec un guide gratuitement.</p>\r\n<p>Vous souhaitez découvrir les habitats naturels des animaux présentés dans notre parc ? Nos guides expérimentés sont là pour vous accompagner et vous faire découvrir les différents environnements de nos pensionnaires, qu\'ils soient des animaux de la savane, de la jungle, de la forêt tropicale ou encore des fonds marins.</p>\r\n<p>Lors de cette visite guidée, vous pourrez en apprendre davantage sur les spécificités de chaque habitat, sur les différentes espèces animales qui y résident, ainsi que sur les actions de conservation mises en place par le Zoo Arcadia pour protéger la biodiversité.</p>\r\n<p>N\'hésitez pas à vous inscrire à une visite guidée à l\'accueil du zoo. Nos guides se feront un plaisir de vous faire vivre une expérience unique et enrichissante au cœur de la nature. À bientôt au Zoo Arcadia !</p>', '2024-04-11 08:03:41', NULL),
(3, 'Petit train', '<p>Découvrez le zoo Arcadia d\'une toute nouvelle façon grâce à notre service de petit train ! Embarquez à bord de notre adorable train pour une visite guidée passionnante et ludique du zoo. Profitez d\'une vue imprenable sur les animaux en parcourant les différents enclos et habitats dans un confort optimal.</p>\r\n<p>Notre petit train est idéal pour les familles avec de jeunes enfants, les personnes à mobilité réduite ou tout simplement pour ceux qui souhaitent profiter d\'une expérience unique et originale lors de leur visite au zoo. Nos conducteurs sont des experts du zoo et vous fourniront des informations intéressantes sur les différents animaux et espèces que vous rencontrerez tout au long du parcours.</p>\r\n<p>Ne manquez pas cette occasion de découvrir le zoo Arcadia d\'une manière inédite et inoubliable grâce à notre service de petit train. Embarquez dès maintenant et laissez vous transporter dans un univers féerique où la nature est reine et les animaux sont rois.</p>', '2024-04-11 08:04:50', NULL);

INSERT INTO `service_image` (`id`, `service_id`, `slug`, `created_at`, `cover`) VALUES
(1, 3, 'dusan-veverkolog-of8koAjYI7c-unsplash.webp', '2024-04-12 11:02:47', 1),
(2, 1, 'restauration-entiere.webp', '2024-04-12 14:05:56', 1),
(3, 2, 'patrick-mcgregor-5P1fQ3lysiI-unsplash.webp', '2024-04-12 14:07:40', 1);

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `name`, `firstname`) VALUES
(1, 'jose@arcadia.com', '[\"ROLE_ADMIN\"]', '$2y$13$MI1YgKxl620HHEb0jpVtVeZlKRpJVpbx0CqhYpOEXmDIWyrqx4Tt2', 'Studi', 'José'),
(2, 'jean.dupond@free.fr', '[\"ROLE_VETO\"]', '$2y$13$N2mVWRKVaSbPiFINFW0zDeUGtDfAi7Vzks7FipSY.oyolTTp2oTIy', 'Dupond', 'Jean'),
(3, 'edouard.planchon@gmail.com', '[\"ROLE_EMPLOYEE\"]', '$2y$13$AGt0af.KK5G5z4dPq3KBrefUREMrUFsZ5ol6jMUpJ1vKfhSwHWGuC', 'Planchon', 'Edouard');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
