<?php
error_reporting(E_ERROR | E_PARSE);

require_once "db.php";
$id_letter;
$output = [];
if (isset($_GET['id'])) {
    $id_letter = $_GET['id'];
}
$conn = open_database();
$sql = "SELECT letter.*,full_name FROM letter,employee WHERE id_letter = $id_letter and letter.id_employee = employee.id_employee";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}

?>

<h3 class="my-3 text-center">CHI TIẾT YÊU CẦU NGHỈ PHÉP</h3>
<?php
    echo '
        <form>
            <div class="form-group">
                <label for="full_name">Họ và tên:</label>
                <input id="full_name" type="text" value="'.$output[0]['full_name'].'" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label for="tittle">Tiêu đề:</label>
                <input id="tittle" type="text" value="'.$output[0]['tittle_letter'].'" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label for="content">Nội dung:</label>
                <input id="content" type="text" value="'.$output[0]['content_letter'].'" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label for="description">Mô tả chi tiết:</label>
                <input id="description" type="text" value="'.$output[0]['description_letter'].'" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label for="day_sent">Ngày gửi:</label>
                <input id="day_sent" type="text" value="'.strftime('%d-%m-%Y', strtotime($output[0]['day_sent'])).'" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label for="day_start">Ngày bắt đầu nghỉ phép:</label>
                <input id="day_start" type="text" value="'.strftime('%d-%m-%Y', strtotime($output[0]['day_start'])).'" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label for="days_off">Ngày bắt đầu nghỉ phép:</label>
                <input id="days_off" type="text" value="'.$output[0]['days_off'].'" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label for="day_finish">Ngày làm lại:</label>
                <input id="day_finish" type="text" value="'.strftime('%d-%m-%Y', strtotime($output[0]['day_finish'])).'" class="form-control" disabled>
            </div>

            <div class="form-group">
                <label for="status">Trạng thái:</label>
                <input id="status" type="text" value="'.($output[0]['letter_status'] == 0 ? 'Chưa duyệt' : ($output[0]['letter_status'] == 1 ? 'Đã duyệt' : 'Đã từ chối')).'" class="form-control" disabled>
            </div>
        </form>
        ';
    $sql = "SELECT * FROM letter_file WHERE id_letter = $id_letter";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $file[] = $row;
    }
    echo '
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên tệp đính kèm</th>
                <th scope="col" class="text-center">Nội dung tệp</th>
            </tr>
        </thead>
        <tbody>
    ';
    if ($file == null) {
        echo '<th colspan="3" class="text-center">Không có tệp đính kèm</th>';
    }
    $index = 0;
    foreach ($file as $file_letter) {
        echo '
            <tr>
                <th scope="row">' . ++$index . '</th>
                <td>' . $file_letter['file_name'] . '</td>
                <td class="text-center"><img height="150px" src="uploads/' . $file_letter['file_name'] . '"></td>
            </tr>
    ';
    }
    if ($output[0]['letter_status'] == 0) {
        echo '
            <div class="">
                <a data-toggle="modal" href="#approve" class="btn btn-success">
                    Phê duyệt
                </a>

                <div class="modal fade" id="approve">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Xác nhận</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
            
                            <div class="modal-body">
                                Xác nhận phê duyệt
                            </div>

                            <div class="modal-footer">
                                <a href="?type=absence_letter&action=appoint&decide=approve&id=' . $id_letter . '" class="btn btn-success">
                                    Phê duyệt
                                </a>
                                <a style="color: white" class="btn btn-secondary" data-dismiss="modal">
                                    Hủy
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a data-toggle="modal" href="#refuse" class="btn btn-danger">
                    Từ chối
                </a>

                <div class="modal fade" id="refuse">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Xác nhận</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
            
                            <div class="modal-body">
                                Xác nhận từ chối
                            </div>

                            <div class="modal-footer">
                                <a href="?type=absence_letter&action=appoint&decide=refuse&id=' . $id_letter . '" class="btn btn-danger">
                                    Từ chối
                                </a>
                                <a style="color: white" class="btn btn-secondary" data-dismiss="modal">
                                    Hủy
                                </a>
                            </div>
                        </div>
                    </div>  
                </div> 
            </div>
        ';
    }
?>