--
-- Структура таблицы `glampings`
--

CREATE TABLE IF NOT EXISTS `glampings` (
  `id` int unsigned NOT NULL,
  `post_title` varchar(255) NOT NULL,
  `post_content` text DEFAULT NULL,
  `post_slug` varchar(128) NOT NULL,
  `post_url` varchar(255) NOT NULL,
  `post_status` varchar(32) NOT NULL DEFAULT 'published',
  `post_author` int NOT NULL,
  `post_term` int NOT NULL,
  `post_tags` text DEFAULT NULL,
  `post_thumb_img` varchar(255) DEFAULT NULL,
  `post_gallery_img` text DEFAULT NULL,
  `post_price` decimal(10,2) DEFAULT NULL,
  `post_working` varchar(255) DEFAULT NULL,
  `post_seo` varchar(255) DEFAULT NULL,
  `post_meta` text DEFAULT NULL,
  `post_meta_acc` text DEFAULT NULL,
  `views` int NOT NULL DEFAULT 0,
  `temp_data` text DEFAULT NULL,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Структура таблицы `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `id` int unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `description` text DEFAULT NULL,
  `slug` varchar(128) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `seo` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int unsigned NOT NULL,
  `post_title` varchar(128) NOT NULL,
  `post_content` text DEFAULT NULL,
  `post_slug` varchar(128) NOT NULL,
  `post_url` varchar(255) NOT NULL,
  `post_status` varchar(32) NOT NULL DEFAULT 'published',
  `post_author` int NOT NULL,
  `post_term` varchar(128) NOT NULL,
  `post_tags` text DEFAULT NULL,
  `post_thumb_img` varchar(255) DEFAULT NULL,
  `post_gallery_img` text DEFAULT NULL,
  `post_seo` text DEFAULT NULL,
  `post_meta` text DEFAULT NULL,
  `views` int NOT NULL DEFAULT 0,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Структура таблицы `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int unsigned NOT NULL,
  `post_parent` int NOT NULL,
  `post_title` varchar(128) NOT NULL,
  `post_content` text DEFAULT NULL,
  `post_slug` varchar(128) NOT NULL,
  `post_url` varchar(255) NOT NULL,
  `post_status` varchar(32) NOT NULL DEFAULT 'published',
  `post_author` int NOT NULL,
  `post_term` varchar(128) NOT NULL,
  `post_gallery_img` text DEFAULT NULL,
  `post_seo` text DEFAULT NULL,
  `post_meta` text DEFAULT NULL,
  `post_rating` int NOT NULL,
  `views` int NOT NULL DEFAULT 0,
  `post_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Индексы таблицы `glampings`
--
ALTER TABLE `glampings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_date` (`post_date`),
  ADD KEY `post_author` (`post_author`,`post_date`),
  ADD KEY `post_term` (`post_term`,`post_date`);

ALTER TABLE `glampings` ADD FULLTEXT KEY `post_title` (`post_title`,`post_content`);

--
-- Индексы таблицы `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`),
  ADD KEY `date` (`date`),
  ADD KEY `title` (`title`,`date`),
  ADD KEY `slug` (`slug`,`date`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
ADD PRIMARY KEY (`id`),
ADD KEY `post_date` (`post_date`),
ADD KEY `post_author` (`post_author`,`post_date`),
ADD KEY `post_term` (`post_term`,`post_date`);

ALTER TABLE `posts` ADD FULLTEXT KEY `post_title` (`post_title`,`post_content`);

--
-- Индексы таблицы `reviews`
--
ALTER TABLE `reviews`
ADD PRIMARY KEY (`id`),
ADD KEY `post_date` (`post_date`),
ADD KEY `post_parent` (`post_parent`,`post_date`);

--
-- AUTO_INCREMENT для таблицы `glampings`
--
ALTER TABLE `glampings`
    MODIFY `id` int unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE `glampings`
    MODIFY `id` int unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT для таблицы `location`
--
ALTER TABLE `location`
    MODIFY `id` int unsigned NOT NULL AUTO_INCREMENT;

ALTER TABLE `location`
    MODIFY `id` int unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;


--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
    MODIFY `id` int unsigned NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `reviews`
--
ALTER TABLE `reviews`
    MODIFY `id` int unsigned NOT NULL AUTO_INCREMENT;



-----------------------------------------------------------------------
-- Замена текста в поле MySQL

UPDATE your_table
SET your_column = REPLACE(your_column, 'old_text', 'new_text');
