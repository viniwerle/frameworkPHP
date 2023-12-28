<?php

namespace App\Config;

use App\Database\DatabaseConnectionFactory;

abstract class Model
{
    protected $dbConnection;

    public function __construct()
    {
        // Crie uma instância da classe de conexão apropriada usando a fábrica
        $this->dbConnection = DatabaseConnectionFactory::createConnection();
        $this->dbConnection->connect();
    }

    public function __destruct()
    {
        // Desconecte-se do banco de dados ao destruir o objeto
        $this->dbConnection->disconnect();
    }

    // Função para montar SQL seguro
    protected function buildSafeSQL($sql, $params = [])
    {
        foreach ($params as $key => $value) {
            $params[$key] = $this->dbConnection->quote($value);
        }
        return vsprintf(str_replace('?', '%s', $sql), $params);
    }
}
