<?
    require_once 'connect.php';                            // Подключаемся к базе данных (в файле connect.php создается переменная $link с соединением)
    $url = $_SERVER['REQUEST_URI'];                       // Страница на которой зашли (например, /contact)
    $layout = file_get_contents('template/layout.php');  // 1. Загружаем макет страницы (в нашем случае template/layout.php)


    $slug = trim($url, '/');  // Убираем слеши в начале и в конце (например, contact)
    if ($slug == '') $slug = 'index';  // Если ничего не указано, то это index'
    $slug = mysqli_real_escape_string($link, $slug);  // Экранируем строку, чтобы избежать SQL инъекций


    // Делаем запрос к базе данных, чтобы найти страницу с таким slug
    $query = "SELECT * FROM pages WHERE slug='$slug'";  // Делаем запрос к базе данных, чтобы найти страницу с таким slug
    $res = mysqli_query($link, $query);  // Выполняем запрос и получаем результат
    $page = mysqli_fetch_assoc($res);  // Получаем страницу в виде ассоциативного массива (например, ['id' => 1, 'slug' => 'contact', 'title' => 'Контакты', 'content' => '...'])

    if ($page && $page['slug'] !== 'footer') {
        $title = $page['title'];
        $content = $page['content'];
    } else {
        header('HTTP/1.0 404 Not Found');  // Отправляем заголовок 404, чтобы браузер понимал, что страница не найдена
        $title = 'Страница не найдена';
        $content = "
            <div style='text-align: center;'>
                <h1 style='color: #e74c3c;'>Ошибка: 404</h1>
                <p style='color: #7f8c8d;'>Запрашиваемая страница не найдена</p>
            </div>
        ";
    }


    // Достаем страницы для меню
    $menu_query = "SELECT slug, title FROM pages WHERE in_menu=1";
    $menu_res = mysqli_query($link, $menu_query);
    $menu_html = '<ul class="center row">';
    while ($row = mysqli_fetch_assoc($menu_res)) {
        $path = ($row['slug'] == 'index') ? '/index' : '/' . $row['slug'];
        $menu_html .= "<li><a href='$path'>{$row['title']}</a></li>";
    }
    $menu_html .= '</ul>';


    // Достаем футер
    $footer_query = "SELECT content FROM pages WHERE slug='footer'";
    $footer_res = mysqli_query($link, $footer_query);  // Выполняем запрос и получаем результат
    $footer = mysqli_fetch_assoc($footer_res);
    $footer_content = $footer['content'] . '<p><?= date("Y") ?></p>';


    $layout = str_replace('{{ title }}', $title, $layout);              // Заменяем в макете {{ title }} на заголовок страницы
    $layout = str_replace('{{ menu }}', $menu_html, $layout);           // Заменяем в макете {{ menu }} на HTML код меню
    $layout = str_replace('{{ content }}', $content, $layout);          // Заменяем в макете {{ content }} на содержимое страницы
    $layout = str_replace('{{ footer }}', $footer_content, $layout);    // Заменяем в макете {{ footer }} на футер
    $layout = str_replace('{{ year }}', date("Y"), $layout);            // Заменяем в макете {{ year }} на текущий год

    echo $layout;
?>