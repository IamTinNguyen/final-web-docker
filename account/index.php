<?php
error_reporting(E_ERROR | E_PARSE);

require_once "db.php";

$session = $_SESSION['user'][0]['id_account'];
$conn = open_database();

$sql = "SELECT * FROM employee WHERE id_account = $session";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}
?>

<h3 class="my-3 text-center">THÔNG TIN CÁ NHÂN</h3>

<table class="table table-hover">
    <?php
    $index = 0;
    foreach ($output as $value) {
        echo '
                <div class="card">
                    <div class="container card-body ">' . "Họ tên: " . $value['full_name'] . '</div>
                    <div class="container card-body ">' . "Email: " . ($value['email'] == NULL ? 'Chưa có' : $value['email']) . '</div>
                    <div class="container card-body ">' . "Số điện thoại: " . ($value['phone_number'] == NULL ? 'Chưa có' : $value['phone_number']) . '</div>
                    <div class="container card-body ">' . "Địa chỉ: " . ($value['address'] == NULL ? 'Chưa có' : $value['address']) . '</div>
                    <div class="container card-body ">' . "Lương: " . ($value['salary'] == NULL ? 'Chưa có' : $value['salary']) . '</div>
                    <div class="card-body">
                        <a href="?type=account&action=add&id=' . $value['id_employee'] . '" class="btn btn-sm btn-success">
                            Chỉnh sửa
                        </a>
                    </div>
                </div >
            ';
    }
    ?>
</table>