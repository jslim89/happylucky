# ---------------------------------------------------------------------- #
# Script generated with: DeZign for Databases v6.3.2                     #
# Target DBMS:           MySQL 5                                         #
# Project file:          fyp_happy_lucky.dez                             #
# Project name:                                                          #
# Author:                                                                #
# Script type:           Database creation script                        #
# Created on:            2012-01-17 13:38                                #
# ---------------------------------------------------------------------- #


# ---------------------------------------------------------------------- #
# Tables                                                                 #
# ---------------------------------------------------------------------- #

# ---------------------------------------------------------------------- #
# Add table "country"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `country` (
    `id` INTEGER(3) UNSIGNED NOT NULL AUTO_INCREMENT,
    `country_name` VARCHAR(128) COLLATE utf8_general_ci NOT NULL,
    `iso_code_2` VARCHAR(2) COLLATE utf8_general_ci NOT NULL,
    `iso_code_3` VARCHAR(3) COLLATE utf8_general_ci NOT NULL,
    `postcode_required` INTEGER(1) NOT NULL DEFAULT 0,
    CONSTRAINT `PK_country` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "amulet_type"                                                #
# ---------------------------------------------------------------------- #

CREATE TABLE `amulet_type` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `amulet_type_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `amulet_desc` TEXT COLLATE utf8_general_ci NOT NULL,
    `primary_image_url` VARCHAR(100) COLLATE utf8_general_ci,
    CONSTRAINT `PK_amulet_type` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "amulet_type_image"                                          #
# ---------------------------------------------------------------------- #

CREATE TABLE `amulet_type_image` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `image_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `url` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `extension` VARCHAR(20) COLLATE utf8_general_ci NOT NULL,
    `alt` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `image_desc` TEXT COLLATE utf8_general_ci NOT NULL,
    `amulet_type_id` BIGINT(8) UNSIGNED NOT NULL,
    CONSTRAINT `PK_amulet_type_image` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "monk"                                                       #
# ---------------------------------------------------------------------- #

CREATE TABLE `monk` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `monk_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `monk_story` TEXT COLLATE utf8_general_ci NOT NULL,
    `primary_image_url` VARCHAR(100) COLLATE utf8_general_ci,
    CONSTRAINT `PK_monk` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "monk_image"                                                 #
# ---------------------------------------------------------------------- #

CREATE TABLE `monk_image` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `image_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `url` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `extension` VARCHAR(20) COLLATE utf8_general_ci NOT NULL,
    `alt` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `image_desc` TEXT COLLATE utf8_general_ci NOT NULL,
    `monk_id` BIGINT(8) UNSIGNED,
    CONSTRAINT `PK_monk_image` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "supplier"                                                   #
# ---------------------------------------------------------------------- #

CREATE TABLE `supplier` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `supplier_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `address` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `town` VARCHAR(50) COLLATE utf8_general_ci,
    `postcode` VARCHAR(20) COLLATE utf8_general_ci,
    `city` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `state` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `contact_no` VARCHAR(30) COLLATE utf8_general_ci NOT NULL,
    `email` VARCHAR(80) COLLATE utf8_general_ci NOT NULL,
    `contact_person` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `fax` VARCHAR(30) COLLATE utf8_general_ci,
    `country_id` INTEGER(3) UNSIGNED DEFAULT 129,
    PRIMARY KEY (`id`),
    CONSTRAINT `uniq` UNIQUE (`email`)
);

# ---------------------------------------------------------------------- #
# Add table "user"                                                       #
# ---------------------------------------------------------------------- #

CREATE TABLE `user` (
    `id` INTEGER(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `last_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `email` VARCHAR(80) COLLATE utf8_general_ci NOT NULL,
    `password` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `salt` VARCHAR(32) COLLATE utf8_general_ci COMMENT 'In order for password more secure, salting the password is required',
    `security_question` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `security_answer` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    CONSTRAINT `PK_user` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "session"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `session` (
    `session_id` VARCHAR(40) NOT NULL DEFAULT '0',
    `ip_address` VARCHAR(16) NOT NULL DEFAULT '0',
    `user_agent` VARCHAR(120) NOT NULL,
    `last_activity` INTEGER(10) UNSIGNED NOT NULL DEFAULT 0,
    `user_data` TEXT NOT NULL,
    CONSTRAINT `PK_session` PRIMARY KEY (`session_id`)
);

CREATE INDEX `IDX_session_1` ON `session` (`last_activity`);

# ---------------------------------------------------------------------- #
# Add table "customer"                                                   #
# ---------------------------------------------------------------------- #

CREATE TABLE `customer` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `first_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `last_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `address` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `town` VARCHAR(50) COLLATE utf8_general_ci,
    `postcode` VARCHAR(20) COLLATE utf8_bin,
    `city` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `state` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `country_id` INTEGER(3) UNSIGNED COLLATE utf8_general_ci DEFAULT 129,
    `contact_no` VARCHAR(30) COLLATE utf8_general_ci NOT NULL,
    `email` VARCHAR(80) COLLATE utf8_general_ci NOT NULL,
    `password` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `registration_date` BIGINT(8) UNSIGNED NOT NULL DEFAULT 0,
    `age` INTEGER(3) UNSIGNED,
    `sex` CHAR(1),
    `security_question` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `security_answer` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `salt` VARCHAR(32) COLLATE utf8_general_ci COMMENT 'use for password salting',
    `is_verified` INTEGER(1) NOT NULL DEFAULT 0,
    CONSTRAINT `PK_customer` PRIMARY KEY (`id`),
    CONSTRAINT `uniq` UNIQUE (`email`)
);

# ---------------------------------------------------------------------- #
# Add table "customer_order"                                             #
# ---------------------------------------------------------------------- #

CREATE TABLE `customer_order` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `customer_id` BIGINT(8) UNSIGNED,
    `order_date` BIGINT(8) UNSIGNED NOT NULL DEFAULT 0,
    `subtotal` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `grand_total` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `shipping_address` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `shipping_town` VARCHAR(50) COLLATE utf8_general_ci,
    `shipping_postcode` VARCHAR(20) COLLATE utf8_general_ci,
    `shipping_city` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `shipping_state` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `shipping_country_id` INTEGER(3) UNSIGNED,
    `shipping_contact_no` VARCHAR(30) COLLATE utf8_general_ci NOT NULL,
    `first_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `last_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `email` VARCHAR(80) COLLATE utf8_general_ci NOT NULL,
    `recipient_bank_acc` VARCHAR(30) COLLATE utf8_general_ci NOT NULL,
    `payment_date` BIGINT(8) UNSIGNED,
    `shipping_cost` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `order_status` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    CONSTRAINT `PK_customer_order` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "amulet"                                                     #
# ---------------------------------------------------------------------- #

CREATE TABLE `amulet` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `amulet_code` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `amulet_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `amulet_desc` TEXT COLLATE utf8_general_ci NOT NULL,
    `produced_date` BIGINT(8) UNSIGNED,
    `produced_place` VARCHAR(100) COLLATE utf8_general_ci,
    `primary_image_url` VARCHAR(100) COLLATE utf8_general_ci,
    `monk_id` BIGINT(8) UNSIGNED,
    `amulet_type_id` BIGINT(8) UNSIGNED,
    CONSTRAINT `PK_amulet` PRIMARY KEY (`id`),
    CONSTRAINT `uniq` UNIQUE (`amulet_code`)
);

# ---------------------------------------------------------------------- #
# Add table "amulet_image"                                               #
# ---------------------------------------------------------------------- #

CREATE TABLE `amulet_image` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `image_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `url` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `extension` VARCHAR(20) COLLATE utf8_general_ci NOT NULL,
    `alt` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `image_desc` TEXT COLLATE utf8_general_ci NOT NULL,
    `amulet_id` BIGINT(8) UNSIGNED NOT NULL,
    CONSTRAINT `PK_amulet_image` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "amulet_product"                                             #
# ---------------------------------------------------------------------- #

CREATE TABLE `amulet_product` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `size` VARCHAR(30) COLLATE utf8_general_ci NOT NULL,
    `ingredient` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `amulet_id` BIGINT(8) UNSIGNED,
    CONSTRAINT `PK_amulet_product` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "product"                                                    #
# ---------------------------------------------------------------------- #

CREATE TABLE `product` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_code` VARCHAR(30) COLLATE utf8_general_ci NOT NULL,
    `product_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `product_desc` TEXT COLLATE utf8_general_ci NOT NULL,
    `standard_price` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `quantity_available` INTEGER(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Whenever a product_batch is stocked in, this attribute will be sum with the quantity stocked in',
    `min_quantity` INTEGER(5) UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Minimum quantity that must be ordered',
    `min_qty_alert` INTEGER(5) UNSIGNED COMMENT 'When the quantity left few unit, it will alert. Example: quantity_available <= min_qty_alert, it will inform to re-stock',
    `total_num_sold` INTEGER(9) UNSIGNED NOT NULL DEFAULT 0,
    `created_date` BIGINT(8) UNSIGNED NOT NULL,
    `primary_image_url` VARCHAR(100) COLLATE utf8_general_ci,
    `product_type` VARCHAR(50) COLLATE utf8_general_ci NOT NULL COMMENT 'Product type to indicate whether it is RETAIL or WHOLESALE',
    `amulet_product_id` BIGINT(8) UNSIGNED,
    CONSTRAINT `PK_product` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "product_image"                                              #
# ---------------------------------------------------------------------- #

CREATE TABLE `product_image` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `image_name` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `url` VARCHAR(100) COLLATE utf8_general_ci NOT NULL,
    `extension` VARCHAR(20) COLLATE utf8_general_ci NOT NULL,
    `alt` VARCHAR(50) COLLATE utf8_general_ci NOT NULL,
    `image_desc` TEXT COLLATE utf8_general_ci NOT NULL,
    `product_id` BIGINT(8) UNSIGNED,
    CONSTRAINT `PK_product_image` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "product_batch"                                              #
# ---------------------------------------------------------------------- #

CREATE TABLE `product_batch` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `unit_cost` DECIMAL(15,2) UNSIGNED NOT NULL DEFAULT 0.00,
    `stock_in_date` BIGINT(8) NOT NULL,
    `batch_no` INTEGER(10) UNSIGNED NOT NULL,
    `quantity_stock_in` INTEGER(5) UNSIGNED NOT NULL DEFAULT 1,
    `product_id` BIGINT(8) UNSIGNED,
    `supplier_id` BIGINT(8) UNSIGNED,
    CONSTRAINT `PK_product_batch` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Add table "order_detail"                                               #
# ---------------------------------------------------------------------- #

CREATE TABLE `order_detail` (
    `id` BIGINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `product_id` BIGINT(8) UNSIGNED,
    `quantity` INTEGER(5) UNSIGNED NOT NULL DEFAULT 0,
    `unit_sell_price` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `subtotal` DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    `order_id` BIGINT(8) UNSIGNED,
    CONSTRAINT `PK_order_detail` PRIMARY KEY (`id`)
);

# ---------------------------------------------------------------------- #
# Foreign key constraints                                                #
# ---------------------------------------------------------------------- #

ALTER TABLE `customer` ADD CONSTRAINT `country_customer` 
    FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `customer_order` ADD CONSTRAINT `customer_customer_order` 
    FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `customer_order` ADD CONSTRAINT `country_customer_order` 
    FOREIGN KEY (`shipping_country_id`) REFERENCES `country` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `order_detail` ADD CONSTRAINT `customer_order_order_detail` 
    FOREIGN KEY (`order_id`) REFERENCES `customer_order` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `order_detail` ADD CONSTRAINT `product_order_detail` 
    FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `product` ADD CONSTRAINT `amulet_product_product` 
    FOREIGN KEY (`amulet_product_id`) REFERENCES `amulet_product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `product_image` ADD CONSTRAINT `product_product_image` 
    FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `amulet_product` ADD CONSTRAINT `amulet_amulet_product` 
    FOREIGN KEY (`amulet_id`) REFERENCES `amulet` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `amulet` ADD CONSTRAINT `amulet_type_amulet` 
    FOREIGN KEY (`amulet_type_id`) REFERENCES `amulet_type` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `amulet` ADD CONSTRAINT `monk_amulet` 
    FOREIGN KEY (`monk_id`) REFERENCES `monk` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `amulet_type_image` ADD CONSTRAINT `amulet_type_amulet_type_image` 
    FOREIGN KEY (`amulet_type_id`) REFERENCES `amulet_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `monk_image` ADD CONSTRAINT `monk_monk_image` 
    FOREIGN KEY (`monk_id`) REFERENCES `monk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `supplier` ADD CONSTRAINT `country_supplier` 
    FOREIGN KEY (`country_id`) REFERENCES `country` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `amulet_image` ADD CONSTRAINT `amulet_amulet_image` 
    FOREIGN KEY (`id`) REFERENCES `amulet` (`id`);

ALTER TABLE `product_batch` ADD CONSTRAINT `product_product_batch` 
    FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE `product_batch` ADD CONSTRAINT `supplier_product_batch` 
    FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`);
