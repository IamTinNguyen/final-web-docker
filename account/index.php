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

<div class="page-wrapper bg-gra-03 p-t-45 p-b-50 ml-4 mr-5 pr-5 mb-5 mt-3" style="font-family:sans-serif;">
    <div class="card-heading mt-5 mb-5">
        <h2 class="title text-center"><b>THÔNG TIN CÁ NHÂN</b></h2>
    </div>
    <div class="wrapper wrapper--w790">
        <div class="card card-5 p-5">

            <table class="table table-hover">
                <?php
                foreach ($output as $value) {
                    echo '
            <form>
                <div class="row mt-3">

                    <div class="col">
                        <label for="username">Họ và tên:</label>
                        <input id="username" value="' . $value['full_name'] . '" class="form-control" disabled>
                    </div>

                    <div class="col">
                        <label for="email">Email:</label>
                        <input id="email" value="' . $value['email'] . '" class="form-control" disabled>
                    </div>
                </div>

                <div class="row mt-3">

                    <div class="col">
                        <label for="phone">Điện thoại:</label>
                        <input id="phone" value="+84' . $value['phone_number'] . '" class="form-control" disabled>
                    </div>

                    <div class="col">
                        <label for="phone">Địa chỉ:</label>
                        <input id="phone" value="' . $value['address'] . '" class="form-control" disabled>
                    </div>
                </div>

                <div class="row mt-3">

                    <div class="col">
                        <label for="salary">Lương:</label>
                        <input id="salary" value="' . $value['salary'] . '" class="form-control" disabled>
                    </div>

                    <div class="col">
                        <label for="department">Phòng ban:</label>
                        <input id="department" value="' . $value['name_department'] . '" class="form-control" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="role">Chức vụ:</label>
                    <input id="role" value="' . $value['name_role'] . '" class="form-control" disabled>
                </div>
                <div class="text-right">

                <a href="?type=account&action=add&id=' . $value['id_employee'] . '" class="btn btn-outline-dark">
                    Chỉnh sửa
                </a>
                </div>

            </form>
            ';
                }
                ?>
            </table>
        </div>
    </div>
</div>