<?php 
error_reporting(E_ERROR);  // mostrar somente erros e não advertencias
require_once(dirname(__FILE__, 2) . '/src/config/config.php');

// para funcionar é necessário configurar o apache no arquivo .htaccess
$uri =  urldecode($_SERVER['REQUEST_URI'])
    
    ; // pega a uri do navegador
;

if($uri === '/' || $uri === '' ||  $uri === '/index.php') {
    $uri = '/login.php';
}
//print_r((CONTROLLER_PATH . "{$uri}"));

require_once(CONTROLLER_PATH . "/{$uri}");// redireciona para o controller


