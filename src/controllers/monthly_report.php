<?php


session_start();
requireValidSession();

$dataAtual = new DateTime();
$user = $_SESSION['user'];
$selectedUserId = $user->id;
$users = null;
if($user->is_admin) {
    $users = User::get();//metodo get defindo na classe model
    $selectedUserId = $_POST['user'] ? $_POST['user'] : $user->id;
}



//$_POST['period'] = metodo post a patir da tela do usario no campo period 
$selectedPeriod = $_POST['period'] ? $_POST['period'] : $dataAtual->format('Y-m');
$periods = [];

//pega somente os ultimos 2 anos, se precisar de mais deverá alterar a quantidade de 2 para o que deseja
for($diferencaDeAnos = 0; $diferencaDeAnos <= 2; $diferencaDeAnos++) {
    $year = date('Y') - $diferencaDeAnos;
    for($month = 12; $month >= 1; $month--) {
        $date = new DateTime("{$year}-{$month}-1");
        $periods[$date->format('Y-m')] = strftime('%B de %Y', $date->getTimestamp());
    }
}

$registries = WorkingHours::obterRelatorioMensal($selectedUserId, $selectedPeriod);
$report = [];
$diasUteisDoMes = 0;//não considera feriado
$somadeHorasTrabalhadas = 0;
$ultimoDia = obterUltimoDiaDoMes($selectedPeriod)->format('d');

//peccore todo o mes atual ou selecionado no $selectedPeriod
for($day = 1; $day <= $ultimoDia; $day++) {
    $date = $selectedPeriod . '-' . sprintf('%02d', $day); //sprintf para add o zero nos nueros menores que 10
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
    'selectedPeriod' => $selectedPeriod,
    'periods' => $periods,
    'selectedUserId' => $selectedUserId,
    'users' => $users,
    
]);