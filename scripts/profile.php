<?php 
    $redirect_url = "/profile"; 
    include './scripts/entrance.php'; // Логика логина/регистрации (там уже должны быть $status и $color_status)
    
    // ЛОГИКА ОБНОВЛЕНИЯ
    if (isset($_POST['update_profile']) && isset($_SESSION['user']['id'])) {
        $user_id = $_SESSION['user']['id'];
        
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
        $stmt->execute([':id' => $user_id]);
        $current_db_user = $stmt->fetch();

        if ($current_db_user && password_verify($_POST['old_password'], $current_db_user['password'])) {
            $newData = [
                'login'    => trim($_POST['login']),
                'email'    => trim($_POST['email']),
                'password' => $_POST['new_password']
            ];

            if (updateUser($pdo, $user_id, $newData)) {
                $_SESSION['user']['login'] = $newData['login'];
                $_SESSION['user']['email'] = $newData['email'];
                $color_status = "green";
            } else {
                $status = "Ошибка при обновлении!";
            }
        } else {
            $status = "Старый пароль введен неверно!";
        }
    }

    // --- AJAX ОТВЕТ ---
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        header('Content-Type: application/json');
        
        $out = [
            'status' => $status ?? '',
            'color'  => $color_status ?? ''
        ];

        if (isset($color_status) && $color_status === 'green') {  // Редиректим когда авторизовались 
            $out['redirect'] = $redirect_url;
        }

        echo json_encode($out);
        exit;
    }

    // ОПРЕДЕЛЯЕМ, КАКУЮ СТРАНИЦУ ПОКАЗАТЬ
    if (isset($_SESSION['user']['id'])) {
        // Логика для наших !
        if (isset($params[1]) && $params[1] === 'settings') {
            $page = getPageBySlug($pdo, 'settings');
            $title = "Настройки профиля";
        } else {
            $page = getPageBySlug($pdo, 'profile');
            $title = "Мой профиль";
        }
        $content = $page['content'];

        $content = str_replace('{{ login }}', htmlspecialchars($_SESSION['user']['login']), $content);
        $content = str_replace('{{ email }}', htmlspecialchars($_SESSION['user']['email']), $content);
    } else {
        // Логика для гостей
        $pageSlug = isset($_POST['registration']) ? 'registration' : 'entrance';
        $page = getPageBySlug($pdo, $pageSlug);
        $title = ($pageSlug === 'registration') ? "Регистрация" : "Вход";
        $content = $page['content'];
    }
?>