<?php
    require_once "../db.php";
    date_default_timezone_set("Asia/Bangkok");

    $conn = open_database();
    $id_task = $_GET['id_task'];
    $time_progress = date("Y-m-d H:i:s");

    $sql = "
        INSERT INTO task_progress(id_task, id_status, time_progress) 
        VALUES($id_task, 1, '$time_progress')
    ";

    $conn->query($sql);

    header("?type=task_management&action=detail&id_task=$id_task");
?>