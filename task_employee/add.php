<?php
require_once('../db.php');
var_dump($_POST);
$conn = open_database();
$sql = "INSERT INTO `role` (`id_role`, `name_role`) VALUES ('55', 'test');";
$conn->query($sql);
