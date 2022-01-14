<?php
require_once "db.php";

$conn = open_database();
$sql = "SELECT * FROM employee WHERE id_role = 2";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

$sql = "SELECT * FROM department";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $departments[] = $row;
}

if (isset($_POST['id_employee']) && isset($_POST['id_department'])) {
    $id_employee = $_POST['id_employee'];
    $id_department = $_POST['id_department'];

    $sql = "
        UPDATE  department
        SET     id_manager = $id_employee
        WHERE   id_department = $id_department;
    ";
    $conn->query($sql);

    $sql = "
        UPDATE  employee
        SET     id_role = 2
        WHERE   id_department = $id_department;
    ";
    $conn->query($sql);

    $sql = "
        UPDATE  employee
        SET     id_role = 1
        WHERE   id_employee = $id_employee;
    ";
    $conn->query($sql);
}

if (isset($_POST['btn-submit'])) {
    header("Location: ?type=department&action=view");
}
?>
<div class="page-wrapper bg-gra-03 p-t-45 p-b-50 ml-4 mr-5 pr-5 mb-5 mt-3" style="font-family:sans-serif;">
    <div class="card-heading mt-5 mb-5">
        <h2 class="title text-center text-uppercase"><b>BỔ NHIỆM TRƯỞNG PHÒNG</b></h2>
    </div>
    <div class="wrapper wrapper--w790">
        <div class="card card-5 p-5">
            <form method="POST">
                <div class="form-group" id="department-name-wrapper">
                    <label for="name-department">Tên phòng ban</label>
                    <select id="department-select-box" name="id_department" class="form-select" aria-label="Default select example">
                        <option selected>Chọn tên phòng ban</option>
                        <?php
                        foreach ($departments as $department) {
                            echo '<option department-name="' . $department['name_department'] . '" value=' . $department['id_department'] . '>' . $department['name_department'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group" id="employee-name-wrapper">
                    <label for="name-department">Tên nhân viên</label>
                    <select id="employee-select-box" name="id_employee" class="form-select" aria-label="Default select example">
                        <option selected>Chọn tên nhân viên sẽ được bổ nhiệm</option>
                    </select>
                </div>
                <div class="text-right">
                    <button type="button" data-target="#confirm-appoint-manager" id="appoint-manager-btn" class="btn btn-dark">Bác bỏ</button>
                </div>

                <div class="modal fade" id="confirm-appoint-manager">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Bổ nhiệm trưởng phòng</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body"></div>
                            <div class="modal-footer">
                                <button name="btn-submit" type="submit" class="btn btn-outline-dark">Đồng ý</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>