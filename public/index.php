<?php
//declare(strict_types=1);

// Подключаем автозагрузку классов 
require_once __DIR__ . '/../vendor/autoload.php';

// Получаем текущий URL из адресной строки браузера
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

//Если браузер в фоне запрашивает фавиконку, сразу отдаем пустой ответ и глушим скрипт
if ($requestUri === '/favicon.ico') {
    header('Content-Type: image/x-icon');
    exit();
}

// Маршрутизация по страницам из ТЗ
switch ($requestUri) {
	
    case '/':
        $controllerName = 'App\\Controllers\\HomeController';
        $action = 'index';
        break;
        
    case '/category':
        $controllerName = 'App\\Controllers\\CategoryController';
        $action = 'index';
        break;
        
    case '/article':
        $controllerName = 'App\\Controllers\\ArticleController';
        $action = 'index';
        break;
        
    default:
        // Если адрес не подошел, отдаем честную 404 ошибку
        header("HTTP/1.0 404 Not Found");
        echo "<h1>404 - Страница не найдена</h1>";
        exit();
}




if (class_exists($controllerName)) {
	
    $controller = new $controllerName();
    $controller->$action();
} else {
	
    header("HTTP/1.0 500 Internal Server Error");
    echo "Ошибка архитектуры: Класс $controllerName не найден.";
}
