<? 
    $error = '';
    $expectation = 'user';

    // Получаем данные шаблона
    if (isset($_POST['registration'])) {
        $page = getPageBySlug($pdo, 'registration');
        $title = 'Регистрация';
    } else {
        $page = getPageBySlug($pdo, 'entrance');
        $title = 'Вход';
    }

    include './scripts/entrance.php';

    if (isset($_SESSION['user_id'])) {
        $page = getPageBySlug($pdo, 'profile');
        $content = $page['content'];
        $header_content = $page['header_content'];
    } else {
        $content = $page['content'];
        $error_html = !empty($error) ? "<p style='color: red;'>$error</p>" : "";
        $content = str_replace('{{ $error }}', $error_html, $content);
    }
?>