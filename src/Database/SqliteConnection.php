<?php

namespace App\Database;

use PDO;

class SqliteConnection implements DatabaseConnectionInterface
{
    private $connection;
    private $PATH_TO_SQLITE_FILE = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db/sqlite.db';

    public function connect()
    {
        $this->connection = new PDO("sqlite:" . $this->PATH_TO_SQLITE_FILE);;
        return $this->connection;
    }

    public function disconnect()
    {
        // Lógica de desconexão SQLite
    }

    public function query($sql)
    {
        // Lógica de consulta SQLite
    }

    // Implemente outros métodos CRUD conforme necessário
}
