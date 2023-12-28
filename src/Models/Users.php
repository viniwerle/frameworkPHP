<?php

namespace App\Models;

use App\Config\Model;

class Users extends Model
{
    public function getAll()
    {
        $sql = "SELECT * FROM Users";
        $result = $this->dbConnection->query($sql);
        return $result;
    }

    public function getByEmail($email)
    {
        $sql = "SELECT * FROM Users WHERE Email = ?";
        $result = $this->dbConnection->queryFetch($this->buildSafeSQL($sql, [$email]));
        return $result;
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM Users WHERE id = ?";
        $result = $this->dbConnection->queryFetch($this->buildSafeSQL($sql, [$id]));
        return $result;
    }

    public function create($data)
    {
        $sql = "INSERT INTO `Users`         (`Name`,         `Email`,         `Hash`,        `Salt`)
        VALUES (?, ?,?,?)";
        return $this->dbConnection->queryLastId($this->buildSafeSQL($sql, [$data['Name'], $data['Email'], $data['Hash'], $data['Salt']]));
    }

    /*public function update($id, $data)
    {
        $sql = "UPDATE contas SET nome = ?, saldo = ? WHERE id = ?";
        $this->dbConnection->query($this->buildSafeSQL($sql, [$data['nome'], $data['saldo'], $id]));
    }

    public function delete($id)
    {
        $sql = "DELETE FROM contas WHERE id = ?";
        $this->dbConnection->query($this->buildSafeSQL($sql, [$id]));
    }*/

    public function seed()
    {
        $this->RemoveAndCreateTabele();
    }
    private function RemoveAndCreateTabele()
    {
        $sql[] = "DROP TABLE Users";
        $sql[] = "CREATE TABLE IF NOT EXISTS `Users` (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `Name` varchar(255) NOT NULL,
            `Email` varchar(255) NOT NULL,
            `Hash` varchar(255) NOT NULL,
            `Salt` varchar(255) NOT NULL,
            `Create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `Update_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (`ID`)
          )";
        foreach ($sql as $i) {
            $this->dbConnection->query($i);
        }
    }
}
