<?php


loadModel('Login');
$exception = null;

if(count($_POST) > 0) {//$_POST é um array associativo do php
    $login = new Login($_POST);
    try {
        $user = $login->checkLogin();
        echo "Usuário {$user->name} logado";
    } catch(AppException $e) {
      $exception = $e;
    }
}


loadView('login', $_POST + ['exception' => $exception]);