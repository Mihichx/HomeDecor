<?
    $page = getPageBySlug($pdo, $slug);             

    if ($page && $page['slug'] !== 'footer') {
        $title = $page['title'];
        $content = $page['content'];
        $header_content = $page['header_content'];
    } else {
        header('HTTP/1.0 404 Not Found');
        $error = "Запрашиваемая страница не найдена";
        $title = 'Страница не найдена';
        include './template/404.php';
    }
?>