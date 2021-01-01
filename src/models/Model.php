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

    public static function getOne($filters = [], $columns = '*') {
        $class = get_called_class();
        $result = static::getResultSetFromSelect($filters, $columns);
        return $result ? new $class($result->fetch_assoc()) : null;
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

    public function insert() {
        $novacoluna = [];
        //excluindo o a coluna id, pois o id é preenchido automaticamente pelo banco
        foreach(static::$columns as $indice => $valor) {
            if($valor!=="id"){
           $novaColuna[$indice]=$valor;
           
        }}
        
        $sql = "INSERT INTO " . static::$tableName . " ("
            . implode(",", $novaColuna) . ") VALUES ("; //implode pega um array e transforma em uma string
        foreach(static::$columns as $col) {
            if($col!=="id"){
            $sql .= static::getFormatedValue($this->$col) . ",";}// pegando o valor da coluna do obejto e separando por virgula
        }
        $sql[strlen($sql) - 1] = ')';// no ultimo elemento da string fecha o parenteses, substitui a virgula final
      

         $id = Database::executeSQL($sql);
        $this->id = $id;
    }

    public function update() {
        $sql = "UPDATE " . static::$tableName . " SET ";
        foreach(static::$columns as $col) {
            $sql .= " ${col} = " . static::getFormatedValue($this->$col) . ",";
        }
        $sql[strlen($sql) - 1] = ' ';
        $sql .= "WHERE id = {$this->id}";
        Database::executeSQL($sql);
    }

    public function delete() {
        static::deleteById($this->id);
    }

    public static function deleteById($id) {
        $sql = "DELETE FROM " . static::$tableName . " WHERE id = {$id}";
        Database::executeSQL($sql);
    }

    private static function getFilters($filters) {
        $sql = '';
        if(count($filters) > 0) {
            $sql .= " WHERE 1 = 1";// condição sempre verdadeira e independente dos filtros, feito isso para poder utilizar a função and
            foreach($filters as $column => $value) {

                if($column == 'raw') {
                    $sql .= " AND {$value}";
                } else {
                    $sql .= " AND ${column} = " . static::getFormatedValue($value);
                }
            }
        }
        return $sql;
    }

    public static function obterContador($filters = []) {
        $result = static::getResultSetFromSelect(
            $filters, 'count(*) as count');
        return $result->fetch_assoc()['count'];
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
