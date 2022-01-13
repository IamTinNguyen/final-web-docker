<?php
error_reporting(E_ERROR | E_PARSE);

require_once "db.php";

$session = $_SESSION['user'][0]['id_account'];
$conn = open_database();

$sql = "SELECT employee.*,name_department,name_role 
        FROM employee,department,role 
        WHERE id_employee= $session 
        AND employee.id_role = role.id_role
        AND employee.id_department = department.id_department";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}
?>

<h3 class="my-3 text-center">THÔNG TIN CÁ NHÂN</h3>

<table class="table table-hover">
    <?php
    foreach ($output as $value) {
        echo '
            <form>
                <div class="form-group">
                    <label for="username">Họ và tên:</label>
                    <input id="username" value="'.$value['full_name'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" value="'.$value['email'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="phone">Điện thoại:</label>
                    <input id="phone" value="+84'.$value['phone_number'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="phone">Địa chỉ:</label>
                    <input id="phone" value="'.$value['address'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="salary">Lương:</label>
                    <input id="salary" value="'.$value['salary'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="department">Phòng ban:</label>
                    <input id="department" value="'.$value['name_department'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="role">Phòng ban:</label>
                    <input id="role" value="'.$value['name_role'].'" class="form-control" disabled>
                </div>

                <a href="?type=account&action=add&id=' . $value['id_employee'] . '" class="btn btn-success">
                    Chỉnh sửa
                </a>
            </form>
            ';
    }
    ?>
</table>