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

    public function getActiveClock() {
        $nextTime = $this->getNextTime();
        if($nextTime === 'time1' || $nextTime === 'time3') {
            return 'exitTime';
        } elseif($nextTime === 'time2' || $nextTime === 'time4') {
            return 'workedInterval';
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

  
}