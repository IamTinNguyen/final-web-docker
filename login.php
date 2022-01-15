<?php
error_reporting(E_ERROR | E_PARSE);

session_start();

if (isset($_SESSION['user'])) {
    header('Location: index.php?type=account&action=view');
    exit();
}

require_once('db.php');

$error = $user = $pass = '';

if (isset($_POST['user']) && isset($_POST['pass'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    if (empty($user)) {
        $error = 'Please enter your username!';
    } else if (empty($pass)) {
        $error = 'Please enter your password!';
    } else if (strlen($pass) < 6) {
        $error = 'Password must have at least 6 characters!';
    } else {
        $result = login($user, $pass);
        if ($result['code'] == 0) {

            $data = $result['data'];
            $_SESSION['user'] = $data;

            if ($user == $pass) {
                header('Location: index.php?type=reset_password');
                exit();
            } elseif ($data[0]['id_role'] == 1) {
                header('Location: index.php?type=task_management&action=view');
                exit();
            } elseif ($data[0]['id_role'] == 2) {
                header('Location: index.php?type=task_employee&action=view');
                exit();
            } elseif ($data[0]['id_role'] == 0) {
                header('Location: index.php?type=employee&action=view');
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
    <title>LOGIN</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="/style.css">
</head>

<body class="styleLogin">
    <!-- partial:index.partial.html -->
    <div class="box-form">
        <div class="left">
            <div class="overlay">
                <h1 class="mt-4 ml-2 font-weight-bold">Employee Management Services</h1>
                <hr style="width:100%; background-color:#b6b0b08a" size="0.5px">
                <span>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                    <a href="#"><i class="fa fa-linkedin"></i></a>
                    <a href="#"><i class="fa fa-yahoo"></i></a>
                </span>
            </div>
        </div>

        <div class="right">
            <h5 class="font-weight-bold">Login</h5>
            <p class="mb-4"> Welcome to our employee management services website. To begin, please log in!</p>
            <form method="post">
                <div class="form-group">
                    <input value="<?= $user ?>" name="user" id="user" type="text" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                    <input name="pass" value="<?= $pass ?>" id="password" type="password" class="form-control" placeholder="Password">
                </div>

                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                    <label id="remeber-me-label" class="form-check-label" for="inlineCheckbox1">Remeber me</label>
                </div>

                <div class="form-group">
                    <div class="text-danger text-center" name="pass"><?= $error ?></div>
                </div>

                <button class="btn btn-success px-5">Login</button>

            </form>
        </div>
        </form>
    </div>
    </div>
</body>

</html>