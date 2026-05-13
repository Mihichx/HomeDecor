<? 
    $page = getPageBySlug($pdo, 'basket');
    $product = getPageBySlug($pdo, 'card_product_basket');
    $title = $page['title'];
    $header_content = $page['header_content'];
    $value = '1 товар'; 
    
    $header_content = str_replace('{{ value }}', $value, $header_content);

    $product_template = $product['content'] ?? '';
    $products_html = $product_template; 
    $content = str_replace('{{ product }}', $products_html, $page['content']);

    if (isset($_POST['apply_promo'])) {
        $code = trim($_POST['promo_code'] ?? '');

        if ($code === "QWERTY") {
            $status = 'Скидка применена!';
            $color_status = 'green';
            $data = ['discount_multiplier' => 0.8]; // Скидка 20%
        } else {
            $status = 'Неверный код';
            $color_status = 'red';
            $data = null;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'status' => $status,
            'color'  => $color_status,
            'data'   => $data
        ]);
        exit;
    }
?>