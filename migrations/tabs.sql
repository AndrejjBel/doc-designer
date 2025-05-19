--
-- Структура таблицы `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_url` varchar(255) DEFAULT NULL,
  `file_type` varchar(32) DEFAULT NULL,
  `file_mime_type` varchar(32) DEFAULT NULL,
  `file_post_id` int(11) unsigned DEFAULT NULL,
  `file_author_id` int(11) unsigned DEFAULT NULL,
  `file_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=197 DEFAULT CHARSET=utf8mb4;

--
-- Структура таблицы `options`
--

CREATE TABLE IF NOT EXISTS `options` (
  `option_id` bigint(20) unsigned NOT NULL,
  `option_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_products` text,
  `status` varchar(20) NOT NULL DEFAULT 'created',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_info` varchar(255) DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;

--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(10) unsigned NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_slug` varchar(128) NOT NULL,
  `post_url` varchar(255) NOT NULL,
  `post_type` varchar(32) NOT NULL DEFAULT 'post',
  `post_status` varchar(32) NOT NULL DEFAULT 'published',
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_author_id` int(10) NOT NULL,
  `post_content` text,
  `post_term` varchar(128) NOT NULL,
  `post_tags` text,
  `post_thumb_img` varchar(255) DEFAULT NULL,
  `post_gallery_img` text,
  `post_price` decimal(10,2) DEFAULT NULL,
  `shop_id` int(10) DEFAULT NULL,
  `post_meta_title` varchar(255) DEFAULT NULL,
  `post_meta_description` text,
  `post_meta_keywords` text
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4;

--
-- Структура таблицы `usermeta`
--

CREATE TABLE IF NOT EXISTS `usermeta` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Структура таблицы `usertokens`
--

CREATE TABLE IF NOT EXISTS `usertokens` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token_value` longtext COLLATE utf8mb4_unicode_ci,
  `token_type` varchar(128) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `verified` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `resettable` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `roles_mask` int(10) unsigned NOT NULL DEFAULT '0',
  `registered` int(10) unsigned NOT NULL,
  `last_login` int(10) unsigned DEFAULT NULL,
  `force_logout` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `tlg_id` int(20) unsigned DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Структура таблицы `users_2fa`
--

CREATE TABLE IF NOT EXISTS `users_2fa` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `mechanism` tinyint(2) unsigned NOT NULL,
  `seed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` int(10) unsigned NOT NULL,
  `expires_at` int(10) unsigned DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Структура таблицы `users_confirmations`
--

CREATE TABLE IF NOT EXISTS `users_confirmations` (
  `id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `email` varchar(249) COLLATE utf8mb4_unicode_ci NOT NULL,
  `selector` varchar(16) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Структура таблицы `users_otps`
--

CREATE TABLE IF NOT EXISTS `users_otps` (
  `id` bigint(20) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `mechanism` tinyint(2) unsigned NOT NULL,
  `single_factor` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires_at` int(10) unsigned DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Структура таблицы `users_remembered`
--

CREATE TABLE IF NOT EXISTS `users_remembered` (
  `id` bigint(20) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `selector` varchar(24) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Структура таблицы `users_resets`
--

CREATE TABLE IF NOT EXISTS `users_resets` (
  `id` bigint(20) unsigned NOT NULL,
  `user` int(10) unsigned NOT NULL,
  `selector` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `token` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `expires` int(10) unsigned NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Структура таблицы `users_throttling`
--

CREATE TABLE IF NOT EXISTS `users_throttling` (
  `bucket` varchar(44) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `tokens` float unsigned NOT NULL,
  `replenished_at` int(10) unsigned NOT NULL,
  `expires_at` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Индексы таблицы `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `file_author_id` (`file_author_id`);

--
-- Индексы таблицы `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`option_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `post_date` (`post_date`),
  ADD KEY `post_author_id` (`post_author_id`,`post_date`),
  ADD FULLTEXT KEY `post_title` (`post_title`,`post_content`);

--
-- Индексы таблицы `usermeta`
--
ALTER TABLE `usermeta`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_2` (`user_id`),
  ADD KEY `user_id` (`user_id`);


--
-- Индексы таблицы `usertokens`
--
ALTER TABLE `usertokens`
    ADD PRIMARY KEY (`id`),
    ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `users_2fa`
--
ALTER TABLE `users_2fa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id_mechanism` (`user_id`,`mechanism`);

--
-- Индексы таблицы `users_confirmations`
--
ALTER TABLE `users_confirmations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `email_expires` (`email`,`expires`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `users_otps`
--
ALTER TABLE `users_otps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_mechanism` (`user_id`,`mechanism`),
  ADD KEY `selector_user_id` (`selector`,`user_id`);

--
-- Индексы таблицы `users_remembered`
--
ALTER TABLE `users_remembered`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `users_resets`
--
ALTER TABLE `users_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `selector` (`selector`),
  ADD KEY `user_expires` (`user`,`expires`);

--
-- Индексы таблицы `users_throttling`
--
ALTER TABLE `users_throttling`
  ADD PRIMARY KEY (`bucket`),
  ADD KEY `expires_at` (`expires_at`);


--
-- AUTO_INCREMENT для таблицы `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `options`
--
ALTER TABLE `options`
  MODIFY `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `usermeta`
--
ALTER TABLE `usermeta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `usermeta`
--
ALTER TABLE `usertokens`
    MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users_2fa`
--
ALTER TABLE `users_2fa`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users_confirmations`
--
ALTER TABLE `users_confirmations`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users_otps`
--
ALTER TABLE `users_otps`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users_remembered`
--
ALTER TABLE `users_remembered`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT для таблицы `users_resets`
--
ALTER TABLE `users_resets`
  MODIFY `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT;


--
-- Дамп данных таблицы `users` создаем супер админа, пароль abpZX951753123321ZXC
--

INSERT INTO `users` (`id`, `email`, `password`, `username`, `first_name`, `last_name`, `status`, `verified`, `resettable`, `roles_mask`, `registered`, `last_login`, `force_logout`, `tlg_id`) VALUES
(1, 'creat-sites@yandex.ru', '$2y$10$lTjF6UI96ENWjAV.NsePSuFYSMp4TlC5jygWzwr5NagU2Z.KiGq3u', 'Andrej', NULL, NULL, 0, 1, 1, 262144, 1739261795, NULL, 0, NULL);
