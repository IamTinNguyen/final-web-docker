<?php
error_reporting(E_ERROR | E_PARSE);

require_once "db.php";

$conn = open_database();
$id_employee = $_SESSION['user'][0]['id_employee'];
$id_department = $_SESSION['user'][0]['id_department'];

$sql = "
        SELECT      id_task, title_task, full_name FROM `task` 
        INNER JOIN  employee 
        ON          task.id_employee = employee.id_employee
        WHERE       task.id_employee = $id_employee";

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}
// var_dump($output[0]['full_name']);
$name_employee = $output[0]['full_name'];
$sql = "SELECT name_department FROM department WHERE id_department = $id_department";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $name_department[] = $row;
}

$name_department = $name_department[0]['name_department'];

?>


<div class="page-wrapper bg-gra-03 p-t-45 p-b-50 ml-4 mr-5 pr-5 mb-5 mt-3" style="font-family:sans-serif;">
    <div class="card-heading mt-5 mb-5">
        <h2 class="title text-center" style="text-transform:uppercase;"><b>DANH SÁCH NHIỆM VỤ CỦA <?= $name_employee ?></b></h2>
    </div>
    <div class="wrapper wrapper--w790">
        <div class="card card-5 p-5">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên nhiệm vụ</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col" class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $index = 0;
                    foreach ($output as $value) {

                        $id_status = '';
                        $id_task = $value['id_task'];
                        $sql = "
                SELECT id_status FROM task_progress 
                WHERE id_task_progress=
                    (SELECT MAX(id_task_progress) FROM task_progress 
                    WHERE id_task= $id_task);
                ";
                        $result = $conn->query($sql);

                        while ($row = $result->fetch_assoc()) {
                            $status_arr[] = $row;
                        }

                        if (isset($status_arr[0])) {
                            $id_status = $status_arr[0]['id_status'];
                        }
                        $sql = "SELECT name_status FROM status WHERE id_status = $id_status";
                        $result = $conn->query($sql);

                        $name_status = [];
                        while ($row = $result->fetch_assoc()) {
                            $name_status[] = $row;
                        }
                        if ($id_status == 1) {
                            continue;
                        }
                        echo '
                    <tr>
                        <th scope="row">' . ++$index . '</th>
                        <td>' . $value['title_task'] . '</td>
                        <td>' . $name_status[0]['name_status'] . '</td>
                        <td class="text-center">
                        <a href="?type=task_employee&action=detail&id_task=' . $value['id_task'] . '" class="btn btn-sm btn-dark">
                            Chi tiết
                        </a></td>
                    </tr>
                ';
                        unset($status_arr);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>