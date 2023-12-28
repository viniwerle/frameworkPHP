<?php

namespace App\Database;

use PDO;
use PDOException;

class PostgreSqlConnection implements DatabaseConnectionInterface
{
    protected $connection;

    public function connect()
    {
        $host = getenv('DB_HOST'); //é o nome da maquina utilizada no docker compose
        $user  = getenv('DB_USER');
        $password  = getenv('DB_PASSWORD');
        $dbname  = getenv('DB_DATABASE');
        $port = getenv('DB_PORT');

        try {
            // Criar uma conexão
            self::$connection = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);

            // Configurar o modo de erro para exceções
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Agora você pode executar consultas SQL usando $conn
        } catch (PDOException    $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
        return self::$connection;
    }

    public function disconnect()
    {
        // Lógica de desconexão PostgreSQL
    }

    public function query($sql)
    {
        // Lógica de consulta PostgreSQL
    }

    // Implemente outros métodos CRUD conforme necessário
}
