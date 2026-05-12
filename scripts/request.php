<? 
    // Получение страницы
    function getPageBySlug($pdo, $slug) {
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE slug = :slug");
        $stmt->execute([':slug' => $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Проверка на существование юзера и дальнейшего его получения
    function loginUser($pdo, $login, $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->execute([':login' => $login]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    // Регистрация + проверка на существование логина
    function registrationUser($pdo, $login1, $email1, $password1, $password_repeat) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE login = :login");
        $stmt->execute([':login' => $login1]);
        if ($stmt->fetch()) return "Такой пользователь уже есть";
        if  ($password1 !==  $password_repeat) return "Пароли не совпадают";

        $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
        $role = 'user';
        $date = date('Y-m-d');

        $stmt = $pdo->prepare("INSERT INTO `users`(`login`, `email`, `password`, `role`, `date_regist`) VALUES (:login, :email, :password, :role, :date_regist)");
        $stmt->execute([
            ':login'       => $login1,
            ':email'       => $email1,
            ':password'    => $hashedPassword, 
            ':role'        => $role,
            ':date_regist' => $date
        ]);
        return "Регистрация прошла успешно"; 
    }

    // Обновление данных ЛК
    function updateUser($pdo, $userId, $data) {
        $sql = "UPDATE users SET login = :login, email = :email";
        $params = [
            ':login' => $data['login'],
            ':email' => $data['email'],
            ':id'    => $userId
        ];

        // Если передан новый пароль, добавляем его в запрос
        if (!empty($data['password'])) {
            $sql .= ", password = :password";
            $params[':password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    }

    // Получение всех каталогов
    function getCategories($pdo) {
        $stmt = $pdo->query("SELECT * FROM category");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получение продуктов по категории или сортировки
    function products($pdo, $href, $sort = 'default') {
        $stmt = $pdo->prepare("SELECT id, name FROM category WHERE href = :href");
        $stmt->execute([':href' => $href]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$category) return null;
        
        $sql = "SELECT * FROM products WHERE category_id = :category_id";

        if ($sort === 'price_asc') {
            $sql .= " ORDER BY price ASC";
        } elseif ($sort === 'price_desc') {
            $sql .= " ORDER BY price DESC";
        }
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':category_id' => $category['id']]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'info'  => $category,
            'items' => $items
        ];
    }

    // Поиск пор данным: таблица, столбец, что
    function search($pdo, $table, $column, $value) {
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE $column LIKE :value");
        $stmt->execute([':value' => "%$value%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Добавление отзыва 
    function addReview($pdo, $name, $rating, $text) {
        $stmt = $pdo->prepare("INSERT INTO reviews (name, rating, text) VALUES (:name, :rating, :text)");
        return $stmt->execute([
            ':name'   => htmlspecialchars($name),
            ':rating' => (int)$rating,
            ':text'   => htmlspecialchars($text)
        ]);
    }

    // Добавление заявки на обратную связь 
    function addСonnection($pdo, $name, $email, $text) {
        $stmt = $pdo->prepare("INSERT INTO contact (name, email, text) VALUES (:name, :email, :text)");
        return $stmt->execute([
            ':name'   => htmlspecialchars($name),
            ':email'  => htmlspecialchars($email),
            ':text'   => htmlspecialchars($text)
        ]);
    }

    // function product($pdo, $name) {
    //     $stmt = $pdo->prepare("SELECT * FROM products WHERE name = :name");
    //     $stmt->execute([':name' => $name]);
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }

    // function products($pdo) {
    //     $stmt = $pdo->query("SELECT * FROM products");
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }       
?>