<? 
    $page = getPageBySlug($pdo, 'basket');
    $title = $page['title'];
    $header_content = $page['header_content'];
    $content = $page['content'];
    $value = 'пусто';

    $header_content = str_replace('{{ value }}', $value, $header_content);
?>