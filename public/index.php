<?php 
error_reporting(E_ERROR);  // mostrar somente erros e não advertencias
require_once(dirname(__FILE__, 2) . '/src/config/config.php');

// para funcionar é necessário configurar o apache no arquivo .htaccess
$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);


if($uri === '/' || $uri === '' ||  $uri === '/index.php') {
    $uri = '/login.php';
}
//print_r((CONTROLLER_PATH . "{$uri}"));

require_once(CONTROLLER_PATH . "/{$uri}");// redireciona para o controller


