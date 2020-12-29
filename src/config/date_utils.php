<?php

function getDateAsDateTime($date) {
    return is_string($date) ? new DateTime($date) : $date;
}

function isWeekend($date) {
    $inputDate = getDateAsDateTime($date);
    return $inputDate->format('N') >= 6;// format N pega o numero do dia, se for igual ou maior que 6  é final de semana
}

function isBefore($date1, $date2) {
    $inputDate1 = getDateAsDateTime($date1);
    $inputDate2 = getDateAsDateTime($date2);
    return $inputDate1 <= $inputDate2;// retorna verdadeiro caso a dta 1 seja menor ou igual a data 2
}

function getNextDay($date) {
    $inputDate = getDateAsDateTime($date);
    $inputDate->modify('+1 day');// adiciona 1 dia na data
    return $inputDate;
}

//soma de intervalos
function sumIntervals($interval1, $interval2) {
    $date = new DateTime('00:00:00');//pega o dia atua le seta para hoario zero
    $date->add($interval1);
    $date->add($interval2);// soma 
    return (new DateTime('00:00:00'))->diff($date);// diff retorna um intervalo de tempo entre duas datas
}

function subtractIntervals($interval1, $interval2) {
    $date = new DateTime('00:00:00');
    $date->add($interval1);
    $date->sub($interval2);// subtrai
    return (new DateTime('00:00:00'))->diff($date);
}

//converte para o formato de data
function getDateFromInterval($interval) {
    return new DateTimeImmutable($interval->format('%H:%i:%s'));
}

function getDateFromString($str) {
    return DateTimeImmutable::createFromFormat('H:i:s', $str);
}


function obterPrimeiroDiaDoMes($date) {
    $time = getDateAsDateTime($date)->getTimestamp();
    return new DateTime(date('Y-m-1', $time));
}

function obterUltimoDiaDoMes($date) {
    $time = getDateAsDateTime($date)->getTimestamp(); // pega a quantidade de horas
    return new DateTime(date('Y-m-t', $time));// t faz retornar o ultimo dia do mes
}

function obterSegundosDeUmIntervaloDeData($interval) {
    $d1 = new DateTimeImmutable();
    $d2 = $d1->add($interval);
    return $d2->getTimestamp() - $d1->getTimestamp();
}

function eUmDiaDeTrabalhoNoPassado($date) {
    return !isWeekend($date) && isBefore($date, new DateTime());
}

function obterHoraFormatadaDeUmTempoEmSegundos($seconds) {
    $h = intdiv($seconds, 3600);
    $m = intdiv($seconds % 3600, 60);
    $s = $seconds - ($h * 3600) - ($m * 60);
    return sprintf('%02d:%02d:%02d', $h, $m, $s);
}

function formatarDataComLocale($date, $pattern) {
    $time = getDateAsDateTime($date)->getTimestamp();// pega a quantidade de horas
    return strftime($pattern, $time);
}

