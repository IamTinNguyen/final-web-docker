<?php
error_reporting(E_ERROR | E_PARSE);

session_start();

if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

require_once('db.php');
$error = '';

$user = '';
$pass = '';


if (isset($_POST['user']) && isset($_POST['pass'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if (empty($user)) {
        $error = 'Please enter your username';
    } else if (empty($pass)) {
        $error = 'Please enter your password';
    } else if (strlen($pass) < 6) {
        $error = 'Password must have at least 6 characters';
    } else {
        $result = login($user, $pass);
        if ($result['code'] == 0) {

            $data = $result['data'];
            $_SESSION['user'] = $data;

            if ($user == $pass) {
                header('Location: index.php?type=reset_password');
                exit();
            } else {
                // $_SESSION['name'] = $data['firstname'] . ' ' . $data['lastname'];
                header('Location: index.php');
                exit();
            }
        } else {
            $error = $result['error'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <link rel="stylesheet" href="/style.css">

</head>


<body class="styleLogin">

    <!-- partial:index.partial.html -->
    <div class="box-form">
        <div class="left">
            <div class="overlay">
                <h1>Welcome to login</h1>
                <p>Employee Managerment Website</p>
                <span>
                    <p>Contact us</p>
                    <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                </span>
            </div>
        </div>


        <div class="right">
            <h5>Login</h5>
            <p>Don't have an account? <a href="/register">Creat Your Account</a> it takes less than a minute</p>
            <form method="post" action="" class="border rounded w-100 mb-5 mx-auto px-3 pt-3 bg-light">
                <div class="inputs">
                    <input value="<?= $user ?>" name="user" id="user" type="text" class="form-control" placeholder="Username">
                    <br>
                    <input name="pass" value="<?= $pass ?>" id="password" type="password" class="form-control" placeholder="Password">
                </div>

                <br><br>

                <div class="remember-me--forget-password">

                    <label>
                        <input <?= isset($_POST['remember']) ? 'checked' : '' ?> name="remember" type="checkbox" class="custom-control-input" id="remember" />
                        <span class="text-checkbox">Remember me</span>
                    </label>
                    <div class="form-group">
                        <?php
                        if (!empty($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        ?>
                    </div>
                </div>

                <br>
                <button class="btn btn-success px-5">Login</button>
            </form>
        </div>

    </div>

</body>

</html>