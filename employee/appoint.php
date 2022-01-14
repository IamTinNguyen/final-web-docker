<?php
    require_once "db.php";
    
    $sql = '';
    $conn = open_database();

    $id = $_GET['id'];
    $sql = "SELECT username FROM account WHERE id_account = $id";
    $result = $conn->query($sql) or die($conn->error);
    while ($row = $result->fetch_assoc()) {
        $output[] = $row;
    }
    $username = $output[0]['username'];
    $default_password = password_hash($username,PASSWORD_BCRYPT);

    if (isset($_GET['id'])) {

        $sql = "
                UPDATE `account`
                SET `password` = '$default_password'
                WHERE `id_account` = $id
                ";

        $conn->query($sql) or die($conn->error);

    }
    header("Location: ?type=employee&action=detail&id=". $id);
?>