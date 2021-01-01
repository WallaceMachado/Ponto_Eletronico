<?php

//valida a sessão
function requireValidSession($requiresAdmin = false) {
    $user = $_SESSION['user'];
    if(!isset($user)) { // caso não esteja logado
        header('Location: login.php');
        exit();
    } elseif($requiresAdmin && !$user->is_admin) {// caso esteja loga e não seja perfim admin
        addErrorMsg('Acesso negado!');
        header('Location: day_records.php');
        exit();
    }
}