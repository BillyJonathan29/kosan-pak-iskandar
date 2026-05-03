<?php
require_once '../vendor/autoload.php';
session_start();
date_default_timezone_set('Asia/Jakarta');


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require_once '../config/koneksi.php';
require_once '../app/Core/Database.php';
require_once '../app/Core/Controller.php';

// --- Sisanya tetap sama seperti sebelumnya ---
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'katalog/index';
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

$controllerName = ucfirst($url[0]) . 'Controller';
$methodName = isset($url[1]) ? $url[1] : 'index';

if (file_exists('../app/Controllers/' . $controllerName . '.php')) {
    require_once '../app/Controllers/' . $controllerName . '.php';

    $controller = new $controllerName;

    if (method_exists($controller, $methodName)) {
        unset($url[0]);
        unset($url[1]);

        $params = !empty($url) ? array_values($url) : [];

        call_user_func_array([$controller, $methodName], $params);
    } else {
        echo "<h1>Error 404</h1>";
        echo "<p>Method <b>{$methodName}</b> tidak ditemukan di dalam controller <b>{$controllerName}</b>!</p>";
    }
} else {
    echo "<h1>Error 404</h1>";
    echo "<p>Controller <b>{$controllerName}</b> tidak ditemukan!</p>";
}
