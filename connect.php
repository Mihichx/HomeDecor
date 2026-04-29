<?
    ini_set('display_errors', 0);  // Отключаем стандартный вывод ошибок PHP в браузер
    mysqli_report(MYSQLI_REPORT_OFF);  // Отключаем автоматические Fatal Errors от MySQL


    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $name = 'engine'; 
    $link = mysqli_connect($host, $user, $pass);


    // Если ошибка в логине/пароле/хосте
    if (!$link) {
        die("
            <div style='font-family: Arial; text-align: center; margin-top: 100px;'>
                <h1 style='color: #e74c3c;'>Ошибка сервера</h1>
                <p style='color: #7f8c8d;'>Не удалось установить соединение с сервером базы данных.</p>
                <hr style='width: 300px;'>
                <small style='color: #bdc3c7;'>Технический код: " . mysqli_connect_errno() . "</small>
             </div>
        ");
    }


    // Если сервер работает, но бд не найдена
    if (!mysqli_select_db($link, $name)) {
        die("
            <div style='font-family: Arial; text-align: center; margin-top: 100px;'>
                <h1 style='color: #f39c12;'>База данных не найдена</h1>
                <p style='color: #7f8c8d;'>Сервер работает, но база <b>$name</b> отсутствует.</p>
             </div>
        ");
    }


    mysqli_set_charset($link, 'utf8');
    return $link;
?>