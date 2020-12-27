<?php
//marcação da entrada e saida



session_start();
requireValidSession();

loadModel('WorkingHours');

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

try {
    $currentTime = strftime('%H:%M:%S', time());

    if($_POST['forcedTime']) {
        $currentTime = $_POST['forcedTime'];
    }

    $records->innout($currentTime);// innout faz o batimento do ponto - defino dentro do controllet
    addSuccessMsg('Ponto inserido com sucesso!');//addSuccessMsg defino em config/utils
} catch(AppException $e) {
    addErrorMsg($e->getMessage());//addErrorMsg defino em config/utils
}


    
  
header('Location: day_records.php');