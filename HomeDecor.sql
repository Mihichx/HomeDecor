-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 05 2026 г., 15:28
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `HomeDecor`
--

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `slug` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `header_content` text COLLATE utf8mb4_general_ci NOT NULL,
  `in_menu` tinyint NOT NULL,
  `category` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `header_content`, `in_menu`, `category`) VALUES
(1, 'index', 'Главная', '<h1>Ура!</h1><p>Мой движок работает через БД!</p>', '<h2>Главная</h2>', 0, ''),
(3, 'aboutus', 'О нас', '<h1>Привет мы крутая компания !</h1>', '', 1, ''),
(4, 'footer', '', '<div class=\"footer center column\">\r\n				<div class=\" center row\">\r\n					<h3>ДЕКОР ДЛЯ <br> ДОМА</h3>\r\n					<img src=\"/img/logo.png\" alt=\"Логотип\" style=\"max-width: 50px; margin: 20px;\">\r\n				</div>\r\n				<p style=\"opacity: 0.6;\">&copy; {{ year }} Декор для дома. Все права защищены.</p>\r\n				<p style=\"opacity: 0.6; margin-top: 20px;\">\r\n					Команда разработчиков: <br>\r\n					Бакулев Михаил <br>\r\n					Сухарева Ангелина <br>\r\n					Рагазина Елена\r\n				</p>\r\n				<div class=\"center row\" style=\"margin-top: 20px;\">\r\n					<a target=\"_blank\" class=\"hover\" href=\"https://web.telegram.org/\"><img class=\"margin15\" src=\"/img/telegram.png\" alt=\"Логотип\" style=\"max-width: 40px;\"></a>\r\n					<a target=\"_blank\" class=\"hover\" href=\"https://www.youtube.com/\"><img class=\"margin15\" src=\"/img/youtube.png\" alt=\"Логотип\" style=\"max-width: 40px;\"></a>\r\n					<a target=\"_blank\" class=\"hover\" href=\"https://vk.com/\"><img class=\"margin15\" src=\"/img/vk.png\" alt=\"Логотип\" style=\"max-width: 40px;\"></a>\r\n				</div>\r\n			</div>', '', 0, ''),
(5, 'catalog', 'Каталог', '', '<div class=\"center\" style=\"-webkit-mask-image: -webkit-radial-gradient(white, black); align-items: center; width: 700px; height: 55px; background: white; border: 2px solid #CFCFCF; border-radius: 25rem; padding: 0 20px; overflow: hidden;\">\r\n                <input type=\"text\" placeholder=\"Поиск по товарам...\" style=\"flex: 1; border: none; outline: none; font-size: 18px; background: transparent;\">\r\n                <img src=\"/img/search.svg\" alt=\"Поиск\" style=\"width: 30px; cursor: pointer;\">\r\n            </div>', 1, ''),
(6, 'header', '', '<nav class=\"center row\">\r\n    {{ menu }}\r\n</nav>\r\n<div class=\"header-content center row space-between\">\r\n    <div class=\"margin-left80\" style=\"width: 211px;\">\r\n        <a class=\"hover center row\" href=\"/index\">\r\n            <h3>ДЕКОР ДЛЯ <br> ДОМА</h3>\r\n            <img src=\"/img/logo.png\" alt=\"Логотип\" style=\"max-width: 50px; margin: 20px;\">\r\n        </a>\r\n    </div>\r\n    \r\n    {{ header_content }}\r\n\r\n    <div class=\"center row margin-right80\" style=\"width: 211px;\">\r\n        <a class=\"{{ basket_class }}\" href=\"/basket\">\r\n            <img class=\"margin15\" src=\"{{ basket_img }}\" alt=\"Корзина\" style=\"max-width: 40px;\">\r\n        </a>\r\n        \r\n        <a class=\"{{ profile_class }}\" href=\"/profile\">\r\n            <img class=\"margin15\" src=\"{{ profile_img }}\" alt=\"Профиль\" style=\"max-width: 40px;\">\r\n        </a>\r\n    </div>\r\n</div>', '', 0, ''),
(9, 'admin', 'Админпанель', '', '<nav class=\"center row\">\r\n    {{ menu }}\r\n</nav>\r\n<div class=\"header-content center \">\r\n        <a class=\"hover center row\" href=\"/index\">\r\n            <h3>ДЕКОР ДЛЯ <br> ДОМА</h3>\r\n            <img src=\"/img/logo.png\" alt=\"Логотип\" style=\"max-width: 50px; margin: 20px;\">\r\n        </a>\r\n</div>', 0, 'admin'),
(10, 'reviews', 'Отзывы', '', '', 1, ''),
(11, 'сontacts', 'Контакты', '', '', 1, ''),
(12, 'stock', 'Акции', '', '', 1, ''),
(13, 'basket', 'Корзина', '', '', 0, ''),
(14, 'profile', 'Личный кабинет', '', '', 0, '');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `price` varchar(8) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `price`, `image`, `description`) VALUES
(1, 'Овощи', 'Огурец', '10 руб.', '', 'Очень вкусный огурец');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `key_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `value` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
