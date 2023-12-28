<?php

namespace App\Database;

use PDO;
use PDOException;

class MySqlConnection implements DatabaseConnectionInterface
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
            $this->connection = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $user, $password);

            // Configurar o modo de erro para exceções
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Agora você pode executar consultas SQL usando $conn
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public function quote($string)
    {
        return $this->connection->quote($string);
    }

    public function disconnect()
    {
        // Lógica de desconexão MySQL
    }

    private function executeSql($sql, &$_query = null)
    {
        $_query = $this->connection->prepare($sql);
        $_query->execute();
    }

    public function query($sql)
    {
        try {
            $this->executeSql($sql, $_query);
            return $_query;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function queryFetch($sql)
    {
        try {
            $this->executeSql($sql, $_query);
            return $_query->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
    public function queryLastId($sql)
    {
        try {
            $this->executeSql($sql, $_query);
            return $_query->lastInsertId();
        } catch (PDOException $e) {
            return false;
        }
    }

    // Implemente outros métodos CRUD conforme necessário
}
