<?php
session_start();
require_once "model/rooms.php";
require_once "model/users.php";

if (!isset($_SESSION['userData'])) {
    header("Location: ./login.php");
    die();
}

if (isset($_GET['token'])) {
    $rooms = new Rooms();
    $users = new Users();
    $token = $_GET['token'];
    $roomData = $rooms->read($token)[0];
    $userData = $_SESSION['userData'];

    if ($roomData) {
        $caller = $roomData["caller"];
        $reciver = $roomData["reciver"];
        $isCaller = ($caller == $userData["id"]) ? 1 : 0;
        if ($isCaller == 1) {
            $target = $reciver;
        } else {
            $target = $caller;
        }
        $targetData = $users->getUserById($target);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://unpkg.com/peerjs@1.3.1/dist/peerjs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link rel="stylesheet" href="./assests/css/call.css">
    <script>
    const isCaller = <?php echo $isCaller ?>;
    const userId = parseInt("<?php echo $userData["id"] ?>");
    const target = parseInt("<?php echo $target ?>");
    </script>
    <title>Chat App call</title>
</head>

<body>
    <nav style="background-color: #e04e67">
        <div class="nav-wrapper">
            <a href="#" class="brand-logo">A sign of love</a>
        </div>
    </nav>
    <div class="main">
        <div id="user-screen" class="center">
            <div style="position: relative; padding: 25px; display: flex; align-items: center; justify-content: center; width: 100%; height: 100%"
                class="container">
                <video autoplay id="my-video"></video>
                <div class="video-container">
                    <video autoplay id="connection-video"></video>
                </div>
                <div class="caller-card">
                    <img src="./profile_img/default-avatar.png" alt="user-img"
                        style="width: 100px; height: 100px; border-radius: 50%;">
                    <h2 style="color: white"><?php echo $targetData["username"] ?></h2>
                </div>
            </div>
        </div>
        <div class="bottom-button">
            <button id="leave" class="btn waves-effect waves-light call-button" style="background-color: #c62828">
                <span class="material-icons">
                    call_end
                </span>

            </button>
            <button id="mic-btn" class="btn waves-effect waves-light call-button" type="submit" name="action">
                <span class="material-icons">
                    mic
                </span>
            </button>
            <button id="web-cam" class="btn waves-effect waves-light call-button" type="submit" name="action"><span
                    class="material-icons">
                    videocam
                </span>
            </button>
        </div>
    </div>
    <script src="./assests/js/call2.js"></script>
</body>

</html>