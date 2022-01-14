<?php
require_once "db.php";

$conn = open_database();
$sql = "SELECT * FROM department";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}
?>

<h3 class="my-3 text-center">DANH SÁCH PHÒNG BAN</h3>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên phòng ban</th>
            <th scope="col">Tên trưởng phòng</th>
            <th scope="col">Mô tả</th>
            <th scope="col">Số phòng</th>
            <th class="text-center" scope="col">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index = 0;
        foreach ($output as $value) {
            $manager_name = 'Chưa có';
            if ($value['id_manager'] != NULL) {
                
                $id_manager = $value['id_manager'];
                $sql = "SELECT full_name FROM employee WHERE id_employee = ".$id_manager;
                $result = $conn->query($sql);

                while ($row = $result->fetch_assoc()) {
                    $manager_detail[] = $row;
                }

                $manager_name = $manager_detail[0]['full_name'];
                
                unset($manager_detail);
            }
            echo '
                    <tr>
                        <th scope="row">' . ++$index . '</th>
                        <td>' . $value['name_department'] . '</td>
                        <td>' . $manager_name . '</td>
                        <td>' . $value['description'] . '</td>
                        <td>' . $value['room'] . '</td>
                        <td class="text-center">
                        <a href="?type=department&action=add&id=' . $value['id_department'] . '" class="btn btn-sm btn-success">
                            Chỉnh sửa
                        </a></td>
                    </tr>
                ';
        }
        ?>

    </tbody>
</table>