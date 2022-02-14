<?php

require_once "base.php";


class ServerState extends Base
{
    private $tableName = "server_state";

    public function read($userId)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE user_id = '$userId' OR resource_id = '$userId'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function isOnline($userId)
    {
        $data = $this->read($userId);
        if ($data) {
            return true;
        }
        return false;
    }

    public function create($data)
    {
        if (array_key_exists("user_id", $data) && array_key_exists("resource_id", $data)) {
            $userId = $data["user_id"];
            $resourceId = $data["resource_id"];
            $sql = "INSERT INTO " . $this->tableName . " (user_id, resource_id) VALUES (
                '$userId',
                '$resourceId'
            )";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->tableName . " WHERE resource_id = '$id'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }
}
