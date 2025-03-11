<?php
require_once 'config.php';

// Auto-load các model và controller
spl_autoload_register(function ($class) {
    if (file_exists("controllers/$class.php")) {
        require_once "controllers/$class.php";
    } elseif (file_exists("models/$class.php")) {
        require_once "models/$class.php";
    }
});

// Determine if URL is using rewrite or standard GET parameters
if (isset($_GET['url'])) {
    $url = $_GET['url'];
} else {
    $url = isset($_GET['controller']) ? $_GET['controller'] : '';
    if (isset($_GET['action'])) {
        $url .= '/' . $_GET['action'];
    }
}

$url = rtrim($url, '/');
$url = explode('/', $url);

// Determine controller
$controllerName = !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : 'AuthController';
$action = isset($url[1]) ? $url[1] : 'login';
$params = array_slice($url, 2);

// For backward compatibility with existing system
if ($controllerName == 'AuthController' && empty($url[0])) {
    $controllerName = 'AuthController';
    $action = 'login';
}

// Initialize controller and call action
if (class_exists($controllerName)) {
    $controller = new $controllerName($pdo);
    if (method_exists($controller, $action)) {
        call_user_func_array([$controller, $action], $params);
    } else {
        echo "Action <strong>$action</strong> không tồn tại!";
    }
} else {
    echo "Controller <strong>$controllerName</strong> không tồn tại!";
}
