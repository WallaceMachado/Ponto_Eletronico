<?php
// configurações básicas da aplicação, constantes que ajudarão a acesar as pastas de uma forma mais facil, e tambem será responsável para acessar o database
date_default_timezone_set('America/Sao_Paulo');// define o fuso hoario da aplicação
setlocale(LC_TIME, 'pt_BR', 'pt_BR.uft-8', 'portuguese');// configuração de data

// Constantes gerais
define('DAILY_TIME', 60 * 60 * 8);

// acesso as pastas Pastas
define('MODEL_PATH', realpath(dirname(__FILE__) . '/../models'));// __FILE__ pega o caminho da pasta atual, o ponto concatena e /../ sai da pasta atual para a anterior e ai ele acessa a pasta models
define('VIEW_PATH', realpath(dirname(__FILE__) . '/../views')); 
define('CONTROLLER_PATH', realpath(dirname(__FILE__) . '/../controllers'));



// carrega Arquivos/classe
require_once(realpath(dirname(__FILE__) . '/database.php')); // carrega a classe que chama o database
require_once(realpath(MODEL_PATH . '/Model.php'));
require_once(realpath(dirname(__FILE__) . '/loader.php'));
