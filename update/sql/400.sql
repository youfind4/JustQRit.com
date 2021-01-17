UPDATE `settings` SET `value` = '{\"version\":\"4.0.0\", \"code\":\"400\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

alter table stores add stripe text null after delivery_ordering_is_enabled;

-- SEPARATOR --

alter table stores add paypal text null after stripe;

-- SEPARATOR --

alter table stores add offline_payment text null after paypal;

-- SEPARATOR --

alter table stores add business text null after offline_payment;

-- SEPARATOR --

alter table orders add processor varchar(16) default 'offline_payment' null after type;

-- SEPARATOR --

alter table orders add is_paid tinyint default 0 null after ordered_items;

-- SEPARATOR --

CREATE TABLE `customers_payments` (
`customer_payment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
`order_id` int(10) unsigned DEFAULT NULL,
`store_id` int(10) unsigned DEFAULT NULL,
`user_id` int(11) DEFAULT NULL,
`processor` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`payment_id` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`billing` text COLLATE utf8mb4_unicode_ci,
`total_amount` float DEFAULT NULL,
`currency` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
`datetime` datetime DEFAULT NULL,
UNIQUE KEY `customer_payment_id` (`customer_payment_id`) USING BTREE,
KEY `order_id` (`order_id`),
KEY `store_id` (`store_id`),
KEY `user_id` (`user_id`),
CONSTRAINT `customers_payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE SET NULL ON UPDATE CASCADE,
CONSTRAINT `customers_payments_ibfk_2` FOREIGN KEY (`store_id`) REFERENCES `stores` (`store_id`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `customers_payments_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
