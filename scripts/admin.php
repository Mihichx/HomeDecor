<? 
    $stmt = $pdo->prepare("SELECT header_content FROM pages WHERE slug = :slug");
    $stmt->execute([':slug' => 'admin']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $header = $row['header_content'];
    if ($params[1] != '') {
        if ($params[2] != '') {
            $slug = $params[2];
        } else {
            $slug = $params[1];
        }
        include './scripts/page.php';
    } else {
        $content = $row['content'];
        $title = 'Админпанель';
    }
?>