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
}
