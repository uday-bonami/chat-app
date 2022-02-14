<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "../model/chat_message.php";
require_once "../model/users.php";


$entityBody = file_get_contents('php://input');
$data = json_decode($entityBody, true);

if (isset($data["sender"]) && isset($data["reciver"])) {
    $chatMessage = new ChatMessage();
    $sender = $chatMessage->preventSqlInjection($data["sender"]);
    $reciver = $chatMessage->preventSqlInjection($data["reciver"]);
    $chatMessage->updateMessageStatus($sender, $reciver);
} else {
    header("HTTP/1.0 404 Not Found");
    die();
}
