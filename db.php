<?php

// require 'vendor/autoload.php';

define('HOST', 'mysql-server');
define('USER', 'root');
define('PASS', 'root');
define('DB', 'web_final');

function open_database()
{
    $conn = new mysqli(HOST, USER, PASS, DB);
    if ($conn->connect_error) {
        die('Connect error: ' . $conn->connect_error);
    }
    return $conn;
}

function login($user, $pass)
{
    $sql = "select * from account where username = ?";
    $conn = open_database();

    $stm = $conn->prepare($sql);
    $stm->bind_param('s', $user);
    if (!$stm->execute()) {
        return array('code' => 1, 'error' => 'User does not exists');
    }

    $result = $stm->get_result();
    $data  = $result->fetch_assoc();

    $hashed_password = $data['password'];
    if (!password_verify($pass, $hashed_password)) {
        return array('code' => 2, 'error' => 'Invalid password');
    }
    $id_account = $data['id_account'];
    $sql = "SELECT * FROM employee WHERE id_account=" . $id_account;

    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $output[] = $row;
    }

    return array('code' => 0, 'error' => '', 'data' => $output);
}
