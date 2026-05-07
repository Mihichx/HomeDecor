<?
    $error = '';
    $title = 'Админ-панель';
    $header = '';
    
    // Получаем данные шаблона
    $page = getPageBySlug($pdo, 'admin');

    include './scripts/entrance.php';

    if (isset($_SESSION['user_id'])) {
        if ($_SESSION['user_role'] == 'admin') {
            $header = $page['header_content'];
            if (!empty($params[1])) {
                $slug = $params[1];
                include './scripts/page.php';
            } else {
                $content = '<h1>Добро пожаловать, ' . htmlspecialchars($_SESSION['admin_login']) . '!</h1>';
                $content .= '
                    <form method="POST">
                        <input type="hidden" name="logout" value="1">
                        <button class="admin-button hover" type="submit">Выйти</button>
                    </form>
                ';
            }
        } else {
            $content = "<p style='color: red;'>У вас нет прав администратора</p>";
        }
    } else {
        $content = $page['content']; 
    }

    $error_html = !empty($error) ? "<p style='color: red;'>$error</p>" : "";
    $content = str_replace('{{ $error }}', $error_html, $content ?? '');
?>
