UPDATE `settings` SET `value` = '{\"version\":\"4.1.0\", \"code\":\"410\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

alter table users add one_time_login_code varchar(32) null after twofa_secret;

-- SEPARATOR --

alter table stores add ordering text null after delivery_ordering_is_enabled;

-- SEPARATOR --

alter table stores drop column on_premise_ordering_is_enabled;

-- SEPARATOR --

alter table stores drop column takeaway_ordering_is_enabled;

-- SEPARATOR --

alter table stores drop column delivery_ordering_is_enabled;

-- EXTENDED SEPARATOR --

alter table payments modify payment_id varchar(128) null;

