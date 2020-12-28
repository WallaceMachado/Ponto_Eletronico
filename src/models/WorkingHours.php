<?php
//horas trabalhadas

class WorkingHours extends Model {
    protected static $tableName = 'working_hours';
    protected static $columns = [
        'id',
        'user_id',
        'work_date',
        'time1',
        'time2',
        'time3',
        'time4',
        'worked_time'
    ];

    // carregar jornada de trabalho
    public static function loadFromUserAndDate($userId, $workDate) {
        $registry = self::getOne(['user_id' => $userId, 'work_date' => $workDate]);

        if(!$registry) {
            $registry = new WorkingHours([
                'user_id' => $userId,
                'work_date' => $workDate,
                'worked_time' => 0
            ]);
        }

        return $registry;
    }


    //retorna o proximo ponto a ser batido
    public function getNextTime() {
        if(!$this->time1) return 'time1';
        if(!$this->time2) return 'time2';
        if(!$this->time3) return 'time3';
        if(!$this->time4) return 'time4';
        return null;
    }

    public function obterRelogioAtivo() {// retorna o relogio que será atualizado na tela automaticamento pelo JS
        $nextTime = $this->getNextTime();
        if($nextTime === 'time1' || $nextTime === 'time3') {
            return 'horaDeSaida';
        } elseif($nextTime === 'time2' || $nextTime === 'time4') {
            return 'horasTrabalhadas';
        } else {
            return null;
        }
    }

    //função que bate/registra o ponto

    public function innout($time) {
        $timeColumn = $this->getNextTime();
        if(!$timeColumn) {
            throw new AppException("Você já fez os 4 batimentos do dia!");
        }
        $this->$timeColumn = $time;
        
        if($this->id) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    function obterIntervalosTrabalhados() {
        [$t1, $t2, $t3, $t4] = $this->obterRegistrosDePontos();

        $part1 = new DateInterval('PT0S');// dateinterval é padrão do PHP e PT0S informa 0 segundos
        $part2 = new DateInterval('PT0S');

        if($t1) $part1 = $t1->diff(new DateTime()); // horario atual menos o t1 -- diff é calculo padrão de intervalo do php
        if($t2) $part1 = $t1->diff($t2);
        if($t3) $part2 = $t3->diff(new DateTime());
        if($t4) $part2 = $t3->diff($t4);

        return sumIntervals($part1, $part2); // soma de intervalo feito na date_utils
    }

    function obterIntervaloDeAlmoco() {
        [, $t2, $t3,] = $this->obterRegistrosDePontos();
        $lunchInterval = new DateInterval('PT0S');

        if($t2) $lunchInterval = $t2->diff(new DateTime());
        if($t3) $lunchInterval = $t2->diff($t3);

        return $lunchInterval;
    }

    function obterHoraDeSaida() {
        [$t1,,, $t4] = $this->obterRegistrosDePontos();
        $diaDeTrabalho = DateInterval::createFromDateString('8 hours'); // cria um intervalo de tempo de 8 horas, metodo od php

        if(!$t1) {
            return (new DateTimeImmutable())->add($diaDeTrabalho);// retorna um horario acrescido de 8 horas
        } elseif($t4) {
            return $t4;
        } else {
            $total = sumIntervals($diaDeTrabalho, $this->obterIntervaloDeAlmoco());
            return $t1->add($total);
        }
    }

    public static function obterRelatorioMensal($userId, $date) {
        $registries = [];
        $startDate = obterPrimeiroDiaDoMes($date)->format('Y-m-d');
        $endDate = obterUltimoDiaDoMes($date)->format('Y-m-d');

        $result = static::getResultSetFromSelect([//busca consultas no banco
            'user_id' => $userId,
            'raw' => "work_date between '{$startDate}' AND '{$endDate}'"
        ]);

        if($result) {
            while($row = $result->fetch_assoc()) {
                $registries[$row['work_date']] = new WorkingHours($row);
            }
        }
        
        return $registries;
    } 

     function obterRegistrosDePontos() {
        $times = [];

        $this->time1 ? array_push($times, getDateFromString($this->time1)) : array_push($times, null);
        $this->time2 ? array_push($times, getDateFromString($this->time2)) : array_push($times, null);
        $this->time3 ? array_push($times, getDateFromString($this->time3)) : array_push($times, null);
        $this->time4 ? array_push($times, getDateFromString($this->time4)) : array_push($times, null);

        return $times;
    }
}

  
