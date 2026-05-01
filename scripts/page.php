<?
    $smt = $pdo->prepare("SELECT * FROM pages WHERE slug=:slug");  // Готовим SQL запрос, чтобы найти страницу с таким slug
    $smt->execute([':slug' => $slug]);                            // Выполняем запрос, передавая параметр slug
    $page = $smt->fetch(PDO::FETCH_ASSOC);                       // Получаем страницу

    if ($page && $page['slug'] !== 'footer') {
        $title = htmlspecialchars($page['title']);
        $content = htmlspecialchars($page['content']);
    } else {
        header('HTTP/1.0 404 Not Found');
        $error = "Запрашиваемая страница не найдена";
        $title = 'Страница не найдена';
        include './template/404.php';
    }
?>