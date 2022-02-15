<?php

require_once "base.php";


class Rooms extends Base
{
    private $tableName = 'rooms';

    public function read($token)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE token = '$token'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    private function validateToken($token)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE token = '$token'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if ($result) {
            return false;
        }
        return true;
    }

    private function generateToken()
    {
        $token = $this->getToken();

        if (!$this->validateToken($token)) {
            return $this->generateToken();
        }
        return $token;
    }

    private function getToken()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 30; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function create($data)
    {
        if (array_key_exists("caller", $data) && array_key_exists("reciver", $data)) {
            $caller = $data["caller"];
            $reciver = $data["reciver"];
            $token = $this->generateToken();
            $sql = "INSERT INTO " . $this->tableName . " (
                caller,
                reciver,
                token
            ) VALUES (
                '$caller',
                '$reciver',
                '$token'
            )";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $token;
        }
    }

    public function delete($token)
    {
        $sql = "DELETE FROM " . $this->tableName . " WHERE token = '$token'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }
}
