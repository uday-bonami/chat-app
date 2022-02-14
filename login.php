<?php
require_once "model/users.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $users = new Users();
    $userData = $users->read($email = $email)[0];

    if ($userData) {
        $userPassword = $userData['password'];
        if ($password == $userPassword) {
            $_SESSION["userData"] = $userData;
            header("Location: ./index.php");
            die();
        }
    }
}
?>

<?php require_once "./header.php" ?>
<div class="center">
    <div class="card">
        <form method="post">
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
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
<?php require_once "./footer.php" ?>