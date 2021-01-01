<?php
session_start();
requireValidSession(true); // true coloca que tem ser admin, conforme classe confin/session

$exception = null;
$userData = [];

// cerregar os dados do id selecionado
if(count($_POST) === 0 && isset($_GET['update'])) {
    $user = User::getOne(['id' => $_GET['update']]);
    $userData = $user->getValues();
    $userData['password'] = null;
} elseif(count($_POST) > 0 ) {
    
        try {
        $dbUser = new User($_POST);
        if($dbUser->id) {
            $dbUser->update();
            addSuccessMsg('Usuário alterado com sucesso!');
            header('Location: users.php');
            exit();
        } else {
            $dbUser->insert();
            addSuccessMsg('Usuário cadastrado com sucesso!');
        }
        $_POST = [];
    } catch(Exception $e) {
        $exception = $e;
    } finally {
        $userData = $_POST;
    }
    
} 

loadTemplateView('save_user', $userData + ['exception' => $exception]);