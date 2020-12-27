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

