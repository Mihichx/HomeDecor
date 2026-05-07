<?  
    $page = getPageBySlug($pdo, 'catalog');
    $header_content = $page['header_content'];

    if (isset($params[1]) && $params[1] !== '') {  // Определяем какой у нас будет запрос
        $rows = product($pdo, $params[1]);
        $title = "Товар: " . htmlspecialchars($params[1]);
    } else {
        $rows = products($pdo);
        $title = $page['title'];
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
            $more_description = htmlspecialchars($row['more_description']);
            
            $card = getPageBySlug($pdo, 'card_product');
            $value = $card['content'];
            $value = str_replace('{{ name }}', $name, $value);
            $value = str_replace('{{ image }}', $image, $value);
            $value = str_replace('{{ price }}', $price, $value);
            $value = str_replace('{{ description }}', $description, $value);
            
            $card1 = getPageBySlug($pdo, 'detailed_card_product');
            $value1 = $card1['content'];
            $value1 = str_replace('{{ name }}', $name, $value1);
            $value1 = str_replace('{{ image }}', $image, $value1);
            $value1 = str_replace('{{ price }}', $price, $value1);
            $value1 = str_replace('{{ more_description }}', $more_description, $value1);

            if (!isset($params[1]) || $params[1] === '') {
                $content .= "<a href='/catalog/$name'>$value</a>";
            } else {
                $content .= $value1;
            }
        }
    }
?>