<?php
session_start();
require_once "model/connection.php";
require_once "model/users.php";
require_once "model/chat_message.php";
require_once "model/server_state.php";


if (!isset($_SESSION["userData"])) {
    header("Location: ./login.php");
    die();
}

function getMessages($sender, $reciver)
{
    $chatMessage = new ChatMessage();
    $result = $chatMessage->read($sender, $reciver);
    return $result;
}

function getUnreadedMessages($sender, $reciver)
{
    $chatMessage = new ChatMessage();
    $result = $chatMessage->getUnreadedMessages($sender, $reciver);
    return $result;
}

function getReadedMessage($sended, $reciver)
{
    $chatMessage = new ChatMessage();
    $result = $chatMessage->getReadedMessages($sended, $reciver);
    return $result;
}

function getTime($timestamp)
{
    $unixTimeStamp = strtotime($timestamp);
    $hour = date("H", $unixTimeStamp);
    $minute = date("i", $unixTimeStamp);
    $ampm = "am";
    if ($hour > 12) {
        $hour = $hour - 12;
        $ampm = "pm";
    }
    return "$hour:$minute$ampm";
}

$connection = new Connection();
$serverState = new ServerState();
$users = new Users();
$userData = $_SESSION["userData"];
$connections = $connection->read($userData["id"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FONT AWESOME CND -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <!-- STYLE SHEET -->
    <link rel="stylesheet" href="./assests/css/global.css">
    <link rel="stylesheet" href="./assests/css/login.css">
    <link rel="stylesheet" href="./assests/css/signup.css">
    <link rel="stylesheet" href="./assests/css/Home.css">
    <link rel="stylesheet" href="./assests/css/footer.css">
    <link rel="stylesheet" href="./assests/css/navbar.css">
    <link rel="stylesheet" href="./assests/css/responsive.css">
    <link rel="stylesheet" href="./assests/css/userDash.css">
    <link rel="stylesheet" href="./assests/css/checkOut.css">
    <link rel="stylesheet" href="./assests/css/DetailsFrom.css">
    <link rel="stylesheet" href="./assests/css/about.css">
    <link rel="stylesheet" href="./assests/css/Dating.css">
    <link rel="stylesheet" href="./assests/css/Chat.css">
    <link rel="stylesheet" href="./assests/css/contact.css">
    <link rel="stylesheet" href="./assests/css/userProfileData.css">
    <link rel="stylesheet" href="./assests/css/service.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"
        integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/notie/dist/notie.min.css">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
    const userId = "<?php echo $userData["id"]; ?>"
    const userEmail = "<?php echo $userData["email"]; ?>"
    const username = "<?php echo $userData["username"]; ?>"
    </script>
</head>

<body style="overflow: hidden">
    <div class="chat_Container">
        <div class="call-window" id="call-window">
            <div class="calling-modal">
                <img src="./profile_img/default-avatar.png" alt="user-img"
                    style="width: 100px; height: 100px; border-radius: 50%">
                <h3 class="name" id="username">Username</h3>
                <p style="color: white; margin: 10px">Calling...</p>
                <button class="end-call" id="end-call">
                    <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px" fill="white">
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M12 9c-1.6 0-3.15.25-4.6.72v3.1c0 .39-.23.74-.56.9-.98.49-1.87 1.12-2.66 1.85-.18.18-.43.28-.7.28-.28 0-.53-.11-.71-.29L.29 13.08c-.18-.17-.29-.42-.29-.7 0-.28.11-.53.29-.71C3.34 8.78 7.46 7 12 7s8.66 1.78 11.71 4.67c.18.18.29.43.29.71 0 .28-.11.53-.29.71l-2.48 2.48c-.18.18-.43.29-.71.29-.27 0-.52-.11-.7-.28-.79-.74-1.69-1.36-2.67-1.85-.33-.16-.56-.5-.56-.9v-3.1C15.15 9.25 13.6 9 12 9z" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="call-window" id="recive-call-window">
            <div class="calling-modal">
                <img src="./profile_img/default-avatar.png" alt="user-img"
                    style="width: 100px; height: 100px; border-radius: 50%">
                <h3 class="name" id="caller-name">Username</h3>
                <p style="color: white; margin: 10px">Calling...</p>
                <div style="display: flex">
                    <button style="margin: 0px 10px" id="accept-call">
                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px"
                            fill="white">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z" />
                        </svg>
                    </button>
                    <button class="end-call" id="end-call">
                        <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 0 24 24" width="30px"
                            fill="white">
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M12 9c-1.6 0-3.15.25-4.6.72v3.1c0 .39-.23.74-.56.9-.98.49-1.87 1.12-2.66 1.85-.18.18-.43.28-.7.28-.28 0-.53-.11-.71-.29L.29 13.08c-.18-.17-.29-.42-.29-.7 0-.28.11-.53.29-.71C3.34 8.78 7.46 7 12 7s8.66 1.78 11.71 4.67c.18.18.29.43.29.71 0 .28-.11.53-.29.71l-2.48 2.48c-.18.18-.43.29-.71.29-.27 0-.52-.11-.7-.28-.79-.74-1.69-1.36-2.67-1.85-.33-.16-.56-.5-.56-.9v-3.1C15.15 9.25 13.6 9 12 9z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="container-fluid cover">
            <div class="row cover2">
                <div class="col-2 chat_container-1 p-4">
                    <div class="d-flex align-items-center chat_container-1-semi1">
                        <span class="chat_arrow"><i class="fas fa-chevron-left"></i></span>
                        <p class="mb-0 ms-2 chat_container-1-menu">Menu</p>
                    </div>
                    <div class="
              mt-5
              chat_container-1-semi2
              d-flex
              justify-content-center
              p-4
            ">
                        <div>
                            <div class="chat_container-1-semi2-profile text-center">
                                <img style="width: 100px; height: 100px; border-radius: 50%"
                                    src="./profile_img/default-avatar.png" />
                                <p class="chat_container-1-semi2-profile-para1 mb-0 mt-2">
                                    <?php echo $userData["username"] ?>
                                </p>
                                <!-- <p class="chat_container-1-semi2-profile-para2">Designer</p> -->
                            </div>
                            <div class="d-flex justify-content-center">
                                <ul class="p-0 chat_container-1-semi2-profile-ul">
                                    <li class=""><a href="#" class="profile_link"><img
                                                src="./assests/chatImg/Vector.svg" class="me-2">
                                            Activity</a>
                                    </li>
                                    <li><a href="#" class="profile_link"><img src="./assests/chatImg/Add User.svg"
                                                class="me-2">
                                            Profile</a>
                                    </li>
                                    <li><a href="#" class="profile_link"><img src="./assests/chatImg/Chat.svg"
                                                class="me-2"></i>
                                            Message</a>
                                    </li>
                                    <li><a href="#" class="profile_link"><img src="./assests/chatImg/Notification.svg"
                                                class="me-2">
                                            Notification</a>
                                    </li>
                                    <li><a href="#" class="profile_link"><img src="./assests/chatImg/setting.svg"
                                                class="me-2">
                                            Settings</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 chat_container-2 p-4 people">
                    <div class="chat_container-2-semi1 d-flex">
                        <p class="mb-0 me-3">Smile Chat</p>
                        <img src="./assests/chatImg/emoji.png">
                    </div>
                    <div class="mt-4 chat_container-2-semi2 ps-4">
                        <img src="./assests/chatImg/search.svg">
                        <input type="text" placeholder="Search">
                    </div>
                    <div class="chat_container-2-semi3">
                        <div class="row mt-4 align-items-center">
                            <div class="col-6">
                                <select class="form-select chat_select" aria-label="Default select example">
                                    <option selected>Open this</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <button class="newchat_btn d-flex align-items-center justify-content-center"><i
                                        class="far fa-comment-dots chat_icon me-2"></i>New Chat</button>
                            </div>
                        </div>
                        <ul class="p-0">
                            <?php foreach ($connections as $c) : ?>
                            <?php
                                if ($c["sender"] != $userData["id"]) {
                                    $connectionData = $users->getUserById($c["sender"]);
                                } else {
                                    $connectionData = $users->getUserById($c["reciver"]);
                                }
                                ?>
                            <li class="mt-4 chat_container-2-semi3-list px-2 connection"
                                id="<?php echo $connectionData["id"] ?>">
                                <div class="d-flex justify-content-between info">
                                    <div class="d-flex align-items-center">
                                        <div class="relative">
                                            <img class="img-fluid me-3"
                                                style="width: 50px; height: 50px; border-radius: 50%"
                                                src="./profile_img/default-avatar.png">
                                            <?php if ($serverState->isOnline($connectionData["id"])) : ?>
                                            <span id="online-status-<?php echo $connectionData["id"]; ?>"
                                                class="active"></span>
                                            <?php else : ?>
                                            <span id="online-status-<?php echo $connectionData["id"]; ?>"
                                                class="unactive"></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="ms-3">
                                            <p class="chat_container-2-semi3-list-para1">
                                                <?php echo $connectionData["username"] ?></p>
                                            <!-- <p class="chat_container-2-semi3-list-para2">Good to see you.</p> -->
                                        </div>
                                    </div>
                                    <?php $umessage = getUnreadedMessages($connectionData["id"], $userData["id"]) ?>
                                    <?php if ($umessage) : ?>
                                    <div class="message-number">
                                        <?php echo count($umessage) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div id="chat-window" class="col-7 chat_container-3 p-4 chat-window">
                    <div id="selected-window" class="empty-chat-window">
                        <img src="./assests/images/chat.svg" alt="chat-img">
                        <h1 style="color: white; margin: 10px">Begin Chat</h1>
                    </div>
                    <?php foreach ($connections as $_c) : ?>
                    <?php
                        if ($_c["sender"] != $userData["id"]) {
                            $id = $_c["sender"];
                        } else {
                            $id = $_c["reciver"];
                        }
                        ?>
                    <?php $connectionData = $users->getUserById($id); ?>
                    <?php $messages = getMessages($userData["id"], $id); ?>
                    <?php $readedMessage = getReadedMessage($userData["id"], $id) ?>
                    <?php $unreadedMessage = getUnreadedMessages($id, $userData["id"]) ?>
                    <div class="connection-chat <?php echo $id; ?>" style="display: none">
                        <div>
                            <div style="padding: 10px; position: sticky; top: 0px"
                                class="col-12 chat_container-3-semi1 d-flex justify-content-between align-items-center py-3">
                                <div class="chat_container-3-semi1-semi1 d-flex align-items-center">
                                    <div class="relative">
                                        <img src="./profile_img/default-avatar.png"
                                            style="width: 50px; height: 50px; border-radius: 50%;"
                                            class="img-fluid me-3">
                                        <span class="active"></span>
                                    </div>
                                    <div class="chat_container-3-semi1-semi2">
                                        <p class="chat_container-3-semi1-semi2-para1">
                                            <?php echo $connectionData["username"] ?>
                                        </p>
                                        <?php if ($serverState->isOnline($connectionData["id"])) : ?>
                                        <p class="chat_container-3-semi1-semi2-para2"
                                            id="last-seen-<?php echo $connectionData["id"] ?>">Online</p>
                                        <?php else : ?>
                                        <p class="chat_container-3-semi1-semi2-para2"
                                            id="last-seen-<?php echo $connectionData["id"] ?>">
                                            Last seen at <?php echo $connectionData["last_seen"] ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <button class="join-call"
                                        style="width: 50px; height: 50px; border-radius: 50%; border: none; background-color: #e04e67"
                                        id="join-call">
                                        <i style="color: white" class="fa-solid fa-phone"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php foreach ($readedMessage as $rmessage) : ?>
                        <?php if ($rmessage["sender"] == $userData["id"]) : ?>
                        <div class="col-12 mt-5">
                            <div class="row justify-content-end">
                                <div class="col-2">
                                    <p class="chat_timing text-end"><?php echo getTime($rmessage["datetime"]) ?></p>
                                    <?php if ($rmessage["media_status"] == 0) : ?>
                                    <p class="text-white chat_box3 py-2 text-center mt-1">
                                        <?php echo $rmessage["message"] ?></p>
                                    <?php elseif ($rmessage["media_status"] == 1) : ?>
                                    <img class="send_img" src="<?php echo $rmessage["message"] ?>" alt="image">
                                    <?php elseif ($rmessage["media_status"] == 2) : ?>
                                    <video width="320" height="240" controls>
                                        <source src="<?php echo $rmessage["message"] ?>" />
                                    </video>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php else : ?>
                        <div class="col-7 chat_container-3-semi2 mt-5 d-flex align-items-start">
                            <img style="width: 50px; height: 50px; border-radius: 50%"
                                src="./profile_img/default-avatar.png" class="img-fluid">
                            <div class="ms-3">
                                <div class="d-flex align-items-end">
                                    <p class="chat_container-3-semi2-semi1-para1">
                                        <?php echo $users->getUserById($rmessage["sender"])["username"] ?></p>
                                    <p class="chat_timing ms-3"><?php echo getTime($rmessage["datetime"]) ?></p>
                                </div>
                                <?php if ($rmessage["media_status"] == 0) : ?>
                                <div class="chat_box2 p-4 mt-2">
                                    <p class="chat_container-3-semi2-semi2-para2"><?php echo $rmessage["message"] ?></p>
                                </div>
                                <?php elseif ($rmessage["media_status"] == 1) : ?>
                                <a href="<?php echo $rmessage["message"] ?>" download>
                                    <div class="chat_box2 p-4 mt-2">
                                        <div class="hover_button">
                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                        </div>
                                        <img style="width: 300px; height: auto" src="<?php echo $rmessage["message"] ?>"
                                            alt="image">
                                    </div>
                                </a>
                                <?php elseif ($rmessage["media_status"] == 2) : ?>
                                <div class="chat_box2 p-4 mt-2">
                                    <video width="320" height="240" controls>
                                        <source src="<?php echo $rmessage["message"] ?>" />
                                    </video>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if ($unreadedMessage) : ?>
                        <div class="unreaded-container">
                            <div class="line"></div>
                            <div class="Unreaded-text">Unreaded Messages</div>
                            <div class="line"></div>
                        </div>
                        <?php endif; ?>
                        <?php foreach ($unreadedMessage as $umessage) : ?>
                        <?php if ($umessage["sender"] == $userData["id"]) : ?>
                        <div class="col-12 mt-5">
                            <div class="row justify-content-end">
                                <div class="col-2">
                                    <p class="chat_timing text-end"><?php echo getTime($umessage["datetime"]) ?></p>
                                    <?php if ($umessage["media_status"] == 0) : ?>
                                    <p class="text-white chat_box3 py-2 text-center mt-1">
                                        <?php echo $umessage["message"] ?></p>
                                    <?php elseif ($umessage["media_status"] == 1) : ?>
                                    <img class="send_img" src="<?php echo $umessage["message"] ?>" alt="image">
                                    <?php elseif ($umessage["media_status"] == 2) : ?>
                                    <video width="320" height="240" controls>
                                        <source src="<?php echo $umessage["message"] ?>" />
                                    </video>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php else : ?>
                        <div class="col-7 chat_container-3-semi2 mt-5 d-flex align-items-start">
                            <img style="width: 50px; height: 50px; border-radius: 50%"
                                src="./profile_img/default-avatar.png" class="img-fluid">
                            <div class="ms-3">
                                <div class="d-flex align-items-end">
                                    <p class="chat_container-3-semi2-semi1-para1">
                                        <?php echo $users->getUserById($umessage["sender"])["username"] ?></p>
                                    <p class="chat_timing ms-3"><?php echo getTime($umessage["datetime"]) ?></p>
                                </div>
                                <?php if ($umessage["media_status"] == 0) : ?>
                                <div class="chat_box2 p-4 mt-2">
                                    <p class="chat_container-3-semi2-semi2-para2"><?php echo $umessage["message"] ?></p>
                                </div>
                                <?php elseif ($umessage["media_status"] == 1) : ?>
                                <div class="chat_box2 p-4 mt-2">
                                    <a href="<?php echo $umessage["message"] ?>" download>
                                        <div class="chat_box2 p-4 mt-2">
                                            <div class="hover_button">
                                                <i class="fa-solid fa-cloud-arrow-down"></i>
                                            </div>
                                            <img style="width: 300px; height: auto"
                                                src="<?php echo $umessage["message"] ?>" alt="image">
                                        </div>
                                    </a>
                                </div>
                                <?php elseif ($umessage["media_status"] == 2) : ?>
                                <div class="chat_box2 p-4 mt-2">
                                    <video width="320" height="240" controls>
                                        <source src="<?php echo $umessage["message"] ?>" />
                                    </video>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endforeach; ?>
                    <!-- <div class="show-file">
                        <div class="file"></div>
                    </div> -->
                    <div class="chat-input-container">
                        <div id="upload-file-container" class="position-relative">
                            <label for="" style="width: 100%" class="control-label-file">
                                <div class="fileupload">
                                    <div>
                                        <i style="color: white" class="fas fa-link"></i>
                                    </div>
                                    <input style="cursor: pointer; width: 100%" type="file" id="upload-file-input"
                                        name="upload-file">
                                </div>
                            </label>
                        </div>
                        <!-- <button id="upload-file" class="position-relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white"
                                class="bi bi-link-45deg" viewBox="0 0 16 16">
                                <path
                                    d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z" />
                                <path
                                    d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z" />
                            </svg>
                        </button> -->
                        <input type="text" placeholder="Type a message" id="chat-input">
                        <button id="send-msg-btn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white"
                                class="bi bi-send" viewBox="0 0 16 16">
                                <path
                                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Footer -->
        <!-- <script src="./assests/js/main.js"></script> -->
        <script src="./assests/js/chat.js"></script>
        <!-- Footer -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
</body>

</html>