<?php
// regras de negocio do objeto usuário e acesso ao banco de dados

class User extends Model {

    protected static $tableName = 'users';
    protected static $columns = [
        'id',
        'name',
        'password',
        'email',
        'start_date',
        'end_date',
        'is_admin'
    ];

    public static function obterUsuariosAtivos() {
        return static::obterContador(['raw' => 'end_date IS NULL']);
    }

}
   