<?
    $error = "";
    $title = 'Админпанель';
    $header = '';
    
    // Получаем данные шаблона
    $stmt_tpl = $pdo->prepare("SELECT content, header_content FROM pages WHERE slug = :slug");
    $stmt_tpl->execute([':slug' => 'admin']);
    $page_data = $stmt_tpl->fetch(PDO::FETCH_ASSOC);

    $expectation = 'admin';
    include './scripts/entrance.php';

    if (isset($_SESSION['admin_id'])) {
        $header = $page_data['header_content'];
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
        $content = $page_data['content'];
        $error_html = !empty($error) ? "<p style='color: red;'>$error</p>" : "";
        $content = str_replace('{{ $error }}', $error_html, $content);
    }
?>
