<?  
    // Логика выхода
    if (isset($_POST['logout'])) {
        session_unset();
        header("Location: /index");
        exit;
    }

    // Обработка формы входа
    if (isset($_POST['login'], $_POST['password']) || isset($_POST['login1'])) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login AND password = :password");
        $stmt->execute([':login' => $_POST['login'], ':password' => $_POST['password']]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt1 = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt1->execute([':login' => $_POST['login1']]);
        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
        if (isset($_POST['login1'])) return;

        if ($row && $row['role'] == 'admin' && $row['role'] == $expectation) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_login'] = $row['login'];
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        } elseif ($row && $row['role'] == 'moderator' && $row['role'] == $expectation) {
            $_SESSION['moderator_id'] = $row['id'];
            $_SESSION['moderator_login'] = $row['login'];
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        } elseif ($row && $row['role'] == 'user' && $row['role'] == $expectation) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_login'] = $row['login'];
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;
        } else {
            $error = "Неверный логин или пароль";
        }
    }
?>