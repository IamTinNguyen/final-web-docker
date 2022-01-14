<?php
require_once "../db.php";
date_default_timezone_set("Asia/Bangkok");

$conn = open_database();
$id_task = $_GET['id_task'];
$rate = $_GET['rate'];
$time_progress = date("Y-m-d H:i:s");

$sql = "
    INSERT INTO task_progress(id_task, id_status, time_progress) 
    VALUES($id_task, 5, '$time_progress')
";
$conn->query($sql);

$sql = "
    UPDATE  task
    SET     rate = $rate
    WHERE   id_task = $id_task
";
$conn->query($sql);