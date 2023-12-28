<?php

namespace App\Database;

use Exception;

class DatabaseConnectionFactory
{
    public static function createConnection()
    {
        switch (getenv('DB_TYPE')) {
            case 'MYSQL':
                return new MySqlConnection();
            case 'SQLITE':
                return new SqliteConnection();
            case 'POSTGRESQL':
                return new PostgreSqlConnection();
            default:
                throw new Exception('Tipo de banco de dados não suportado');
        }
    }
}
