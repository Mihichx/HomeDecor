<?php 
    $page = getPageBySlug($pdo, 'basket');
    $title = $page['title'];

    $total_items = isset($_SESSION['basket']) ? array_sum($_SESSION['basket']) : 0;
    $value_text = $total_items . ' товар(ов)'; 
    $header_content = str_replace('{{ value }}', $value_text, $page['header_content']);

    $products_html = '';
    $total_cart_price = 0;

    if (!empty($_SESSION['basket'])) {
        $card_page = getPageBySlug($pdo, 'card_product_basket');
        $card_template = $card_page['content'] ?? '';

        foreach ($_SESSION['basket'] as $id => $quantity) {
            $item = getProductById($pdo, $id);
            
            if ($item) {
                $end_price = $item['price'] * $quantity;
                $total_cart_price += $end_price;

                $card_content = str_replace(
                    ['{{ name }}', '{{ img }}', '{{ price }}', '{{ end_price }}', '{{ id }}', '{{ quantity }}'],
                    [
                        htmlspecialchars($item['name']), 
                        htmlspecialchars('/' . $item['image']), 
                        htmlspecialchars($item['price']), 
                        htmlspecialchars($end_price),
                        htmlspecialchars($item['id']),
                        intval($quantity)
                    ],
                    $card_template
                );
                $products_html .= $card_content;
            }
        }
    } else {
        $products_html = "<h3 class='center'>Ваша корзина пуста</h3>";
    }

    if (isset($_POST['set_quantity']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        header('Content-Type: application/json');
        $id = intval($_POST['id'] ?? 0);
        $qty = intval($_POST['quantity'] ?? 0);

        if ($id > 0) {
            if ($qty <= 0) {
                unset($_SESSION['basket'][$id]); // Если 0 — удаляем
            } else {
                $_SESSION['basket'][$id] = $qty; // Иначе обновляем количество
            }
            echo json_encode(['status' => 'ok']);
        }
        exit;
    }

    $page_content = str_replace('{{ product }}', $products_html, $page['content']);
    $page_content = str_replace('{{ value }}', $value_text, $page_content);
    $content = str_replace('{{ final_price }}', $total_cart_price, $page_content);

    if (isset($_POST['apply_promo'])) {
        header('Content-Type: application/json');
        $code = trim($_POST['promo_code'] ?? '');

        if ($code === "QWERTY") {
            $status = 'Скидка применена!';
            $color_status = 'green';
            $data = ['discount_multiplier' => 0.8]; 
        } else {
            $status = 'Неверный код';
            $color_status = 'red';
            $data = null;
        }

        echo json_encode([
            'status' => $status,
            'color'  => $color_status,
            'data'   => $data
        ]);
        exit;
    }
?>
