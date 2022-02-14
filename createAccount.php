<?php
require_once "model/users.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $users = new Users();
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $data = array(
        "username" => $username,
        "email" => $email,
        "password" => $password
    );
    $users->create($data);
    header("Location: ./login.php");
    die();
}
?>
<?php require_once "header.php" ?>
<div class="center">
    <div class="card">
        <form method="post">
            <div class="mb-3">
                <label for="exampleInputUsername" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="exampleInputUsername"
                    aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword2" class="form-label">Conform Password</label>
                <input name="conform-password" type="password" class="form-control" id="exampleInputPassword2">
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<?php require_once "footer.php" ?>