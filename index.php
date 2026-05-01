<?
    $pdo = require_once 'connect.php';                       // Подключаемся к базе данных (в файле connect.php создается переменная $link с соединением)
    $url = urldecode($_SERVER['REQUEST_URI']);              // Страница на которой зашли (например, /contact)
    $layout = file_get_contents('./template/layout.php');  // Загружаем макет страницы (в нашем случае template/layout.php)
    
    $slug = trim($url, '/');  // Убираем слеши в начале и в конце
    $params = explode('/', $slug);  // Разбиваем строку по слешам, чтобы получить массив параметров

    // Достаем страницы для меню
    $stmt = $pdo->query("SELECT slug, title FROM pages WHERE in_menu=1");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $menu_html = '<ul class="center row">';
    foreach ($rows as $row) {
        $path = htmlspecialchars($row['slug']);
        $menu_html .= "<li><a href='/$path'>" . htmlspecialchars($row['title']) . "</a></li>";
    }
    $menu_html .= '</ul>';

    
    if ($params[0] == '') {
        $slug = 'index';
        include './scripts/page.php';
    } elseif ($params[0] == 'catalog') {
        include './scripts/catalog.php';
    } elseif ($params[0] == 'admin') {
        include './scripts/admin.php';
    } else {
        $slug = $params[0];
        include './scripts/page.php';
    }


    // Достаем футер
    $stmt = $pdo->prepare("SELECT content FROM pages WHERE slug = :slug");
    $stmt->execute([':slug' => 'footer']);
    $footer = $stmt->fetch(PDO::FETCH_ASSOC);
    $footer_content = htmlspecialchars($footer['content']);


    $layout = str_replace('{{ title }}', $title, $layout);            // Заменяем в макете {{ title }} на заголовок страницы
    $layout = str_replace('{{ menu }}', $menu_html, $layout);         // Заменяем в макете {{ menu }} на HTML код меню
    $layout = str_replace('{{ content }}', $content, $layout);        // Заменяем в макете {{ content }} на содержимое страницы
    $layout = str_replace('{{ footer }}', $footer_content, $layout);  // Заменяем в макете {{ footer }} на футер
    $layout = str_replace('{{ year }}', date("Y"), $layout);          // Заменяем в макете {{ year }} на текущий год

    echo $layout;
?>