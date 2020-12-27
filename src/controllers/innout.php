<?php
//marcação da entrada e saida

echo "ok";

session_start();
requireValidSession();

loadModel('WorkingHours');

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));


    $currentTime = strftime('%H:%M:%S', time());
    $records->innout($currentTime);// innout faz o batimento do ponto - defino dentro do controllet
  
header('Location: day_records.php');