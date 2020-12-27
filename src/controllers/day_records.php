<?php
// carrega os registros de ponto do dia

session_start();
requireValidSession();// valida se tem um usuário valido na sessão se não tiver ele direciona para a tela de login
loadModel('WorkingHours');

$date = (new Datetime())->getTimestamp();
$today = strftime('%d de %B de %Y', $date);

$user = $_SESSION['user'];
$records = WorkingHours::loadFromUserAndDate($user->id, date('Y-m-d'));

loadTemplateView('day_records', ['today' => $today, 'records'=>$records]);// redireciona para a view