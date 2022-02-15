<?php
require_once "./model/server_state.php";
require_once "./model/chat_message.php";
require_once "./model/connection.php";
require_once "./model/users.php";
require_once "./model/rooms.php";


function setServerState($userId, $resourceId)
{
    $serverState = new ServerState();
    $stateData = array(
        "user_id" => $userId,
        "resource_id" => $resourceId
    );
    $serverState->create($stateData);
}

function getServerState($userId)
{
    $serverState = new ServerState();
    $severStateData = $serverState->read($userId);
    if ($severStateData) {
        return $severStateData[0];
    }
    return null;
}

function removeServerState($resource_id)
{
    $serverState = new ServerState();
    $serverState->delete($resource_id);
}

function saveMessage($message)
{
    $chatMessage = new ChatMessage();
    if (!array_key_exists("isFile", $message)) {
        $saveMessage = array(
            "reciver" => $message["to"],
            "sender" => $message["from"],
            "message" => $message["message"]
        );
        $chatMessage->create($saveMessage);
    } else if (array_key_exists("isFile", $message)) {
        $saveMessage = array(
            "reciver" => $message["to"],
            "sender" => $message["from"],
            "message" => $message["url"]
        );
        if ($message["format"] == "img") {
            $chatMessage->create($saveMessage, $media_status = 1);
        } else {
            $chatMessage->create($saveMessage, $media_status = 2);
        }
    }
}

function getConnection($id)
{
    $connection = new Connection();
    $connectionData = $connection->read($id);
    return $connectionData;
}

function updateLastSeen($userId)
{
    $updatedData = array("last_seen" => date("Y-m-d H:i:s"));
    $users = new Users();
    $users->update($updatedData, $userId);
}

function createCallRoom($caller, $reciver)
{
    $rooms = new Rooms();
    $roomData = array("caller" => $caller, "reciver" => $reciver);
    $token = $rooms->create($roomData);
    return $token;
}