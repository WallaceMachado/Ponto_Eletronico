<?php

class Database {

    public static function getConnection() {
        $envPath = realpath(dirname(__FILE__) . '/../env.ini'); // __FILE__ pega o caminho da pasta atual, o ponto concatena e /../ sai da pasta atual para a anterior e ai ele acessa o arquivo env.ini
        $env = parse_ini_file($envPath);
        $conn = new mysqli($env['host'], $env['username'],
            $env['password'], $env['database']); // pega os dados do arquivo, lembrando que o arquivo não será carregado no git pois está no arquivo git ignore
        
            // se tiver erro de conexão
        if($conn->connect_error) {
            die("Erro: " . $conn->connect_error);
        }

        return $conn;
    }

    //pegar o resultado a partir de uma consulta no banco
    public static function getResultFromQuery($sql) {
        $conn = self::getConnection();
        $result = $conn->query($sql);
        $conn->close();
        return $result;
    }

    //executar um sql
    public static function executeSQL($sql) {
        $conn = self::getConnection();
        if(!mysqli_query($conn, $sql)) {
            throw new Exception(mysqli_error($conn));
        }
        $id = $conn->insert_id;
        $conn->close();
        return $id;
    }
}