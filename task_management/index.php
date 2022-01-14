<?php
require_once "db.php";

$conn = open_database();
$id_manager = $_SESSION['user'][0]['id_employee'];
$id_department = $_SESSION['user'][0]['id_department'];

$sql = "
        SELECT      id_task, title_task, full_name FROM `task` 
        INNER JOIN  employee 
        ON          task.id_employee = employee.id_employee
        WHERE       task.id_manager = $id_manager";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}

$sql = "SELECT name_department FROM department WHERE id_department = $id_department";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $name_department[] = $row;
}

$name_department = $name_department[0]['name_department'];

?>

<h3 class="my-3 text-center text-uppercase">DANH SÁCH NHIỆM VỤ CỦA <?=$name_department?></h3>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên nhiệm vụ</th>
            <th scope="col">Tên nhân viên</th>
            <th scope="col">Trạng thái</th>
            <th scope="col" class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index = 0;
        foreach ($output as $value) {
            $id_task = $value['id_task'];
            $sql = "SELECT id_status FROM `task_progress` WHERE id_task = $id_task ORDER BY id_task_progress DESC LIMIT 1";
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $status_arr[] = $row;
            }

            $id_status = '';
            if (isset($status_arr[0])) {
                $id_status = $status_arr[0]['id_status'];
            }

            $sql = "SELECT name_status FROM status WHERE id_status = $id_status";
            $result = $conn->query($sql);
            $name_status = [];
            while ($row = $result->fetch_assoc()) {
                $name_status[] = $row;
            }

            if ($id_status != 0) {
                $edit_btn = 'disabled';
            } else {
                $edit_btn = '';
            }
            
            echo '
                    <tr>
                        <th scope="row">' . ++$index . '</th>
                        <td>' . $value['title_task'] . '</td>
                        <td>' . $value['full_name'] . '</td>
                        <td>' . $name_status[0]['name_status'] . '</td>
                        <td class="text-center">
                            <a href="?type=task_management&action=detail&id_task=' . $value['id_task'] . '" class="btn btn-sm btn-success">
                                Xem chi tiết 
                            </a>
                            <button data-id='.$id_task.' '.$edit_btn.' href="?type=task_management&action=detail&id_task=' . $value['id_task'] . '" class="btn btn-sm btn-danger edit-task-btn">
                                Chỉnh sửa
                            </button>
                        </td>
                    </tr>
                ';
            unset($status_arr);
        }
        ?>
    </tbody>
</table>