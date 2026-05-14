<?php
    $page = getPageBySlug($pdo, 'catalog');
    $header_content = $page['header_content'];
    $content = "";

    if (!isset($_SESSION['basket'])) {
        $_SESSION['basket'] = [];
    }

    $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

    if (isset($_POST['id']) && $isAjax) {
        header('Content-Type: application/json');
        
        $id = intval($_POST['id'] ?? 0);

        if ($id > 0) {
            if (isset($_SESSION['basket'][$id])) {
                $_SESSION['basket'][$id]++;
            } else {
                $_SESSION['basket'][$id] = 1;
            }

            $total_items = array_sum($_SESSION['basket']);

            echo json_encode([
                'status' => 'Добавлено', // Лучше передавать статус строкой для JS-проверок
                'color' => 'white',
                'message' => 'Товар добавлен в корзину',
                'count' => $total_items
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Некорректный ID товара'
            ]);
        }
        exit; // Критически важно остановить скрипт здесь
    }

    function card($pdo, $products) {  // Функция для формирования карточки товара
        $product_page = getPageBySlug($pdo, 'card_product');
        $card_template = $product_page['content'];
        
        $products_html = "";
        foreach ($products as $row) {
            $product_url = "./vases/detailed_card_product?id=" . $row['id'];
            $card_content = str_replace(
                ['{{ name }}', '{{ image }}', '{{ price }}', '{{ description }}', '{{ product_url }}', '{{ id }}'],
                [
                    htmlspecialchars($row['name']), 
                    htmlspecialchars('/' . $row['image']), 
                    htmlspecialchars($row['price']), 
                    htmlspecialchars($row['description']),
                    htmlspecialchars($product_url),
                    htmlspecialchars($row['id'])
                ],
                $card_template
            );
            $products_html .= $card_content;
        }
        return $products_html;
    }

    // Обработка поиска
    if (isset($_POST['search']) && !empty(trim($_POST['search']))) {  // Если у нас заполненное поле поиска
        $search_val = trim($_POST['search']);
        $title = "Поиск: " . htmlspecialchars($search_val);

        $found_products = searchALL($pdo, 'products', 'name', $search_val);

        if (!empty($found_products)) {
            $products_html = card($pdo, $found_products);
            $content .= "<div class='vases-grid'>$products_html</div>";
        } else {
            $content .= "<h2>По вашему запросу ничего не найдено</h2>";
            $title = "Товар не найден";
        }
    } elseif (isset($params[2]) && $params[2] == 'detailed_card_product') {
        $product_page_more = getPageBySlug($pdo, 'detailed_card_product');
        $found_products = searchALL($pdo, 'products', 'id', $_GET['id']);
        $title = $found_products[0]['name'];
        $products_html = str_replace(
            ['{{ img }}', '{{ id }}', '{{ material }}', '{{ color }}', '{{ height }}', '{{ length }}', '{{ width }}', '{{ weight }}', '{{ price }}', '{{ name }}'],
            [   
                htmlspecialchars('/' . $found_products[0]['image']), 
                htmlspecialchars($found_products[0]['id']), 
                htmlspecialchars($found_products[0]['material']), 
                htmlspecialchars($found_products[0]['color']), 
                htmlspecialchars($found_products[0]['height']),
                htmlspecialchars($found_products[0]['length']),
                htmlspecialchars($found_products[0]['width']),
                htmlspecialchars($found_products[0]['weight']),
                htmlspecialchars($found_products[0]['price']),
                htmlspecialchars($found_products[0]['name'])
            ],
            $product_page_more['content']
        );
        $content .= "$products_html";
    } else {
    // Логика каталога 
        $category_slug = $params[1] ?? '';
        if ($category_slug === '') {  // Если мы на странице catalog без выбранной категории
            $title = 'Каталог';
            $template = $page['content'];
            $categories = getCategories($pdo);
            
            $cards_html = "";
            foreach ($categories as $row) {
                $cards_html .= str_replace(
                    ['{{ name }}', '{{ image }}', '{{ href }}'], 
                    [$row['name'], $row['image'], $row['href']], 
                    $template
                );
            }
            $content .= "<div class='container-catalog'>$cards_html</div>";
        } else {  // Если у нас выбрана категория 
            $sort = $_GET['sort'] ?? 'default';
            $data = products($pdo, $params[1], $sort);

            if ($data) {
                $category_name = $data['info']['name'];
                $products = $data['items'];
                $title = $category_name;
                
                $products_html = card($pdo, $products);

                if ($products_html) {
                    $asc_selected = ($sort == 'price_asc') ? 'selected' : '';
                    $desc_selected = ($sort == 'price_desc') ? 'selected' : '';

                    $content .= '
                        <div class="vases-header">
                            <div class="sort">
                                <p>Сортировать по:</p>
                                <select onchange="location.href = \'?sort=\' + this.value;">
                                    <option value="default">По умолчанию</option>
                                    <option value="price_asc" ' . $asc_selected . '>Цене по возрастанию цены</option>
                                    <option value="price_desc" ' . $desc_selected . '>Цене по убыванию цены</option>
                                </select>
                            </div>
                        </div>
                    ';
                }
                $content .= "<div class='vases-grid'>$products_html</div>";
            } else {
                $content .= "<h2>По вашему запросу ничего не найдено</h2>";
                $title = "Товар не найден";
            }
        }
    }
?>