UPDATE `settings` SET `value` = '{\"version\":\"3.0.0\", \"code\":\"300\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

DROP TABLE `orders_items`;

-- SEPARATOR --

DELETE FROM `orders`;

-- SEPARATOR --

alter table stores add orders bigint unsigned default 0 null after pageviews;

-- SEPARATOR --

alter table orders add order_number bigint default 1 null after user_id;

-- SEPARATOR --

alter table stores add email_orders_is_enabled tinyint default 0 null after email_reports_last_datetime;

-- SEPARATOR --

alter table items add orders bigint unsigned default 0 null after pageviews;

-- SEPARATOR --

alter table orders add ordered_items int default 0 null after price;

-- SEPARATOR --

CREATE TABLE `orders_items` (
`order_item_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`order_id` int(11) unsigned NOT NULL,
`item_variant_id` int(11) unsigned DEFAULT NULL,
`item_id` int(11) unsigned DEFAULT NULL,
`category_id` int(11) unsigned DEFAULT NULL,
`menu_id` int(11) unsigned DEFAULT NULL,
`store_id` int(11) unsigned NOT NULL,
`item_extras_ids` text COLLATE utf8mb4_unicode_ci,
`data` text COLLATE utf8mb4_unicode_ci,
`price` float NOT NULL DEFAULT '0',
`quantity` int(11) unsigned NOT NULL DEFAULT '1',
`datetime` datetime DEFAULT NULL,
PRIMARY KEY (`order_item_id`),
KEY `store_id` (`store_id`) USING BTREE,
KEY `order_id` (`order_id`),
KEY `orders_items_datetime_idx` (`datetime`) USING BTREE,
KEY `item_variant_id` (`item_variant_id`),
KEY `item_id` (`item_id`),
KEY `category_id` (`category_id`),
KEY `menu_id` (`menu_id`),
CONSTRAINT `orders_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `orders_items_ibfk_10` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`menu_id`) ON DELETE SET NULL ON UPDATE CASCADE,
CONSTRAINT `orders_items_ibfk_6` FOREIGN KEY (`store_id`) REFERENCES `stores` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `orders_items_ibfk_7` FOREIGN KEY (`item_variant_id`) REFERENCES `items_variants` (`item_variant_id`) ON DELETE SET NULL ON UPDATE CASCADE,
CONSTRAINT `orders_items_ibfk_8` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`) ON DELETE SET NULL ON UPDATE CASCADE,
CONSTRAINT `orders_items_ibfk_9` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
