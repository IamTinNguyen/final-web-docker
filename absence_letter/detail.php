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


<div class="page-wrapper bg-gra-03 p-t-45 p-b-50 ml-4 mr-5 pr-5 mb-5 mt-3" style="font-family:sans-serif;">
    <div class="card-heading mt-5 mb-5">
        <h2 class="title text-center text-uppercase"><b>CHI TIẾT YÊU CẦU NGHỈ PHÉP</b></h2>
    </div>
    <div class="wrapper wrapper--w790">
        <div class="card card-5 p-5">
            <?php
            echo '
            <form>
                <div class="row mb-3">

                    <div class="col">
                        <label for="full_name">Họ và tên:</label>
                        <input id="full_name" type="text" value="' . $output[0]['full_name'] . '" class="form-control" disabled>
                    </div>

                    <div class="col">
                        <label for="tittle">Tiêu đề:</label>
                        <input id="tittle" type="text" value="' . $output[0]['tittle_letter'] . '" class="form-control" disabled>
                    </div>
                </div>
                <div class="row mb-3">

                    <div class="col">
                        <label class="form-label" for="textAreaExample">Nội dung:</label>
                        <textarea class="form-control" id="textAreaExample1" rows="4" disabled>' . $output[0]['content_letter'] . '</textarea>
                    </div>
                    <div class="col">
                        <label class="form-label" for="textAreaExample">Mô tả chi tiết:</label>
                        <textarea class="form-control" id="textAreaExample1" rows="4" disabled>' . $output[0]['description_letter'] . '</textarea>
                    </div>
                </div>

                <div class="row mb-3">

                    <div class="col">
                        <label for="day_sent">Ngày gửi:</label>
                        <input id="day_sent" type="text" value="' . strftime('%d-%m-%Y', strtotime($output[0]['day_sent'])) . '" class="form-control" disabled>
                    </div>

                    <div class="col">
                        <label for="day_start">Ngày bắt đầu nghỉ phép:</label>
                        <input id="day_start" type="text" value="' . strftime('%d-%m-%Y', strtotime($output[0]['day_start'])) . '" class="form-control" disabled>
                    </div>
                </div>
                <div class="row mb-3">

                    <div class="col">
                        <label for="days_off">Ngày bắt đầu nghỉ phép:</label>
                        <input id="days_off" type="text" value="' . $output[0]['days_off'] . '" class="form-control" disabled>
                    </div>

                    <div class="col">
                        <label for="day_finish">Ngày làm lại:</label>
                        <input id="day_finish" type="text" value="' . strftime('%d-%m-%Y', strtotime($output[0]['day_finish'])) . '" class="form-control" disabled>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status">Trạng thái:</label>
                    <input id="status" type="text" value="' . ($output[0]['letter_status'] == 0 ? 'Chưa duyệt' : ($output[0]['letter_status'] == 1 ? 'Đã duyệt' : 'Đã từ chối')) . '" class="form-control" disabled>
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
                            <td class="text-center"><a href="uploads/' . $file_letter['file_name'] . '" download="' . $file_letter['file_name'] . '" class="btn btn-sm btn-secondary">Download</a></td>
                            

                        </tr>

                ';
            }
            echo '</tbody> 
                </table> ';
            if ($output[0]['letter_status'] == 0) {
                echo '

            <div class="text-right mt-3 mb-3 ml-2">
                <a data-toggle="modal" href="#approve" class="btn btn-outline-dark">
                    Phê duyệt
                </a>

                <div class="modal fade" id="approve">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Thông báo</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
            
                            <div class="modal-body text-left">
                            Bạn có chắc chắn rằng muốn phê duyệt đơn nghỉ phép này không? 
                            </div>

                            <div class="modal-footer">
                                <a href="?type=absence_letter&action=appoint&decide=approve&id=' . $id_letter . '" class="btn btn-outline-dark">
                                    Phê duyệt
                                </a>
                                <a style="color: white" class="btn btn-secondary" data-dismiss="modal">
                                    Hủy
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a data-toggle="modal" href="#refuse" class="btn btn-dark">
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
            </div>
            </div>
            </div>
            
        ';
            }
            ?>