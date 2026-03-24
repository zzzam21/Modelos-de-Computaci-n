CREATE TABLE IF NOT EXISTS `partidos` (
  `Club` varchar(40) NOT NULL,
  `played_games` int(11) DEFAULT 0,
  `wins` int(11) DEFAULT 0,
  `draws` int(11) DEFAULT 0,
  `lost` int(11) DEFAULT 0,
  `goals_in_favor` int(11) DEFAULT 0,
  `goals_against` int(11) DEFAULT 0,
  `goals_diference` int(11) DEFAULT 0,
  `points` int(11) DEFAULT 0,
  `logo` varchar(1000) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `matches` (
  `id_match` int(11) NOT NULL AUTO_INCREMENT,
  `id_team1` int(11) NOT NULL,
  `goals_team1` int(11) NOT NULL,
  `id_team2` int(11) NOT NULL,
  `goals_team2` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pendiente',
  `match_date` date NOT NULL,
  PRIMARY KEY(`id_match`),
  Foreign Key (`id_team1`) REFERENCES `partidos`(`id`)
  ON DELETE CASCADE,
  Foreign Key (`id_team2`) REFERENCES `partidos`(`id`)
  ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;