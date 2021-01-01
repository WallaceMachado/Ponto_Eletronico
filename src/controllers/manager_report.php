<?php
session_start();
requireValidSession(true);// true coloca que tem ser admin, conforme classe confin/session

$usuariosAtivos = User::obterUsuariosAtivos();
$usuariosAusentes = WorkingHours::obterUsuariosAusentes();

$yearAndMonth = (new DateTime())->format('Y-m');
$seconds = WorkingHours::obterHorasTrabalhadasNoMes($yearAndMonth);

// explode pega uma estring e transforma em um array, ':' é o separador, [0] pq quero somente as horas
$horasNoMes = explode(':', obterHoraFormatadaDeUmTempoEmSegundos($seconds))[0];

loadTemplateView('manager_report', [
    'usuariosAtivos' => $usuariosAtivos,
    'usuariosAusentes' => $usuariosAusentes,
    'horasNoMes' => $horasNoMes,
]);