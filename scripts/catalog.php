<?php
    $category_slug = $params[1] ?? '';
    $page = getPageBySlug($pdo, 'catalog');
    $header_content = $page['header_content'];

    // ОБРАБОТКА ПОИСКА
    if (isset($_POST['search']) && !empty(trim($_POST['search']))) {
        $search_val = trim($_POST['search']);
        $found_products = search($pdo, 'products', 'name', $search_val); // таблица products
        
        $title = "Поиск: " . htmlspecialchars($search_val);
        
        if (empty($found_products)) {
            $content = "<h2>По вашему запросу ничего не найдено</h2>";
            $title = "Товар не найден";
        } else {
            $product_page = getPageBySlug($pdo, 'card_product');
            $card_template = $product_page['content'];
            
            $products_html = '';
            foreach ($found_products as $row) {
                $products_html .= str_replace(
                    ['{{ name }}', '{{ image }}', '{{ price }}', '{{ description }}'],
                    [
                        htmlspecialchars($row['name']), 
                        htmlspecialchars('/' . $row['image']), 
                        htmlspecialchars($row['price']), 
                        htmlspecialchars($row['description'])
                    ],
                    $card_template
                );
            }
            $content = "<div class='vases-grid'>$products_html</div>";
        }
    } else {
        // ЛОГИКА КАТАЛОГА 
        if ($category_slug === '') {
            $title = 'Каталог';
            $template = $page['content'];
            $categories = getCategories($pdo);
            
            $cards_html = '';
            foreach ($categories as $row) {
                $cards_html .= str_replace(
                    ['{{ name }}', '{{ image }}', '{{ href }}'], 
                    [$row['name'], $row['image'], $row['href']], 
                    $template
                );
            }
            $content = '<div class="container-catalog">' . $cards_html . '</div>';

        } else {
            $data = products($pdo, $params[1]);

            if ($data) {
                $category_name = $data['info']['name'];
                $products = $data['items'];
                $title = $category_name;

                $product_page = getPageBySlug($pdo, 'card_product');
                $card_template = $product_page['content'];
                
                $products_html = '';
                foreach ($products as $row) {
                    $products_html .= str_replace(
                        ['{{ name }}', '{{ image }}', '{{ price }}', '{{ description }}'],
                        [
                            htmlspecialchars($row['name']), 
                            htmlspecialchars('/' . $row['image']), 
                            htmlspecialchars($row['price']), 
                            htmlspecialchars($row['description'])
                        ],
                        $card_template
                    );
                }

                $content = '
                    <div class="vases-header">
                        <div class="sort">
                            <p>Сортировать по:</p>
                            <select>
                                <option>Цене по возрастанию</option>
                                <option>Цене по убыванию</option>
                            </select>
                        </div>
                    </div>
                ';
                $content .= "<div class='vases-grid'>$products_html</div>";
            } else {
                $content = "<h2>По вашему запросу ничего не найдено</h2>";
                $title = "Товар не найден";
            }
        }
    }
?>