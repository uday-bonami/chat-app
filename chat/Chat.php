<?php

namespace Chat;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require_once "chatFunction.php";

class Chat implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $numRecv = count($this->clients) - 1;

        echo sprintf(
            'Connection %d sending message "%s" to %d other connection%s' . "\n",
            $from->resourceId,
            $msg,
            $numRecv,
            $numRecv == 1 ? '' : 's'
        );

        $message = json_decode($msg, true);
        if ($message["type"] == "connect") {
            setServerState($message['userId'], $from->resourceId);
            $connectionData = getConnection($message["userId"]);
            $this->sendConnectionMessage($connectionData, $message["userId"]);
        } else if ($message["type"] == "message") {
            $rescourceId = getServerState($message["to"])["resource_id"];
            $message["time"] = time();
            saveMessage($message);
            $this->send($rescourceId, $message);
        } else if ($message["type"] == "call") {
            $rescourceId = getServerState($message["to"])["resource_id"];
            $this->send($rescourceId, $message);
        } else if ($message["type"] == "endcall") {
            $rescourceId = getServerState($message["to"])["resource_id"];
            $this->send($rescourceId, $message);
        } else if ($message["type"] == "acceptcall") {
            $rescourceId = getServerState($message["to"])["resource_id"];
            $token = createCallRoom($message["from"], $message["to"]);
            $message["token"] = $token;
            $this->send($rescourceId, $message);
            $this->send($from->resourceId, $message);
        } else if ($message["type"] == "join-call") {
            $rescourceId = getServerState($message["userId"])["resource_id"];
            $message["confirmation"] = true;
            $this->send($rescourceId, $message);
        } else if ($message["type"] == "offer") {
            $rescourceId = getServerState($message["target"])["resource_id"];
            $this->send($rescourceId, $message);
        } else if ($message["type"] == "ice-candidate") {
            $rescourceId = getServerState($message["target"])["resource_id"];
            $this->send($rescourceId, $message);
        } else if ($message["type"] == "start-call") {
            $rescourceId = getServerState($message["target"])["resource_id"];
            $this->send($rescourceId, $message);
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $stateData = getServerState($conn->resourceId);
        $userId = $stateData["user_id"];
        removeServerState($conn->resourceId);
        $connectionData = getConnection($userId);
        $this->clients->detach($conn);
        updateLastSeen($userId);
        $this->sendDisconnectionMessage($connectionData, $userId);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    private function sendConnectionMessage($connectionData, $userId)
    {
        foreach ($connectionData as $connection) {
            if ($connection["sender"] == $userId) {
                $id = $connection["reciver"];
            } else {
                $id = $connection["sender"];
            }
            $serverState =  getServerState($id);
            $message = array("type" => "connection", "userId" => $userId);
            $this->send($serverState["resource_id"], $message);
        }
    }

    private function sendDisconnectionMessage($connectionData, $userId)
    {
        foreach ($connectionData as $connection) {
            if ($connection["sender"] == $userId) {
                $id = $connection["reciver"];
            } else {
                $id = $connection["sender"];
            }
            $serverState =  getServerState($id);
            $message = array("type" => "disconnection", "userId" => $userId, "last_seen" => time());
            $this->send($serverState["resource_id"], $message);
        }
    }

    private function send($rescourceId, $message)
    {
        print_r($message);
        foreach ($this->clients as $client) {
            if ($client->resourceId == $rescourceId) {
                $client->send(json_encode($message));
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}