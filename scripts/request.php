<? 
    function getPageBySlug($pdo, $slug) {
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = :slug");
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function loginUser($pdo, $login, $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->execute([':login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    function examinationUser($pdo, $login1) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->execute([':login' => $login1]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function registrationUser($pdo, $login1, $password1, $password_repeat) {
        $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
        $role = 'user';
        $date = date('Y-m-d');

        $stmt = $pdo->prepare("INSERT INTO `users`(`login`, `password`, `role`, `date_regist`) VALUES (:login, :password, :role, :date_regist)");
        $stmt->execute([
            ':login'       => $login1,
            ':password'    => $hashedPassword, 
            ':role'        => $role,
            ':date_regist' => $date
        ]);
        return true; 
    }

    function product($pdo, $name) {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE name = :name");
        $stmt->execute([':name' => $name]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function products($pdo) {
        $stmt = $pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }       
?>