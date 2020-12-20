<?php 
error_reporting(E_ERROR);  // mostrar somente erros e não advertencias
require_once(dirname(__FILE__, 2) . '/src/config/config.php');// __FILE__ pega o caminho da pasta atual, o 2 sai da pasta atual e vai para a pasta pai e ai ele acessa '/src/config/config.php' e executa todo o código no arquivo

require_once(dirname(__FILE__, 2) . '/src/models/User.php');
//Database::getConnection();

$user = new User(['name' => 'Lucas','email' => 'lucas@coder.com.br']);
print_r($user);
echo 'Fim!';