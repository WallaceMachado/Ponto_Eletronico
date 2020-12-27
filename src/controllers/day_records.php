<?php
// carrega os registros de ponto do dia

session_start();
requireValidSession();// valida se tem um usuário valido na sessão se não tiver ele direciona para a tela de login

$date = (new Datetime())->getTimestamp();
$today = strftime('%d de %B de %Y', $date);
loadTemplateView('day_records', ['today' => $today]);// redireciona para a view