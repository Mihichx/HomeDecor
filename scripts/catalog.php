<?  
    if (isset($params[1]) && $params[1] !== '') {  // Определяем какой у нас будет запрос
        $stmt = $pdo->prepare("SELECT * FROM products WHERE name = :name");
        $stmt->execute([':name' => $params[1]]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $title = "Товар: " . htmlspecialchars($params[1]);
    } else {
        $stmt = $pdo->query("SELECT * FROM products");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $title = "Каталог товаров";
    }

    if (count($rows) == 0) {
        header('HTTP/1.0 404 Not Found');
        $error = "Запрашиваемый товар не найден";
        $title = "Товар не найден";
        include './template/404.php';
    } else {
        $content = "<h1>$title</h1>";

        foreach ($rows as $row) {
            $category = htmlspecialchars($row['category_id']);
            $name = htmlspecialchars($row['name']);
            $price = htmlspecialchars($row['price']);
            $image = htmlspecialchars($row['image']);
            $description = htmlspecialchars($row['description']);

            $value = "
                <h2>$name</h2>
                <img src='$image' style='max-width: 200px;'>
                <p><b>Цена:</b> $price руб.</p>
                <p>$description</p>
            ";

            if (!isset($params[1]) || $params[1] === '') {
                $content .= "<a href='/catalog/$name'>$value</a>";
            } else {
                $content .= $value;
            }
        }
    }
?>