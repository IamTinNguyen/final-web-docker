<?php

    require_once "db.php";

    $conn = open_database();
    $sql = "
        SELECT      employee.id_employee,account.username,department.name_department,employee.full_name,employee.email 
        FROM        account,department,employee 
        WHERE       account.id_account = employee.id_account 
        AND         employee.id_department = department.id_department
        ORDER BY    employee.id_account
    ";
    $result = $conn->query($sql) or die($conn->error);

    while ($row = $result->fetch_assoc()) {
        $employee[] = $row;
    }
?>

<h3 class="my-3 text-center">DANH SÁCH NHÂN VIÊN</h3>

<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Username</th>
            <th scope="col">Tên</th>
            <th scope="col">Email</th>
            <th scope="col">Phòng ban</th>
            <th class="text-center" scope="col">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index = 0;
        foreach ($employee as $value) {
            echo '
                    <tr>
                        <th scope="row">' . ++$index . '</th>
                        <td>' . $value['username'] . '</td>
                        <td>' . $value['full_name'] . '</td>
                        <td>' . $value['email'] . '</td>
                        <td>' . $value['name_department'] . '</td>
                        <td class="text-center"><a href="?type=employee&action=detail&id=' . $value['id_employee'] . '" class="btn btn-sm btn-primary">
                            Xem chi tiết
                        </a></td>
                    </tr>
                ';
        }

        ?>

    </tbody>
</table>