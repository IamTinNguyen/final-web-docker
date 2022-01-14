<?php
error_reporting(E_ERROR | E_PARSE);

require_once "db.php";

$sql = $username = $full_name = $phone = $address = $email = $salary = $role = $department = '';
$conn = open_database();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT employee.*,account.username,name_department,name_role
                FROM employee,account,department,role
                WHERE id_employee=" . $id . " 
                and account.id_account = employee.id_account
                and employee.id_department = department.id_department
                and employee.id_role = role.id_role";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $output[] = $row;
    }

    $username = $output[0]['username'];
    $full_name = $output[0]['full_name'];
    $phone = $output[0]['phone_number'];
    $address = $output[0]['address'];
    $email = $output[0]['email'];
    $salary = $output[0]['salary'];
    $name_role = $output[0]['name_role'];
    $name_department = $output[0]['name_department'];
}

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}

if (isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['email'])) {
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
}
if (isset($_POST['btn-submit'])) {
    if (isset($_GET['id'])) {
        $sql = "
                UPDATE  `employee`
                SET     `phone_number` = '$phone', 
                        `address` = '$address', 
                        `email` = '$email'
                WHERE   `id_employee` = $id
            ";
        $conn->query($sql) or die($conn->error);
    }
    header("Location: ?type=account&action=view");
}

?>

<form method="POST">

    <div class="form-group">
        <label for="username">Tên người dùng</label>
        <input value="<?= !empty($username) ? $username : '' ?>" name="username" type="text" class="form-control" disabled>
    </div>

    <div class="form-group">
        <label for="full_name">Họ tên</label>
        <input value="<?= !empty($full_name) ? $full_name : '' ?>" name="full_name" type="text" class="form-control" disabled>
    </div>

    <div class="form-group">
        <label for="phone">Phone</label>
        <input value="<?= !empty($phone) ? $phone : '' ?>" name="phone" type="number" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="address">Dia Chi</label>
        <input value="<?= !empty($address) ? $address : '' ?>" name="address" type="text" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input value="<?= !empty($email) ? $email : '' ?>" name="email" type="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="salary">Salary</label>
        <input value="<?= !empty($salary) ? $salary : '' ?>" name="salary" type="text" class="form-control" disabled>
    </div>

    <div class="form-group">
        <label for="name_department">Phòng ban</label>
        <input value="<?= !empty($name_department) ? $name_department : '' ?>" name="name_department" type="text" class="form-control" disabled>
    </div>

    <div class="form-group">
        <label for="name_role">Chức vụ</label>
        <input value="<?= !empty($name_role) ? $name_role : '' ?>" name="name_role" type="text" class="form-control" disabled>
    </div>

    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#change_info">Lưu lại</button>

    <div class="modal fade" id="change_info">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Xác nhận</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    Sửa thông tin?
                </div>
                <div class="modal-footer">
                <button name="btn-submit" type="submit" class="btn btn-success">Xác nhận</button>
                <button data-dismiss="modal" class="btn btn-secondary">Hủy</button>
                </div>
            </div>
        </div>
    </div>
</form>