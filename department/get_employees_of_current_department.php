<?php
    header('Content-Type: application/json');
    require_once "../db.php";

    $conn = open_database();
    $response = array();
     
    if (!isset($_GET['id_department'])) {
        $response['code'] = 1;
        $response['message'] = 'Dữ liệu đầu vào không hợp lệ';
        die(json_encode($response));
    } else {
        $id_department = $_GET['id_department'];
        $sql = "SELECT * FROM employee WHERE id_role = 2 AND id_department =".$id_department;
        
        $result = $conn->query($sql);
        
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }

        $response['code'] = 1;
        $response['message'] = 'Lấy danh sách nhân viên thành công';
        $response['data'] = $employees;

        die(json_encode($response));
    }    
?>