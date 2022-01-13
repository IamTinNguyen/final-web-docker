<?php
require_once "db.php";
$id = $_GET['id'];
$conn = open_database();
$sql = "SELECT * FROM employee WHERE id_employee=". $id;
$result = $conn->query($sql) or die($conn->error);

while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}

?>

<h3 class="my-3 text-center">THÔNG TIN NHÂN VIÊN</h3>

<table class="table table-hover">
        <?php
        $index = 0;
        foreach ($output as $value) {
            echo '
                <div class="card">
                    <div class="container card-body ">' ."Họ tên: ". $value['full_name'] . '</div>
                    <div class="container card-body ">' . "Email: ".($value['email'] == NULL ? 'Chưa có' : $value['email']) . '</div>
                    <div class="container card-body ">' . "Số điện thoại: ".($value['phone_number'] == NULL ? 'Chưa có' : $value['phone_number']) . '</div>
                    <div class="container card-body ">' . "Địa chỉ: ".($value['address'] == NULL ? 'Chưa có' : $value['address']) . '</div>
                    <div class="container card-body ">' . "Lương: ".($value['salary'] == NULL ? 'Chưa có' : $value['salary']) . '</div>
                    <div class="card-body">
                        <a href="?type=employee&action=add&id=' . $value['id_employee'] . '" class="btn btn-sm btn-success">
                            Chỉnh sửa
                        </a>
                    </div>
                    <div class="card-body" align="right">
                        <a id="reset_password" href="?type=employee&action=appoint&id='  . $value['id_employee'] . '"onclick="return confirm(\'Are you sure to reset?\');" class="btn btn-sm btn-danger">
                            Đặt lại mật khẩu
                        </a>
                    </div>
                </div >
            ';
        }
        ?>
</table>