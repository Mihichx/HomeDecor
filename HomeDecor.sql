-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 08 2026 г., 12:53
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
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `name` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `href` varchar(20) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`, `image`, `href`) VALUES
(1, 'ВАЗЫ', 'img/front_catalog1.jpg', 'vases'),
(2, 'СВЕЧИ ВОСКОВЫ', 'img/front_catalog2.jpg', 'wax_candles'),
(3, 'САЛАТНИКИ', 'img/front_catalog3.jpg', 'salad_bowls'),
(4, 'ЗЕРКАЛА', 'img/front_catalog4.jpg', 'mirrors'),
(5, 'КАШПО', 'img/front_catalog5.jpg', 'planters'),
(6, 'ЧАСЫ', 'img/front_catalog6.jpg', 'clocks'),
(7, 'КОМПОЗИЦИИ ИЗ ЦВЕТОВ', 'img/front_catalog7.jpg', 'flower_compositions'),
(8, 'СТАТУЭТКИ', 'img/front_catalog8.jpg', 'figurines'),
(9, 'ШКАТУЛКИ', 'img/front_catalog9.jpg', 'boxes'),
(10, 'ПОДНОСЫ', 'img/front_catalog10.jpg', 'trays'),
(11, 'ТАРЕЛКИ', 'img/front_catalog11.jpg', 'plates'),
(12, 'КОНФЕТНИЦЫ', 'img/front_catalog12.jpg', 'candy_bowls');

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
  `in_menu` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `header_content`, `in_menu`) VALUES
(1, 'index', 'Главная', '<h1> Ура!</h1><p>Мой движок работает через БД!</p></h1>', '<h2>Главная</h2>', 0),
(3, 'aboutus', 'О нас', '<div class=\"container-about\">\r\n\r\n    <!-- Главный блок -->\r\n    <section class=\"hero center\">\r\n        <img src=\"img/about1.jpg\" loading=\"lazy\" alt=\"\">\r\n        <div class=\"hero-text\">\r\n            <p>\r\n            Добро пожаловать в «Дом Деталей» — пространство, где декор перестаёт быть просто дополнением, а становится главным инструментом для создания уюта. Мы созданы для тех, кто верит: дом — это отражение внутреннего мира, и каждая деталь в нём имеет значение.\r\n            </p>\r\n        </div>\r\n    </section>\r\n\r\n    <!-- О компании -->\r\n    <section class=\"about\">\r\n        <h2>О КОМПАНИИ</h2>\r\n        <div class=\"about-content\">\r\n            <img src=\"img/about2.jpg\" loading=\"lazy\" alt=\"\">\r\n            <p>\r\n            «Дом Деталей» был основан в 2020 году командой дизайнеров и энтузиастов, уставших от безликих решений для интерьера. Мы начали с небольшой мастерской по созданию авторских светильников и керамики, а сегодня — это уютное онлайн-пространство уникального декора, который объединяет сотни мастеров из разных уголков мира.\r\n            </p>\r\n        </div>\r\n    </section>\r\n\r\n    <!-- Миссия -->\r\n    <section class=\"mission\">\r\n        <p class=\"mission-title\">Наша миссия - вдохновлять людей наполнять свои дома смыслом и эстетикой без компромиссов</p>\r\n        <div class=\"mission-content\">\r\n            <div class=\"mission-text\">\r\n                <p>\r\n                    Мы хотим доказать, что декор не обязан быть дорогим, чтобы быть красивым, и не обязан быть сложным, чтобы быть эффектным. Наша задача сделать процесс создания уютного интерьера простым, понятным и доступным для каждого, независимо от бюджета или стиля жизни.\r\n                </p>\r\n            </div>\r\n            <img src=\"img/about3.jpg\" loading=\"lazy\" alt=\"\">\r\n        </div>\r\n    </section>\r\n\r\n    <!-- Преимущества -->\r\n    <section class=\"advantages\">\r\n        <h2>НАШИ ПРЕИМУЩЕСТВА</h2>\r\n        <div class=\"advantages-grid\">\r\n            <div class=\"advantage\">1. Только уникальные вещи — в нашем ассортименте нет масс-маркета.</div>\r\n            <div class=\"advantage\">3. Честная гарантия — вы можете вернуть или обменять товар в течение 30 дней.</div>\r\n            <div class=\"advantage\">2. Экологичный подход — мы отдаём предпочтение натуральным материалам.</div>\r\n            <div class=\"advantage\">4. Быстрая доставка по всей стране — отправляем заказы в течение 24 часов.</div>\r\n        </div>\r\n    </section>\r\n\r\n    <!-- Контакты -->\r\n    <section class=\"contacts\">\r\n        <h2>КОНТАКТЫ</h2>\r\n        <p>Мы всегда на связи и открыты к диалогу — будь то вопрос по заказу, предложение сотрудничества или просто идея для нового декора.</p>\r\n        <div class=\"contact-info\">\r\n            <p>Телефон: +7 (999) 123-45-67 (ежедневно, с 10:00 до 21:00 по МСК)</p>\r\n            <p>Email: hello@dom-detali.ru — по вопросам заказов и возвратов</p>\r\n            <p>Email для партнёров: partners@dom-detali.ru — для художников, мастеров и брендов</p>\r\n        </div>\r\n    </section>\r\n\r\n</div>', '<h2>Вдохновение в каждой детали</h2>', 1),
(4, 'footer', '', '<div class=\"footer center column\">\r\n    <div class=\" center row\">\r\n        <h3>ДЕКОР ДЛЯ <br> ДОМА</h3>\r\n        <img src=\"/img/logo.png\" loading = \"lazy\" alt=\"Логотип\" style=\"max-width: 50px; margin: 20px;\">\r\n    </div>\r\n    <p style=\"opacity: 0.6;\">&copy; {{ year }} Декор для дома. Все права защищены.</p>\r\n    <p style=\"opacity: 0.6; margin-top: 20px;\">\r\n        Команда разработчиков: <br>\r\n        Бакулев Михаил <br>\r\n        Сухарева Ангелина <br>\r\n        Рагазина Елена\r\n    </p>\r\n    <div class=\"center row\" style=\"margin-top: 20px;\">\r\n        <a target=\"_blank\" class=\"hover\" href=\"https://web.telegram.org/\"><img class=\"margin15\" src=\"/img/telegram.png\" loading = \"lazy\" alt=\"telegram\" style=\"max-width: 40px;\"></a>\r\n        <a target=\"_blank\" class=\"hover\" href=\"https://www.youtube.com/\"><img class=\"margin15\" src=\"/img/youtube.png\" loading = \"lazy\" alt=\"youtube\" style=\"max-width: 40px;\"></a>\r\n        <a target=\"_blank\" class=\"hover\" href=\"https://vk.com/\"><img class=\"margin15\" src=\"/img/vk.png\" loading = \"lazy\" alt=\"vk\" style=\"max-width: 40px;\"></a>\r\n    </div>\r\n</div>', '', 0),
(5, 'catalog', 'Каталог', '<div class=\"category-item\">\r\n    <a href=\"/catalog/{{ href }}\"><img src=\"{{ image }}\" loading=\"lazy\" alt=\"{{ name }}\">{{ name }}</a>\r\n</div>', '<form method=\"POST\" action=\"\">\r\n    <div class=\"center\" style=\"-webkit-mask-image: -webkit-radial-gradient(white, black); align-items: center; width: 700px; height: 55px; background: white; border: 2px solid #CFCFCF; border-radius: 25rem; padding: 0 20px; overflow: hidden;\">\r\n        <input type=\"text\" placeholder=\"Поиск по товарам...\" style=\"flex: 1; border: none; outline: none; font-size: 18px; background: transparent;\" name=\"search\">\r\n        <button type=\"submit\"><img src=\"/img/search.svg\" loading=\"lazy\" alt=\"Поиск\" style=\"width: 30px; cursor: pointer;\"></button>\r\n    </div>\r\n</form>', 1),
(6, 'header', '', '<nav class=\"center row\">\r\n    {{ menu }}\r\n</nav>\r\n<div class=\"header-content center row space-between\">\r\n    <div class=\"margin-left80\" style=\"width: 211px;\">\r\n        <a class=\"hover center row\" href=\"/index\">\r\n            <h3>ДЕКОР ДЛЯ <br> ДОМА</h3>\r\n            <img src=\"/img/logo.png\" alt=\"Логотип\" style=\"max-width: 50px; margin: 20px;\">\r\n        </a>\r\n    </div>\r\n    \r\n    {{ header_content }}\r\n\r\n    <div class=\"center row margin-right80\" style=\"width: 211px;\">\r\n        <a class=\"{{ basket_class }}\" href=\"/basket\">\r\n            <img class=\"margin15\" src=\"{{ basket_img }}\" alt=\"Корзина\" style=\"max-width: 40px;\">\r\n        </a>\r\n        \r\n        <a class=\"{{ profile_class }}\" href=\"/profile\">\r\n            {{ profile }} \r\n        </a>\r\n    </div>\r\n</div>', '', 0),
(9, 'admin', 'Админпанель', '<div class=\'center column\'>\r\n                <h1 class=\'margin15\'>Админ-панель</h1>\r\n                <form class=\'center margin15 column\' method=\'post\'>\r\n                    {{ $error }}\r\n                    <input class=\'margin5 admin-input\' type=\'login\' name=\'login\' placeholder=\'Логин\' required>\r\n                    <input class=\'margin5 admin-input\' type=\'password\' name=\'password\' placeholder=\'Логин\' required>\r\n                    <button class=\'margin5 admin-button hover\' type=\'submit\' name=\'action\'>Вход</button>\r\n                </form>\r\n            </div>', '<nav class=\"center row\">\r\n    {{ menu }}\r\n</nav>\r\n<div class=\"header-content center \">\r\n        <a class=\"hover center row\" href=\"/admin\">\r\n            <h3>АДМИН ДЛЯ <br> ДОМА</h3>\r\n            <img src=\"/img/logo.png\" loading = \"lazy\" alt=\"Логотип\" style=\"max-width: 50px; margin: 20px;\">\r\n        </a>\r\n</div>', 2),
(10, 'reviews', 'Отзывы', '<div class=\"container-reviews\">\r\n\r\n    <section class=\"top-text\">\r\n        <p>Делитесь впечатлениями и читайте, что думают другие о магазине «Дом Деталей»!</p>\r\n    </section>\r\n\r\n    <!-- Отзывы -->\r\n    <section class=\"reviews\">\r\n        <div class=\"review-card\">\r\n            <img src=\"img/acc1.jpg\" loading=\"lazy\" alt=\"\">\r\n            <div class=\"review-content\">\r\n                <div class=\"review-top\">\r\n                    <span class=\"stars\">★★★★★</span>\r\n                    <span class=\"date\">15 апреля 2026</span>\r\n                </div>\r\n                <h3>Анна С.</h3>\r\n                <p>«Заказывала вазу и свечи — всё пришло целым, упаковано с любовью. Даже бонусный магнитик положили! Теперь только к вам.»</p>\r\n            </div>\r\n        </div>\r\n\r\n        <div class=\"review-card\">\r\n            <img src=\"img/acc2.jpg\" loading=\"lazy\" alt=\"\">\r\n            <div class=\"review-content\">\r\n                <div class=\"review-top\">\r\n                    <span class=\"stars\">★★★★★</span>\r\n                    <span class=\"date\">9 февраля 2026</span>\r\n                </div>\r\n                <h3>Екатерина К.</h3>\r\n                <p>«Отличный магазин! Быстрая доставка в Ижевск за 4 дня. Плед купила — очень мягкий, как на фото. Спасибо!»</p>\r\n            </div>\r\n        </div>\r\n\r\n        <div class=\"review-card\">\r\n            <img src=\"img/acc3.jpg\" loading=\"lazy\" alt=\"\">\r\n            <div class=\"review-content\">\r\n                <div class=\"review-top\">\r\n                    <span class=\"stars\">★★★★☆</span>\r\n                    <span class=\"date\">2 мая 2026</span>\r\n                </div>\r\n                <h3>Дмитрий В.</h3>\r\n                <p>«Хороший выбор декора, цены приятные. Единственное — свеча пахла не так ярко, как ожидал. Но в целом довольна.»</p>\r\n            </div>\r\n        </div>\r\n    </section>\r\n\r\n    <!-- Форма -->\r\n    <section class=\"form-section\">\r\n        <h2>Оставить свой отзыв</h2>\r\n        <form class=\"review-form\">\r\n            <input type=\"text\" placeholder=\"Имя\">\r\n            <select>\r\n                <option>Оценка</option>\r\n                <option>★★★★★</option>\r\n                <option>★★★★</option>\r\n                <option>★★★</option>\r\n                <option>★★</option>\r\n                <option>★</option>\r\n            </select>\r\n            <textarea placeholder=\"Ваш отзыв\"></textarea>\r\n            <button type=\"submit\">отправить</button>\r\n        </form>\r\n    </section>\r\n\r\n</div>', '<h2>Отзывы наших покупателей</h2>', 1),
(11, 'сontacts', 'Контакты', '', '<h2>Свяжитесь с нами!</h2>', 1),
(12, 'stock', 'Акции', '', '<h2>Найди своё</h2>', 1),
(13, 'basket', 'Корзина', '', '<h2>В корзине {{  value }}</h2>', 0),
(14, 'profile', 'Личный кабинет', '<form method=\"POST\">\r\n    <input type=\"hidden\" name=\"logout\" value=\"1\">\r\n    <button class=\"admin-button hover\" type=\"submit\">Выйти</button>\r\n</form>', '<h2>Ваш личный кабинет</h2>', 0),
(15, 'goods', 'Товары', '', '', 2),
(16, 'reviews1', 'Отзывы', '', '', 2),
(17, 'users', 'Пользователи', '', '', 2),
(18, 'statistics', 'Статистика', '', '', 2),
(19, 'add', 'Добавить', '', '', 3),
(20, 'edit', 'Редактировать', '', '', 3),
(21, 'registration', 'Регистрация', '<div class=\'center column\'>\r\n    <h1 class=\'margin15\'>Регистрация</h1>\r\n    <form class=\'center margin15 column\' method=\"POST\">\r\n        {{ $error }}\r\n        <input type=\"hidden\" name=\"registration\">\r\n        <input class=\'margin5 admin-input\' type=\'login\' name=\'login1\' placeholder=\'Логин\' required>\r\n        <input class=\'margin5 admin-input\' type=\'password\' name=\'password1\' placeholder=\'Пароль\' required>\r\n        <input class=\'margin5 admin-input\' type=\'password\' name=\'password_repeat\' placeholder=\'Повторите пароль\' required>\r\n        <button class=\'margin5 admin-button hover\' type=\'submit\' name=\'action\'>Регистрация</button>\r\n    </form>\r\n    <a href=\"/profile\">Назад</a>\r\n</div>', '', 0),
(22, 'entrance', 'Вход', '<div class=\'center column\'>\r\n    <h1 class=\'margin15\'>Вход</h1>\r\n    <form class=\'center margin15 column\' method=\'POST\'>\r\n        {{ $error }}\r\n        <input class=\'margin5 admin-input\' type=\'login\' name=\'login\' placeholder=\'Логин\' required>\r\n        <input class=\'margin5 admin-input\' type=\'password\' name=\'password\' placeholder=\'Пароль\' required>\r\n        <button class=\'margin5 admin-button hover\' type=\'submit\' name=\'action\'>Вход</button>\r\n    </form>\r\n    <form method=\"POST\">\r\n        <input type=\"hidden\" name=\"registration\">\r\n        <button class=\"admin-button hover\" type=\"submit\">Регистрация</button>\r\n    </form>\r\n</div>', '', 0),
(23, 'card_product', '', '<div class=\"vase-card\">\r\n    <img src=\"{{ image }}\" loading=\"lazy\" alt=\"Ваза\">\r\n    <div class=\"center column\">\r\n        <p class=\"vase-name\">{{ name }}</p>\r\n        <p class=\"vase-prise\">{{ price }}</p>\r\n        <button class=\"vase-btn\">Добавить</button>\r\n    </div>\r\n</div>', '', 0),
(24, 'detailed_card_product', '', '<img src=\'{{ image }}\' style=\'max-width: 200px;\'>\r\n<h2>{{ name }}</h2>\r\n<p><b>Цена:</b> {{ price }} руб.</p>\r\n<p>{{ more_description }}</p>', '', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `price` int NOT NULL,
  `image` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `more_description` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `price`, `image`, `description`, `more_description`) VALUES
(1, 1, 'Ваза из прозрачного стекла 15 см', 810, 'img/vase1.jpg', '', ''),
(2, 1, 'Ваза из прозрачного стекла 11 см', 1180, 'img/vase2.jpg', '', ''),
(3, 1, 'Ваза из прозрачного стекла 24 см', 3800, 'img/vase3.jpg', '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `key_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `value` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `login` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `role` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `date_regist` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `role`, `date_regist`) VALUES
(6, 'Михаил', '$2y$10$C84D6HMHwBefgBGMvO6DfeSKYRCKmKj23INbYc24lCnuX9iS4jnUO', 'admin', '2026-05-07'),
(8, 'Миша', '$2y$10$wiKMoz0dzklb0iZPZw.vZOEm38CbBDUUyb9AM79qfywPlcJWlBgUW', 'moderator', '2026-05-07'),
(9, 'Миш', '$2y$10$pdwKm/mno1UGxU63NZD/SeLeZNkd.DAiPPVIVOZHFTPJlrITsmGOO', 'user', '2026-05-07');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `slug_2` (`slug`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `name_2` (`name`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
