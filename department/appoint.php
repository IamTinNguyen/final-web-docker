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
<form method="POST">
    <div class="form-group">
        <label for="name-department">Tên phòng ban</label>
        <select id="department-select-box" name="id_department" class="form-select" aria-label="Default select example">
            <option selected>Chọn tên phòng ban</option>
            <?php
            foreach ($departments as $department) {
                echo '<option value=' . $department['id_department'] . '>' . $department['name_department'] . '</option>';
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="name-department">Tên nhân viên</label>
        <select id="employee-select-box" name="id_employee" class="form-select" aria-label="Default select example">
            <option selected>Chọn nhân viên sẽ được bổ nhiệm</option>
        </select>
    </div>

    <button name="btn-submit" type="submit" class="btn btn-success">Submit</button>
</form>