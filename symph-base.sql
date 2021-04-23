-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Апр 23 2021 г., 14:07
-- Версия сервера: 8.0.19
-- Версия PHP: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `symph-base`
--

-- --------------------------------------------------------

--
-- Структура таблицы `authors`
--

CREATE TABLE `authors` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `authors`
--

INSERT INTO `authors` (`id`, `name`, `surname`) VALUES
(1, 'Дмитрий', 'Котеров'),
(2, 'Стивен', 'Кинг'),
(3, 'Джон', 'Толкин'),
(4, 'Борис', 'Бажанов');

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `author_id` int DEFAULT NULL,
  `book_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `book_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `author_id`, `book_name`, `book_date`) VALUES
(5, 1, 'PHP7 в подлиннике', '2016'),
(7, 3, 'Властелин колец', '1978'),
(9, 4, 'Я был секретарем Сталина', '1980'),
(12, 2, 'Мизери', '1971'),
(13, 2, 'Оно', '1977');

-- --------------------------------------------------------

--
-- Структура таблицы `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20210421131500', '2021-04-21 13:15:05'),
('20210422064836', '2021-04-22 06:48:44'),
('20210422084613', '2021-04-22 08:46:20'),
('20210422085455', '2021-04-22 08:54:59'),
('20210422085751', '2021-04-22 08:57:58'),
('20210422090112', '2021-04-22 09:01:17'),
('20210422093823', '2021-04-22 09:38:27'),
('20210422094105', '2021-04-22 09:41:08'),
('20210422100921', '2021-04-22 10:09:29'),
('20210422104343', '2021-04-22 10:43:48'),
('20210422104659', '2021-04-22 10:47:04'),
('20210422105934', '2021-04-22 10:59:38'),
('20210423064123', '2021-04-23 06:41:30'),
('20210423064527', '2021-04-23 06:45:40'),
('20210423064640', '2021-04-23 06:46:46'),
('20210423064834', '2021-04-23 06:48:39'),
('20210423065225', '2021-04-23 06:52:32'),
('20210423065545', '2021-04-23 06:55:50'),
('20210423065831', '2021-04-23 06:58:35'),
('20210423070005', '2021-04-23 07:00:09'),
('20210423070347', '2021-04-23 07:03:52'),
('20210423071057', '2021-04-23 07:11:02'),
('20210423072309', '2021-04-23 07:23:15');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_4A1B2A92F675F31B` (`author_id`);

--
-- Индексы таблицы `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `FK_4A1B2A92F675F31B` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
