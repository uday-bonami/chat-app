<?php
require_once "model/users.php";
session_start();

if (!isset($_SESSION["userData"])) {
    header('Location: login.php');
    die();
}
$users = new Users();
$connections = $users->read();
$userData = $_SESSION["userData"];
?>
<?php require_once "header.php" ?>
<div class="profile-info">
    <div class="user-info">
        <img class="profile-img" src="./profile_img/default-avatar.png" alt="profile-img">
        <div class="info">
            <h1><?php echo $userData["username"] ?></h1>
            <p><?php echo $userData["email"] ?></p>
        </div>
    </div>
</div>
<div class="connections">
    <ul class="list-group list-group-flush connection">
        <?php foreach ($connections as $connection) : ?>
        <?php if ($connection["id"] != $userData["id"]) : ?>
        <li class="list-group-item list-group-item-dark connection">
            <div class="li-flex">
                <p>
                    <?php echo $connection["username"] ?>
                </p>
                <a href="./add.php?sender=<?php echo $userData["id"] ?>&reciver=<?php echo $connection["id"] ?>"
                    type="button" class="btn btn-primary">Connect</a>
            </div>
        </li>
        <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>
<?php require_once "footer.php" ?>