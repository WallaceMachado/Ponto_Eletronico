<?php 
error_reporting(E_ERROR);  // mostrar somente erros e não advertencias
require_once(dirname(__FILE__, 2) . '/src/config/database.php');// __FILE__ pega o caminho da pasta atual, o 2 sai da pasta atual e vai para a pasta pai e ai ele acessa '/src/config/config.php'

//Database::getConnection();

$sql = 'select * from users';
$result = Database::getResultFromQuery($sql);

while($row = $result->fetch_assoc()){
    print_r($row);
    echo '<br>';
}