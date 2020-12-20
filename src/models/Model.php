<?php

class Model {

    // define os dados para consulta no banco
    protected static $tableName = ''; // pertence a classe
    protected static $columns = [];// pertece a classe
    protected $values = [];// pertece a cada objeto instanciado

    // construtor
    function __construct($arr, $sanitize = true) {
        
        $this->loadFromArray($arr, $sanitize);
    }

    // carrega os dados do array
    public function loadFromArray($arr, $sanitize = true) {
        if($arr) {// se o array estiver setado
            
            foreach($arr as $key => $value) {// pecorre o array e carrega no array values atributo da classe
              // $this->__set($key, $value);
              $this->$key = $value;// como o set tem como precedente o __ o metod oset fica automatico e não precisa ser declarado (metodo magico)
                }
                ;
            }
          
        }
    

    // __ coloca o metodo como parte do construtor pega o valor a partir de uma chave do array values
    public function __get($key) {
        return $this->values[$key];
    }

    // salva no array novos valores
    public function __set($key, $value) {
        $this->values[$key] = $value;
    }

    // pega os valores do array
    public function getValues() {
        return $this->values;
    }

    //pega os objetso de uma consulta no banco
    public static function get($filters = [], $columns = '*') {
        $objects = [];
        $result = static::getResultSetFromSelect($filters, $columns);
        if($result) {
            $class = get_called_class();// pega a classe que chamou o metodo
            while($row = $result->fetch_assoc()) {
                array_push($objects, new $class($row));// cria um objeto da classe passada
            }
        }
        return $objects;
    }

    // pega o resultado de uma query setada no banco
    public static function getResultSetFromSelect($filters = [], $columns = '*') {
        $sql = "SELECT ${columns} FROM "
            . static::$tableName
            . static::getFilters($filters);
        $result = Database::getResultFromQuery($sql);
        if($result->num_rows === 0) {
            return null;
        } else {
            return $result;
        }
    }

    private static function getFilters($filters) {
        $sql = '';
        if(count($filters) > 0) {
            $sql .= " WHERE 1 = 1";// condição sempre verdadeira e independente dos filtros, feito isso para poder utilizar a função and
            foreach($filters as $column => $value) {
               
                    $sql .= " AND ${column} = " . static::getFormatedValue($value);
                }
            }
         
        return $sql;
    }

    // verifica se o paramento é do formato 'string' se não for ele altera para que seja
    private static function getFormatedValue($value) {
        if(is_null($value)) {
            return "null";
        } elseif(gettype($value) === 'string') {
            return "'${value}'";
        } else {
            return $value;
        }
    }

}
