<? 
    $error = "";
    $title = 'Вход';

    // Получаем данные шаблона
    if (isset($_POST['registration'])) {
        $stmt_tpl = $pdo->prepare("SELECT content, header_content FROM pages WHERE slug = :slug");
        $stmt_tpl->execute([':slug' => 'registration']);
    } else {
        $stmt_tpl = $pdo->prepare("SELECT content, header_content FROM pages WHERE slug = :slug");
        $stmt_tpl->execute([':slug' => 'entrance']);
    }
    $page_data = $stmt_tpl->fetch(PDO::FETCH_ASSOC);

    $expectation = 'user';
    include './scripts/entrance.php';

    if (isset($_POST['login1'])) {
        if ($row1) {
            $error = 'Такой пользователь уже есть';
        }
    }

    if (isset($_SESSION['user_id'])) {
        $header = $page_data['header_content'];
        $stmt_tpl = $pdo->prepare("SELECT content, header_content FROM pages WHERE slug = :slug");
        $stmt_tpl->execute([':slug' => 'profile']);
        $page_data = $stmt_tpl->fetch(PDO::FETCH_ASSOC);
        $content = $page_data['content'];
    } else {
        $content = $page_data['content'];
        $error_html = !empty($error) ? "<p style='color: red;'>$error</p>" : "";
        $content = str_replace('{{ $error }}', $error_html, $content);
    }
?>