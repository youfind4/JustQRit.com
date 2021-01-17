UPDATE `settings` SET `value` = '{\"version\":\"2.0.0\", \"code\":\"200\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

alter table stores change orders_is_enabled on_premise_ordering_is_enabled tinyint default 0 null;

-- SEPARATOR --

DELETE FROM `orders`;

-- SEPARATOR --

alter table stores add takeaway_ordering_is_enabled tinyint default 0 null after on_premise_ordering_is_enabled;

-- SEPARATOR --

alter table stores	add delivery_ordering_is_enabled tinyint default 0 null after takeaway_ordering_is_enabled;

-- SEPARATOR --

alter table orders add type varchar(36) not null after user_id;

-- SEPARATOR --

alter table orders modify type varchar(36) not null comment '''on_premise'', ''takeaway'', ''delivery''';

-- SEPARATOR --

alter table orders add details text null after type;

-- SEPARATOR --

alter table orders drop column name;

-- SEPARATOR --

alter table orders drop column message;

-- SEPARATOR --

alter table orders drop column number;

-- SEPARATOR --

CREATE TABLE `domains` (
  `domain_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `scheme` varchar(8) NOT NULL DEFAULT '',
  `host` varchar(256) NOT NULL DEFAULT '',
  `custom_index_url` varchar(256) DEFAULT NULL,
  `type` tinyint(11) DEFAULT '1',
  `is_enabled` tinyint(4) DEFAULT '0',
  `datetime` datetime DEFAULT NULL,
  `last_datetime` datetime DEFAULT NULL,
  PRIMARY KEY (`domain_id`),
  KEY `user_id` (`user_id`),
  KEY `domains_host_index` (`host`),
  KEY `domains_type_index` (`type`),
  KEY `domains_ibfk_2` (`store_id`),
  CONSTRAINT `domains_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `domains_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `stores` (`store_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- SEPARATOR --

alter table email_reports modify id int(11) unsigned auto_increment;

-- SEPARATOR --

alter table stores add domain_id int(11) unsigned null after store_id;

-- SEPARATOR --

alter table stores add constraint stores_ibfk_2 foreign key (domain_id) references domains (domain_id) on update cascade on delete cascade;

