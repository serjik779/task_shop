-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Сен 01 2017 г., 00:39
-- Версия сервера: 5.7.19-0ubuntu0.16.04.1
-- Версия PHP: 7.1.8-2+ubuntu16.04.1+deb.sury.org+4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `acl_classes`
--

CREATE TABLE `acl_classes` (
  `id` int(10) UNSIGNED NOT NULL,
  `class_type` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `acl_entries`
--

CREATE TABLE `acl_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `class_id` int(10) UNSIGNED NOT NULL,
  `object_identity_id` int(10) UNSIGNED DEFAULT NULL,
  `security_identity_id` int(10) UNSIGNED NOT NULL,
  `field_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ace_order` smallint(5) UNSIGNED NOT NULL,
  `mask` int(11) NOT NULL,
  `granting` tinyint(1) NOT NULL,
  `granting_strategy` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `audit_success` tinyint(1) NOT NULL,
  `audit_failure` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `acl_object_identities`
--

CREATE TABLE `acl_object_identities` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_object_identity_id` int(10) UNSIGNED DEFAULT NULL,
  `class_id` int(10) UNSIGNED NOT NULL,
  `object_identifier` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `entries_inheriting` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `acl_object_identity_ancestors`
--

CREATE TABLE `acl_object_identity_ancestors` (
  `object_identity_id` int(10) UNSIGNED NOT NULL,
  `ancestor_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `acl_security_identities`
--

CREATE TABLE `acl_security_identities` (
  `id` int(10) UNSIGNED NOT NULL,
  `identifier` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `username` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `discount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `image_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `image_id`, `title`, `slug`) VALUES
(1, 1, 'Mobile phones', 'mobile-phones'),
(2, 2, 'Tablets', 'tablets'),
(3, 3, 'Notebooks', 'notebooks');

-- --------------------------------------------------------

--
-- Структура таблицы `delivery_type`
--

CREATE TABLE `delivery_type` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cost` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `delivery_type`
--

INSERT INTO `delivery_type` (`id`, `title`, `cost`) VALUES
(1, 'Office', 0),
(2, 'By mail', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `Feedback`
--

CREATE TABLE `Feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `fos_user_group`
--

CREATE TABLE `fos_user_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `fos_user_user`
--

CREATE TABLE `fos_user_user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `date_of_birth` datetime DEFAULT NULL,
  `firstname` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lastname` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `biography` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `locale` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `timezone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `facebook_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json)',
  `twitter_uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `twitter_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json)',
  `gplus_uid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gplus_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gplus_data` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:json)',
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `two_step_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `fos_user_user`
--

INSERT INTO `fos_user_user` (`id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `locked`, `expired`, `expires_at`, `confirmation_token`, `password_requested_at`, `roles`, `credentials_expired`, `credentials_expire_at`, `created_at`, `updated_at`, `date_of_birth`, `firstname`, `lastname`, `website`, `biography`, `gender`, `locale`, `timezone`, `phone`, `facebook_uid`, `facebook_name`, `facebook_data`, `twitter_uid`, `twitter_name`, `twitter_data`, `gplus_uid`, `gplus_name`, `gplus_data`, `token`, `two_step_code`) VALUES
(1, 'admin', 'admin', 'belserega@gmail.com', 'belserega@gmail.com', 1, 'a87jgeu9gjcwg040g0kcsggcc8sgoww', 'V6s2zygSYbTZc2ufa3wjwPaq/DXTJz9x5sHmSOAkBqScROh9Xe9nkjBpnVVPSgoPp6Y9eANW5x6KrfLrLCxKlw==', '2017-09-01 00:33:18', 0, 0, NULL, NULL, NULL, 'a:1:{i:0;s:16:"ROLE_SUPER_ADMIN";}', 0, NULL, '2017-09-01 00:06:36', '2017-09-01 00:33:18', NULL, NULL, NULL, NULL, NULL, 'u', NULL, NULL, NULL, NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL, 'null', NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `fos_user_user_group`
--

CREATE TABLE `fos_user_user_group` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `images`
--

INSERT INTO `images` (`id`, `filename`, `updated`) VALUES
(1, 'mobile.jpg', '2017-09-01 00:07:04'),
(2, 'ArlandCom_Take_5_Tablets.jpg', '2017-09-01 00:07:20'),
(3, 'ArlandCom_Take_5_Tablets.jpg', '2017-09-01 00:07:44'),
(4, 's4min.jpg', '2017-09-01 00:08:26'),
(5, 's4min.jpg', '2017-09-01 00:08:28'),
(6, 'certificate.jpg', '2017-09-01 00:11:40');

-- --------------------------------------------------------

--
-- Структура таблицы `images_products`
--

CREATE TABLE `images_products` (
  `images_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `images_products`
--

INSERT INTO `images_products` (`images_id`, `products_id`) VALUES
(4, 1),
(5, 2),
(6, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `orders_info`
--

CREATE TABLE `orders_info` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `orders_info`
--

INSERT INTO `orders_info` (`id`, `date`, `address`, `phone`, `name`) VALUES
(1, '2017-10-04 00:00:00', 'Grodno', '+375(33) 123-12-12', 'Serjik');

-- --------------------------------------------------------

--
-- Структура таблицы `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `delivery_type_id` int(11) DEFAULT NULL,
  `order_info_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `order_items`
--

INSERT INTO `order_items` (`id`, `delivery_type_id`, `order_info_id`, `product_id`, `discount`, `amount`) VALUES
(1, 1, 1, 1, 10, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `Pages`
--

CREATE TABLE `Pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `Pages`
--

INSERT INTO `Pages` (`id`, `title`, `content`) VALUES
(1, 'About', '<p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?</p>'),
(2, 'About', '<p><img alt="" src="/uploads/2017/09/s4min.jpg" style="float:left; height:244px; width:300px" />But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?</p>'),
(3, 'Contact', '<p>BELARUS,<br />\r\nBOGUTSKOGO 5, FLOOR 4,<br />\r\n230002, GRODNO<br />\r\n<strong>T:</strong>&nbsp;+375 152 96 43 46<br />\r\n<strong>F:</strong>&nbsp;+375 152 41 27 55<br />\r\n<a href="mailto:CONTACT@INTEXSOFT.COM?subject=Ustora">CONTACT@INTEXSOFT.COM</a></p>');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `cost` double NOT NULL,
  `amount` int(11) DEFAULT NULL,
  `service_id` int(11) NOT NULL,
  `on_main` tinyint(1) NOT NULL,
  `is_visible` tinyint(1) NOT NULL,
  `top` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `slug` varchar(128) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_id`, `title`, `description`, `cost`, `amount`, `service_id`, `on_main`, `is_visible`, `top`, `created`, `slug`) VALUES
(1, 1, 'samsung-galaxy-s4-mini', '<p>Samsung Galaxy S4 Mini</p>', 100, 12, 102, 1, 1, 0, '2017-09-01 00:08:26', 'samsung-galaxy-s4-mini'),
(2, 1, 'samsung-galaxy-s4-mini-1', '<p>Samsung Galaxy S4 Mini</p>', 100, 12, 102, 1, 1, 0, '2017-09-01 00:08:28', 'samsung-galaxy-s4-mini-1'),
(3, 1, 'nokia-lumia-910', '<p>Nokia Lumia 910</p>', 50, 3, 1231, 0, 1, 0, '2017-09-01 00:11:40', 'nokia-lumia-910');

-- --------------------------------------------------------

--
-- Структура таблицы `Roles`
--

CREATE TABLE `Roles` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `user_admin`
--

CREATE TABLE `user_admin` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `wishlist`
--

CREATE TABLE `wishlist` (
  `users_id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `acl_classes`
--
ALTER TABLE `acl_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_69DD750638A36066` (`class_type`);

--
-- Индексы таблицы `acl_entries`
--
ALTER TABLE `acl_entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4` (`class_id`,`object_identity_id`,`field_name`,`ace_order`),
  ADD KEY `IDX_46C8B806EA000B103D9AB4A6DF9183C9` (`class_id`,`object_identity_id`,`security_identity_id`),
  ADD KEY `IDX_46C8B806EA000B10` (`class_id`),
  ADD KEY `IDX_46C8B8063D9AB4A6` (`object_identity_id`),
  ADD KEY `IDX_46C8B806DF9183C9` (`security_identity_id`);

--
-- Индексы таблицы `acl_object_identities`
--
ALTER TABLE `acl_object_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9407E5494B12AD6EA000B10` (`object_identifier`,`class_id`),
  ADD KEY `IDX_9407E54977FA751A` (`parent_object_identity_id`);

--
-- Индексы таблицы `acl_object_identity_ancestors`
--
ALTER TABLE `acl_object_identity_ancestors`
  ADD PRIMARY KEY (`object_identity_id`,`ancestor_id`),
  ADD KEY `IDX_825DE2993D9AB4A6` (`object_identity_id`),
  ADD KEY `IDX_825DE299C671CEA1` (`ancestor_id`);

--
-- Индексы таблицы `acl_security_identities`
--
ALTER TABLE `acl_security_identities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8835EE78772E836AF85E0677` (`identifier`,`username`);

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Индексы таблицы `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart` (`cart_id`),
  ADD KEY `fk_cart_product` (`product_id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_3AF34668989D9B62` (`slug`),
  ADD KEY `fk_image` (`image_id`);

--
-- Индексы таблицы `delivery_type`
--
ALTER TABLE `delivery_type`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `Feedback`
--
ALTER TABLE `Feedback`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `fos_user_group`
--
ALTER TABLE `fos_user_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_583D1F3E5E237E06` (`name`);

--
-- Индексы таблицы `fos_user_user`
--
ALTER TABLE `fos_user_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C560D76192FC23A8` (`username_canonical`),
  ADD UNIQUE KEY `UNIQ_C560D761A0D96FBF` (`email_canonical`);

--
-- Индексы таблицы `fos_user_user_group`
--
ALTER TABLE `fos_user_user_group`
  ADD PRIMARY KEY (`user_id`,`group_id`),
  ADD KEY `IDX_B3C77447A76ED395` (`user_id`),
  ADD KEY `IDX_B3C77447FE54D947` (`group_id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images_products`
--
ALTER TABLE `images_products`
  ADD PRIMARY KEY (`images_id`,`products_id`),
  ADD KEY `IDX_10992730D44F05E5` (`images_id`),
  ADD KEY `IDX_109927306C8A81A9` (`products_id`);

--
-- Индексы таблицы `orders_info`
--
ALTER TABLE `orders_info`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_info` (`order_info_id`),
  ADD KEY `fk_delivery_type` (`delivery_type_id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Индексы таблицы `Pages`
--
ALTER TABLE `Pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_B3BA5A5A989D9B62` (`slug`),
  ADD KEY `fk_category` (`category_id`);

--
-- Индексы таблицы `Roles`
--
ALTER TABLE `Roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_roles` (`role_id`);

--
-- Индексы таблицы `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6ACCF62ED60322AC` (`role_id`);

--
-- Индексы таблицы `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`users_id`,`products_id`),
  ADD KEY `IDX_9CE12A3167B3B43D` (`users_id`),
  ADD KEY `IDX_9CE12A316C8A81A9` (`products_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `acl_classes`
--
ALTER TABLE `acl_classes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `acl_entries`
--
ALTER TABLE `acl_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `acl_object_identities`
--
ALTER TABLE `acl_object_identities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `acl_security_identities`
--
ALTER TABLE `acl_security_identities`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `delivery_type`
--
ALTER TABLE `delivery_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `Feedback`
--
ALTER TABLE `Feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `fos_user_group`
--
ALTER TABLE `fos_user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `fos_user_user`
--
ALTER TABLE `fos_user_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `orders_info`
--
ALTER TABLE `orders_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `Pages`
--
ALTER TABLE `Pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT для таблицы `Roles`
--
ALTER TABLE `Roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `user_admin`
--
ALTER TABLE `user_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `acl_entries`
--
ALTER TABLE `acl_entries`
  ADD CONSTRAINT `FK_46C8B8063D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_46C8B806DF9183C9` FOREIGN KEY (`security_identity_id`) REFERENCES `acl_security_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_46C8B806EA000B10` FOREIGN KEY (`class_id`) REFERENCES `acl_classes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `acl_object_identities`
--
ALTER TABLE `acl_object_identities`
  ADD CONSTRAINT `FK_9407E54977FA751A` FOREIGN KEY (`parent_object_identity_id`) REFERENCES `acl_object_identities` (`id`);

--
-- Ограничения внешнего ключа таблицы `acl_object_identity_ancestors`
--
ALTER TABLE `acl_object_identity_ancestors`
  ADD CONSTRAINT `FK_825DE2993D9AB4A6` FOREIGN KEY (`object_identity_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_825DE299C671CEA1` FOREIGN KEY (`ancestor_id`) REFERENCES `acl_object_identities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_BA388B7A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ограничения внешнего ключа таблицы `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `FK_BEF484451AD5CDBF` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`),
  ADD CONSTRAINT `FK_BEF484454584665A` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `FK_3AF346683DA5256D` FOREIGN KEY (`image_id`) REFERENCES `images` (`id`);

--
-- Ограничения внешнего ключа таблицы `fos_user_user_group`
--
ALTER TABLE `fos_user_user_group`
  ADD CONSTRAINT `FK_B3C77447A76ED395` FOREIGN KEY (`user_id`) REFERENCES `fos_user_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B3C77447FE54D947` FOREIGN KEY (`group_id`) REFERENCES `fos_user_group` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `images_products`
--
ALTER TABLE `images_products`
  ADD CONSTRAINT `FK_109927306C8A81A9` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `FK_10992730D44F05E5` FOREIGN KEY (`images_id`) REFERENCES `images` (`id`);

--
-- Ограничения внешнего ключа таблицы `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `FK_62809DB04584665A` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `FK_62809DB0ABF168B3` FOREIGN KEY (`order_info_id`) REFERENCES `orders_info` (`id`),
  ADD CONSTRAINT `FK_62809DB0CF52334D` FOREIGN KEY (`delivery_type_id`) REFERENCES `delivery_type` (`id`);

--
-- Ограничения внешнего ключа таблицы `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `FK_B3BA5A5A12469DE2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK_1483A5E9D60322AC` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`id`);

--
-- Ограничения внешнего ключа таблицы `user_admin`
--
ALTER TABLE `user_admin`
  ADD CONSTRAINT `FK_6ACCF62ED60322AC` FOREIGN KEY (`role_id`) REFERENCES `Roles` (`id`);

--
-- Ограничения внешнего ключа таблицы `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `FK_9CE12A3167B3B43D` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_9CE12A316C8A81A9` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
