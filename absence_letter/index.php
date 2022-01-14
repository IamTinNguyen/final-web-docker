<?php
error_reporting(E_ERROR | E_PARSE);

require_once "db.php";
$output = [];
$role = $_SESSION['user'][0]['id_role'];
$department = $_SESSION['user'][0]['id_department'];
$conn = open_database();
if ($role == 1) {
    $sql = "
        SELECT letter.*,full_name 
        FROM letter,employee 
        WHERE letter.id_employee = employee.id_employee AND id_role = 2 AND id_department = $department
        ORDER BY day_sent DESC, letter_status ASC
        ";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $output[] = $row;
    }
}
if ($role == 0) {
    $sql = "
            SELECT letter.*,full_name 
            FROM letter,employee 
            WHERE letter.id_employee = employee.id_employee AND id_role = 1
            ORDER BY day_sent DESC, letter_status ASC";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $output[] = $row;
    }
}


?>



<h3 class="my-3 text-center">YÊU CẦU NGHỈ PHÉP</h3>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên nhân viên</th>
            <th scope="col">Tiêu đề</th>
            <th scope="col">Ngày gửi</th>
            <th class="text-center" scope="col">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index = 0;
        if ($output == null) {
            echo '<th colspan="7" class="text-center">Chưa có đơn xin nghỉ phép</th>';
        }
        foreach ($output as $value) {
            echo '
                    <tr>
                        <th scope="row">' . ++$index . '</th>
                        <td>' . $value['full_name'] . '</td>
                        <td>' . ($value['tittle_letter'] == NULL ? 'Chưa có' : $value['tittle_letter']) . '</td>
                        <td>' . strftime('%d-%m-%Y', strtotime($value['day_sent'])) . '</td>
                        <td class="text-center">
                        <a href="?type=absence_letter&action=detail&id=' . $value['id_letter'] . '" class="btn btn-sm btn-success">
                            Xem chi tiết
                        </a></td>
                    </tr>
                ';
        }

        ?>

    </tbody>
</table>