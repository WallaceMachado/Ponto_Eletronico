<?php


session_start();
requireValidSession();

$dataAtual = new DateTime();
$user = $_SESSION['user'];

$registries = WorkingHours::obterRelatorioMensal($user->id, $dataAtual);

$report = [];
$diasUteisDoMes = 0;//não considera feriado
$somadeHorasTrabalhadas = 0;
$ultimoDia = obterUltimoDiaDoMes($dataAtual)->format('d');

for($day = 1; $day <= $ultimoDia; $day++) {
    $date = $dataAtual->format('Y-m') . '-' . sprintf('%02d', $day); //sprintf para add o zero nos nueros menores que 10
    $registry = $registries[$date];
    
    if(eUmDiaDeTrabalhoNoPassado($date)) $diasUteisDoMes++;

    if($registry) {
        $somadeHorasTrabalhadas += $registry->worked_time;
        array_push($report, $registry);
    } else {
        array_push($report, new WorkingHours([
            'work_date' => $date,
            'worked_time' => 0
        ]));
    }
}

$expectativaDeTrabalhadasNoMes = $diasUteisDoMes * DAILY_TIME;//DAYLY é uma constante definida no config e calcula e retorna as 8 horas de trabalhos em segundos
$saldo = obterHoraFormatadaDeUmTempoEmSegundos(abs($somadeHorasTrabalhadas - $expectativaDeTrabalhadasNoMes));// abs retorna o valor absoluto
$sinal = ($somadeHorasTrabalhadas >= $expectativaDeTrabalhadasNoMes) ? '+' : '-';

loadTemplateView('monthly_report', [
    'report' => $report,
    'somadeHorasTrabalhadas' => obterHoraFormatadaDeUmTempoEmSegundos($somadeHorasTrabalhadas),
    'saldo' => "{$sinal}{$saldo}",
    
]);