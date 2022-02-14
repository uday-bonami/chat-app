<?php

require_once "base.php";


class Users extends Base
{
    private $tableName = 'users';

    public function read($email = null)
    {
        if ($email) {
            $sql = "SELECT * FROM " . $this->tableName . " WHERE email = '$email'";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
        } else {
            $sql = "SELECT * FROM " . $this->tableName;
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll();
        }
        return $result;
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE id = '$id'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        if ($result) {
            return $result[0];
        }
        return null;
    }

    public function create($data)
    {
        if (
            array_key_exists("username", $data) &&
            array_key_exists("password", $data) &&
            array_key_exists("email", $data)
        ) {
            $username = $data["username"];
            $password = $data["password"];
            $email = $data["email"];
            $sql = "INSERT INTO " . $this->tableName . " (
                username,
                email,
                password
            ) VALUES (
                '$username',
                '$email',
                '$password'
            )";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
    }

    public function update($updatedData, $id)
    {
        $keys = array_keys($updatedData);
        foreach ($keys as $key) {
            $value = $updatedData[$key];
            $sql = "UPDATE " . $this->tableName . " SET " . $key . " = " . " '$value' " . " WHERE id = '$id'";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
    }


    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->tableName . " WHERE id = '$id'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }
}