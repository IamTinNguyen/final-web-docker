<?php
    $error = '';
    $style = 'none';
    require_once('db.php');
    $conn = open_database();
    $id_account = $_SESSION['user'][0]['id_account'];
    $sql = "SELECT * FROM account WHERE id_account = $id_account";
    $result = $conn->query($sql) or die($conn->error);

    while ($row = $result->fetch_assoc()) {
        $output[] = $row;
    }
    $username = $output[0]['username'];
    $password = $output[0]['password'];
    $default_password = password_hash($username,PASSWORD_BCRYPT);

    if(isset($_POST['btn-submit'])) {
        if (isset($_POST['new_password']) && isset($_POST['new_password']) || isset($_POST['old_password'])) {
            if (empty($_POST['old_password'])) {
                $old_password = $username;
            }
            $old_password = $_POST['old_password'];
            $new_password = $_POST['new_password'];
            $new_password_confirm = $_POST['new_password_confirm'];
            if (!password_verify($old_password,$password)) {
                $error = "Sai mật khẩu";
                $style = "block";
            }
            else if ($new_password != $new_password_confirm) {
                $error = "Xác nhận lại mật khẩu";
                $style = "block";
            } else {
                $new_password_hashed = password_hash($new_password,PASSWORD_BCRYPT);
                $sql = "
                    UPDATE account 
                    SET password = '$new_password_hashed'
                    WHERE id_account = $id_account
                ";
                $conn->query($sql) or die($conn->error);
            }
            header("Location: ?type=account&action=view");
        }
    }
?>

<form method="POST">
    <div class="alert alert-danger text-center" style="display: <?=$style?>;" id="errorMessage">
        <?= $error ?>
    </div>
    <?php 
        if (!password_verify($username,$password)) {
            echo '   
                <div class="form-group">
                    <label for="old_password">Nhập mật khẩu cũ</label>
                    <input name="old_password" type="password" class="form-control">  
                </div>
            ';
        }
    ?>
    <div class="form-group">
        <label for="new_password">Nhập mật khẩu mới</label>
        <input name="new_password" type="password" class="form-control" minlength="6" required >  
    </div>

    <div class="form-group">
        <label for="new_password_confirm">Xác nhận mật khẩu mới</label>
        <input name="new_password_confirm" type="password" class="form-control" minlength="6" required>
    </div>

    <button name="btn-submit" type="submit" class="btn btn-primary">Gửi</button>
</form>