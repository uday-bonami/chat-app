<?php
require_once "base.php";


class Connection extends Base
{
    private $tableName = "connection";

    public function read($id)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE sender = '$id' OR reciver = '$id'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function create($data)
    {
        if (array_key_exists('sender', $data) && array_key_exists('reciver', $data)) {
            $sender = $data['sender'];
            $reciver  = $data['reciver'];
            $sql = "INSERT INTO " . $this->tableName . " (sender, reciver) VALUES ('$sender', '$reciver')";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
        }
    }
}
