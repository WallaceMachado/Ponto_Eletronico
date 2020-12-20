<?php


loadModel('Login');


if(count($_POST) > 0) {//$_POST é um array associativo do php
    $login = new Login($_POST);
    try {
        $user = $login->checkLogin();
        echo "Usuário {$user->name} logado";
    } catch(Exception $e) {
       echo "falha";
    }
}


loadView('login', $_POST );