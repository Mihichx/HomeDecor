<?
    $page = getPageBySlug($pdo, 'admin');
    $title = 'Админ-панель';
    $header = '';
    $content = '';

    $redirect_url = "/admin"; 
    include './scripts/entrance.php';

    if (isset($_SESSION['user']['id'])) {
        if ($_SESSION['user']['role'] === 'admin') {
            $header = $page['header_content'];
            if (!empty($params[1])) {
                $slug = $params[1];
                include './scripts/page.php';
            } else {
                $content .= '<h1>Добро пожаловать, ' . htmlspecialchars($_SESSION['user']['login']) . '!</h1>';
                $content .= '
                    <form method="POST">
                        <input type="hidden" name="logout" value="1">
                        <button class="admin-button hover" type="submit">Выйти</button>
                    </form>
                ';
            }
        } else {
            $code_error = '403';
            header("HTTP/1.1 $code_error Forbidden");
            $error = 'У вас нет прав';
            $title = 'Доступ запрещен';
            include './template/error.php';
            return;
        }
    } else {
        $content .= $page['content']; 
    }

    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        
        $out = [
            'status'   => $status ?? '',
            'color'    => $color_status ?? '',
            'redirect' => $redirect_url
        ];

        echo json_encode($out);
        exit;
    }
?>
