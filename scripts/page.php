<?
    $page = getPageBySlug($pdo, $slug);          

    if ($page && $page['in_menu'] === 1 || ($page['in_menu'] === 2 && $params[0] == 'admin') || $slug === 'index') {
        $title = $page['title'];
        $header_content = $page['header_content'];
        $content = $page['content'];
    } else {
        $code_error = '404';
        header("HTTP/1.1 $code_error Not Found");
        $error = "Запрашиваемая страница не найдена";
        $title = "Страница не найдена";
        include './template/error.php';
        return;
    }

    if (isset($_POST['send_review'])) {
        $response = ['status' => '', 'color' => 'red'];

        if (isset($_SESSION['user']['login'])) {
            $name = trim($_POST['rev_name']);
            $rating = $_POST['rev_rating'];
            $text = trim($_POST['rev_text']);

            if (!empty($name) && !empty($text)) {
                addReview($pdo, $name, $rating, $text);
                $response = ['status' => "Спасибо за отзыв!", 'color' => "green"];
            } else {
                $response['status'] = "Заполните все поля!";
            }
        } else {
            $response['status'] = "Сначала авторизуйтесь";
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($response); 
            exit; 
        }
    }
    
    $login_val = $_SESSION['user']['login'] ?? '';
    $content = str_replace('{{ login }}', $login_val, $content ?? '');
?>