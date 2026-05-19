 <?
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
?>