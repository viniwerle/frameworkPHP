<?php

namespace App\Config;

abstract class Model
{
    private static $connection;
    private static $PATH_TO_SQLITE_FILE = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'db\sqlite.db';
    protected $table;
    private $query;
    private $where = array();

    /**
     * Construtor da classe Model.
     *
     * @param array $attributes Atributos opcionais.
     */
    public function __construct(array $attributes = [])
    {
        if (self::$connection == null) {
            self::$connection = new \PDO("sqlite:" . self::$PATH_TO_SQLITE_FILE);;
        }
    }

    /**
     * Obter todos os registros.
     *
     * @param array $columns As colunas a serem selecionadas (opcional).
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
     * @return void
     */
    public function addWhere(array $conditions)
    {
        $this->where = array_merge($this->where, $conditions);

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

    /**
     * Inserir um novo registro.
     *
     * @param array $data Os dados a serem inseridos.
     * @return int|null Retorna o ID do último registro inserido ou null em caso de falha.
     */
    public function insert($data)
    {
        $columns = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";

        $query = self::$connection->prepare($sql);
        $query->execute($data);
        return self::$connection->lastInsertId();
    }

    /**
     * Atualizar registros com base em condições WHERE.
     *
     * @param array $data Os dados a serem atualizados.
     * @return bool Retorna true em caso de sucesso ou false em caso de falha.
     */
    public function update($data)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "{$key} = '{$value}'";
        }
        $set = implode(', ', $set);
        $whereClause = $this->buildWhereClause();
        if ($whereClause != '') {
            $sql = "UPDATE {$this->table} SET {$set} {$whereClause}";
        } else {
            return false;
        }
        $query = self::$connection->prepare($sql);
        return $query->execute();
    }

    /**
     * Excluir um registro com base no ID.
     *
     * @param int $id O ID do registro a ser excluído.
     * @return bool Retorna true em caso de sucesso ou false em caso de falha.
     */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";

        $query = self::$connection->prepare($sql);
        return $query->execute(['id' => $id]);
    }

    /**
     * Concatenar as condições de WHERE.
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
