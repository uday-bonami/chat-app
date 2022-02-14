<?php
require_once "./model/connection.php";

if (isset($_GET["sender"]) && isset($_GET["reciver"])) {
    $sender = $_GET["sender"];
    $reciver = $_GET["reciver"];
    $connection = new Connection();
    $data = array("sender" => $sender, "reciver" => $reciver);
    $connection->create($data);
    header("Location: ./index.php");
    die();
}