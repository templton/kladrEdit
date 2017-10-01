CREATE TABLE `class_okved` (
  `id` int(11) NOT NULL COMMENT 'pk',
  `code` varchar(16) NOT NULL COMMENT 'Код',
  `name` varchar(512) NOT NULL COMMENT 'Наименование',
  `additional_info` text,
  `parent_id` int(11) DEFAULT NULL COMMENT 'Вычестоящий раздел',
  `parent_code` varchar(16) DEFAULT NULL COMMENT 'Код вышестоящего раздела',
  `node_count` smallint(6) NOT NULL DEFAULT '0' COMMENT 'Количество элементов в ветке'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='ОК видов экономической деятельности';