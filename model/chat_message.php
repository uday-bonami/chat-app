<?php

require_once "base.php";


class ChatMessage extends Base
{
    private $tableName = "chat_message";

    public function read($sender, $reciver)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE (sender = '$sender' OR sender = '$reciver') AND (reciver = '$reciver' OR reciver = '$sender')";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function create($data, $media_status = 0)
    {
        if (array_key_exists("reciver", $data) && array_key_exists("sender", $data) && array_key_exists("message", $data)) {
            $reciver = $this->preventSqlInjection($data["reciver"]);
            $sender = $this->preventSqlInjection($data["sender"]);
            $message = $this->preventSqlInjection($data["message"]);
            $datetime = date("Y-m-d H:i:s");
            $sql = "INSERT INTO " . $this->tableName . " (
                reciver, 
                sender, 
                message, 
                datetime,
                media_status
                ) VALUES (
                '$reciver', 
                '$sender', 
                '$message', 
                '$datetime',
                '$media_status'
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

    public function updateMessageStatus($sender, $reciver)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE (sender = '$sender' AND reciver = '$reciver') AND reading_status = '0'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $unreadedMessages = $stmt->fetchAll();
        foreach ($unreadedMessages as $message) {
            $id = $message["id"];
            $updatedData = array("reading_status" => 1);
            $this->update($updatedData, $id);
        }
    }

    public function getReadedMessages($sender, $reciver)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE ((sender = '$sender' OR sender = '$reciver') AND (reciver = '$reciver' OR reciver = '$sender')) AND reading_status = '1'";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getUnreadedMessages($sender, $reciver)
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE (sender = '$sender' AND reciver = '$reciver') AND reading_status = '0'";
        $stmt  = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }


    public function delete()
    {
        // ...
    }
}