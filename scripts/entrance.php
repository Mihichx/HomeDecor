<?  
    // Логика выхода
    if (isset($_POST['logout'])) {
        session_unset();
        $redirect_url = "/index"; 
        $color_status = "green";
        
        if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header("Location: /index"); 
            exit;
        }
    }

    // Обработка форм
    if (isset($_POST['login'], $_POST['password']) || isset($_POST['login1'], $_POST['password1'], $_POST['password_repeat'])) {
        if (isset($_POST['login'], $_POST['password'])) {
            $user = loginUser($pdo, $_POST['login'], $_POST['password']);

            if ($user) {
                $_SESSION['user'] = [
                    'id'    => $user['id'],
                    'role'  => $user['role'],
                    'login' => $user['login'],
                    'email' => $user['email'],
                    'basket'=> []
                ];
                $color_status = "green"; 
                $status = "Успешный вход!";
            } else {  
                $status = "Неверные данные";
            }
        }
    
        if (isset($_POST['login1'], $_POST['e-mail1'], $_POST['password1'], $_POST['password_repeat'])) {
            $status = registrationUser($pdo, $_POST['login1'], $_POST['e-mail1'], $_POST['password1'], $_POST['password_repeat']);
            $color_status = (($status === "Регистрация прошла успешно") !== false) ? "green" : "red";
        }
    }
?>