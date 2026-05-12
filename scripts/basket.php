<? 
    $page = getPageBySlug($pdo, 'basket');
    $title = $page['title'];
    $header_content = $page['header_content'];
    $content = $page['content'];
    $value = '1 товар';

    $header_content = str_replace('{{ value }}', $value, $header_content);

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