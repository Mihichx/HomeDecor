<?  
    $link = require 'connect.php';
	$url = $_SERVER['REQUEST_URI'];
    $layout = file_get_contents('template/layout.php');

    if (!empty($link) && $link !== 1) {
        preg_match('#(\d+)#', $url, $match);
        $id = $match[1];
        $query  = "SELECT * FROM pages WHERE id=$id";
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        $page   = mysqli_fetch_assoc($res);

        $layout = str_replace('{{ title }}', $page['title'], $layout);
        $layout = str_replace('{{ content }}', $page['content'], $layout);
    } else {
        $path = 'page' . $url . '.php';

        if (!file_exists($path)) {
            header('HTTP/1.0 404 Not Found' );
            $path = 'page/404.php';
        }

        $content = file_get_contents($path);
        preg_match('#\{\{ title: "(.+?)" \}\}#', $content, $match);
        $content = preg_replace('#\{\{ title: "(.+?)" \}\}#', '', $content);
        $title = $match[1];

        $layout = str_replace('{{ title }}', $title, $layout);
        $layout = str_replace('{{ content }}', $content, $layout);
    }
    echo $layout;
?>