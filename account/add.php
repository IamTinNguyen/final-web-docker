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

        $file_name = $_FILES['upload-file-submit']['name'];
        move_uploaded_file($_FILES['upload-file-submit']['tmp_name'], 'uploads/' . $file_name);
        $sql = "
                UPDATE  `employee`
                SET     `employee_avatar` = '$file_name'
                WHERE   `id_employee` = $id
            ";
        $conn->query($sql) or die($conn->error);
    }
    header("Location: ?type=account&action=view");
}

?>

<form method="POST" enctype='multipart/form-data'>
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50 ml-4 mr-5 pr-5 mb-5 mt-5" style="font-family:sans-serif;">
        <div class="card-heading mt-5 mb-5">
            <h2 class="title text-center"><b> THAY ĐỔI ẢNH ĐẠI DIỆN</b></h2>
        </div>
        <div class="wrapper wrapper--w790">
            <div class="card card-5 p-5">
                <div class="row mt-2">

                    <div class="col">
                        <label for="username">Tên người dùng</label>
                        <input value="<?= !empty($username) ? $username : '' ?>" name="username" type="text" class="form-control" disabled>
                    </div>

                    <div class="col">
                        <label for="full_name">Họ tên</label>
                        <input value="<?= !empty($full_name) ? $full_name : '' ?>" name="full_name" type="text" class="form-control" disabled>
                    </div>
                </div>


                <div class='form-group mt-3'>
                    <label for='upload-files'>Đổi ảnh đại diện</label>
                    <div class='custom-file'>
                        <input onchange='FilevalidationAvartar()' id='avarta_file' name='upload-file-submit' type='file' class='custom-file-input'>
                        <label class='custom-file-label' for='customFile'>Choose file</label>

                    </div>
                    <span id='size_avartar' style='color: #f33a58;' class='form-message'></span>
                </div>
                <div class="text-right mb-3">
                    <button name='btn_submit_test' id="btn_employee_info" type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#change_info">Lưu lại</button>

                </div>

                <div class="modal fade" id="change_info">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Thông báo</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                Bạn có chắc chắn rằng muốn đổi ảnh đại diện không?
                            </div>
                            <div class="modal-footer">
                                <button name="btn-submit" type="submit" class="btn btn-outline-dark">Xác nhận</button>
                                <button data-dismiss="modal" class="btn btn-secondary">Hủy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>