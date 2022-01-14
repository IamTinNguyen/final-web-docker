<?php
session_destroy();
unset($_SESSION['user']['privileges']);
header('Location: ./login.php');
?>

TRANG ĐĂNG XUẤT