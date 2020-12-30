<?php
// Controller temporário!!!


$array = [
    oi => 'Domingo',
    oa =>'Segunda',
    os =>'Terça',
    od =>'Quarta',
    of =>'Quinta',
    og =>'Sexta',
    ow =>'Sábado'
];

foreach ($array as $valor) {
    echo "$valor <br>";
}

foreach ($array as $indice => $valor) {
    $oi[$indice]=  $valor;
    
}
print_r($oi);


/*
$wh = WorkingHours::loadFromUserAndDate(1, date('Y-m-d'));
$intervaloTrabalhado = $wh->obterIntervalosTrabalhados()->format('%H:%I:%S');
print_r($intervaloTrabalhado);
echo "<br>";

$intervaloAlmoco = $wh->obterIntervaloDeAlmoco()->format('%H:%I:%S');
print_r($intervaloAlmoco);
echo "<br>";

$startDate = obterPrimeiroDiaDoMes($date)->format('Y-m-d');
print_r($intervaloAlmoco);
echo "<br>";

$horaSaida = $wh->obterHoraDeSaida();
print_r($horaSaida);
echo "<br>";

/*
[$t1,$t2,$t3,$t4] = $wh->obterRegistrosDePontos(); //pra testar tem que tornar o metodo publico

print_r($t1);
echo "<br>";
print_r($t2);
echo "<br>";
print_r($t3);
echo "<br>";
print_r($t4);
echo "<br>";


/*
$i1= DateInterval::createFromDateString('9 hours');
$i2= DateInterval::createFromDateString('6 hours');

$r1 = sumIntervals($i1,$i2);
$r2 = subtractIntervals($i1,$i2);

print_r($r1);
echo "<br>";
print_r($r2);
echo "<br>";
print_r(getDateFromInterval($r1));