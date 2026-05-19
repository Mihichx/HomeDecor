<?
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
    $title = 'Каталог';
    $content .= "<div class='container-catalog'>$cards_html</div>";
?>