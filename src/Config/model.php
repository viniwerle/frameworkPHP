<?php

namespace App\Config;

abstract class Model
{
    private static $connection;
    private static  $PATH_TO_SQLITE_FILE = __DIR__ . DIRECTORY_SEPARATOR .  '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db\sqlite.db';
    protected $table;
    private $colunsQuery;
    private $query;
    private $where = array();
    public function __construct(array $attributes = [])
    {
        if (self::$connection == null) {
            self::$connection = new \PDO("sqlite:" . self::$PATH_TO_SQLITE_FILE);;
        }
    }

    /**
     * Obter todos os registros.
     *
     * @param array $columns As colunas a serem selecionadas.
     * @return array Retorna os registros correspondentes.
     */
    public function all($columns = ['*'])
    {
        return $this->select($columns);
    }

    /**
     * Adicionar condições WHERE dinamicamente.
     *
     * @param array $conditions As condições para a cláusula WHERE.
     * @return $this
     */
    public function addWhere(array $conditions)
    {
        $this->where = array_merge($this->where, $conditions);
        return $this;
    }

    /**
     * Realizar uma consulta SELECT.
     *
     * @param array $columns As colunas a serem selecionadas.
     * @return array Retorna os resultados da consulta.
     */

    public function select($columns)
    {
        $this->columnsQuery = implode(', ', $columns);
        $sql = "SELECT {$this->columnsQuery} FROM {$this->table}";
        $whereClause = $this->buildWhereClause();
        if ($whereClause != '') {
            $sql = "SELECT {$this->columnsQuery} FROM {$this->table} {$whereClause}";
        }

        $this->query = self::$connection->prepare($sql);
        $this->query->execute();
        return $this->fetch();
    }

    public function insert($data)
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";

        $query = self::$connection->prepare($sql);
        $query->execute($data);
        return self::$connection->lastInsertId();
    }

    public function update($data, $id)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "{$key} = :{$key}";
        }
        $set = implode(', ', $set);
        $sql = "UPDATE {$this->table} SET {$set} WHERE id = :id";

        $data['id'] = $id;
        $query = self::$connection->prepare($sql);
        return $query->execute($data);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";

        $query = self::$connection->prepare($sql);
        return $query->execute(['id' => $id]);
    }


    /**
     * Concatena as condições de WHERE.
     *
     * @return string As condições de WHERE concatenadas.
     */
    private function buildWhereClause()
    {
        $conditions = $this->where;
        if (empty($conditions)) {
            return '';
        }
        $whereClause = 'WHERE ';
        $conditionsArray = [];
        foreach ($conditions as $key => $value) {
            $conditionsArray[] = "{$key} = {$value}";
        }

        return $whereClause .= implode(' AND ', $conditionsArray);
    }


    private function fetch()
    {
        return $this->query->fetch(\PDO::FETCH_ASSOC);
    }
}
