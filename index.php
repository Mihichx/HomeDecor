<?
    session_start();
    $pdo = require_once 'connect.php';                       // Подключаемся к базе данных (в файле connect.php создается переменная $link с соединением)
    $url = urldecode($_SERVER['REQUEST_URI']);              // Страница на которой зашли (например, /contact)
    
    $slug = trim($url, '/');  // Убираем слеши в начале и в конце
    $params = explode('/', $slug);  // Разбиваем строку по слешам, чтобы получить массив параметров

    ob_start();
    include './template/layout.php';
    $layout = ob_get_clean();  // Загружаем макет страницы (в нашем случае template/layout.php)


    // Достаем шапку
    $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = :slug");
    $stmt->execute([':slug' => 'header']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $header = $row['content'];


    if ($params[0] == '') {
        $slug = 'index';
        include './scripts/page.php';
    } elseif ($params[0] == 'catalog') {
        include './scripts/catalog.php';
    } elseif ($params[0] == 'admin') {
        include './scripts/admin.php';
    } elseif ($params[0] == 'profile') {
        include './scripts/profile.php';
    } else {
        $slug = $params[0];
        include './scripts/page.php';
    }


    // Достаем страницы для меню
    if ($params[0] == "admin" && $params[1] != "goods") {
        $stmt = $pdo->query("SELECT slug, title FROM pages WHERE in_menu = 2 AND slug != 'admin'");
    } elseif ($params[1] == "goods") {
        $stmt = $pdo->query("SELECT slug, title FROM pages WHERE in_menu = 3");
    } else {
        $stmt = $pdo->query("SELECT slug, title FROM pages WHERE in_menu = 1");
    }
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $menu_html = '<ul class="center row">';
    foreach ($rows as $row) {
        $path = htmlspecialchars($row['slug']);
        if ($params[0] == 'admin' && $params[1] != 'goods') {
            $path = '/admin/' . $path;
        }
        if ($params[1] == 'goods') {
            $path = '/admin/goods/' . $path;
        }
        $active = ($row['slug'] == $params[0] || $row['slug'] == $params[1] || $row['slug'] == $params[2]) ? 'active-link' : '';
        if (!empty($active)) {
            $menu_html .= "<li><a class='$active' style='color: black;'>" . htmlspecialchars($row['title']) . "</a></li>";
        } else {
            $menu_html .= "<li><a href='$path' class='hover' style='color: black;'>" . htmlspecialchars($row['title']) . "</a></li>";
        }
    }
    $menu_html .= '</ul>';


    // Достаем футер
    if ($params[0] != "admin") {
        $stmt = $pdo->prepare("SELECT content FROM pages WHERE slug = :slug");
        $stmt->execute([':slug' => 'footer']);
        $footer = $stmt->fetch(PDO::FETCH_ASSOC);
        $footer_content = $footer['content'];
        $footer_content = str_replace('{{ year }}', date("Y"), $footer_content);  // Заменяем в макете {{ year }} на текущий год
    }

    $basket_class  = ($slug == 'basket') ? 'hover center active-icon' : 'hover center';
    $basket_img     = ($slug == 'basket') ? './img/basket-b.png' : '../img/basket.png';
    $profile_class = ($slug == 'profile') ? 'hover center active-icon' : 'hover center';
    $profile_img    = ($slug == 'profile') ? './img/profile-b.png' : '../img/profile.png';

    $header = str_replace('{{ basket_class }}', $basket_class, $header);
    $header = str_replace('{{ basket_img }}', $basket_img, $header);
    $header = str_replace('{{ profile_class }}', $profile_class, $header);
    $header = str_replace('{{ profile_img }}', $profile_img, $header);
    $header = str_replace('{{ header_content }}', $header_content, $header);
    $header = str_replace('{{ menu }}', $menu_html, $header);

    $layout = str_replace('{{ title }}', $title, $layout);            // Заменяем в макете {{ title }} на заголовок страницы
    $layout = str_replace('{{ header }}', $header, $layout);  // Заменяем в макете {{ header }} на содержимое шапки
    $layout = str_replace('{{ content }}', $content, $layout);        // Заменяем в макете {{ content }} на содержимое страницы
    $layout = str_replace('{{ footer }}', $footer_content, $layout);  // Заменяем в макете {{ footer }} на футер

    echo $layout;
?>