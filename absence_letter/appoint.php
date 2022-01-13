<?php
error_reporting(E_ERROR | E_PARSE);

    require_once "db.php";
    $conn = open_database();
    $sql = '';

    if (isset($_GET['decide']) && isset($_GET['id']) ) {
        $decide = $_GET['decide'];
        $id = $_GET['id'];
        if ($decide === 'approve') {
            $sql = "
                    UPDATE letter
                    SET letter_status = 1
                    WHERE id_letter = $id
                    ";
            $conn->query($sql) or die($conn->error);
        } else if ($decide === 'refuse') {
            $sql = "
                    UPDATE letter
                    SET letter_status = 2
                    WHERE id_letter = $id
                    ";
            $conn->query($sql) or die($conn->error);
        }
        header("Location: ?type=absence_letter&action=detail&id=$id");
    }
