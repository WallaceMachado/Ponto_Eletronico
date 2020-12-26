<?php


loadModel('Login');
$exception = null;

if(count($_POST) > 0) {//$_POST é um array associativo do php
    $login = new Login($_POST);
    print_r($login);
    try {
        $user = $login->checkLogin();
        header("Location: day_records.php");//redirecionamento de pagina
    } catch(AppException $e) {
      $exception = $e;
    }
}



loadView('login', $_POST + ['exception' => $exception]);