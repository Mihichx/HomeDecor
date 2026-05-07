<?  
    // Логика выхода
    if (isset($_POST['logout'])) {
        session_unset();
        header("Location: /index");
        exit;
    }

    // Обработка форм
    if (isset($_POST['login'], $_POST['password']) || isset($_POST['login1'], $_POST['password1'], $_POST['password_repeat'])) {
        if (isset($_POST['login'], $_POST['password'])) {
            $user = loginUser($pdo, $_POST['login'], $_POST['password']);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user_login'] = $user['login'];
                
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit;
            } else {  
                $error = "Неверные данные";
            }
        }
        if (isset($_POST['login1'], $_POST['password1'], $_POST['password_repeat'])) {
            if (examinationUser($pdo, $_POST['login1'])) {
                $error = 'Такой пользователь уже есть';
            } else {
                if ($_POST['password1'] === $_POST['password_repeat']) {
                    registrationUser($pdo, $_POST['login1'], $_POST['password1'], $_POST['password_repeat']);
                    header("Location: " . $_SERVER['REQUEST_URI']);
                    exit;
                } else {
                    $error = 'Пароли не совпадают';
                }
            }
        }
    }
?>