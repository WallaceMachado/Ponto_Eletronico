<?php 
error_reporting(E_ERROR);  // mostrar somente erros e não advertencias
require_once(dirname(__FILE__, 2) . '/src/config/config.php');// __FILE__ pega o caminho da pasta atual, o 2 sai da pasta atual e vai para a pasta pai e ai ele acessa '/src/config/config.php' e executa todo o código no arquivo

require_once(MODEL_PATH .'/Login.php');
$login=new Login(['email'=>'admin@cod3r.com.br', 'password' => 'a']);

try{
    $login->checkLogin();
    echo "deu certo";

} catch (Exception $e){
    echo"erro";
}

