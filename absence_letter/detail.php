<?php
error_reporting(E_ERROR | E_PARSE);

require_once "db.php";

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

<table class="table table-hover">
    <?php
    $index = 0;
    foreach ($output as $value) {
        echo '
                <div class="card">
                    <div class="container card-body ">' . "<strong>Họ tên: </strong>" . $value['full_name'] . '</div>
                    <div class="container card-body ">' . "<strong>Tiêu đề: </strong>" . $value['tittle_letter'] . '</div>
                    <div class="container card-body ">' . "<strong>Nội dung: </strong>" . $value['content_letter'] . '</div>
                    <div class="container card-body ">' . "<strong>Mô tả chi tiết: </strong>" . $value['description_letter'] . '</div>
                    <div class="container card-body ">' . "<strong>Ngày gửi: </strong>" . strftime('%d-%m-%Y', strtotime($value['day_sent'])) . '</div>
                    <div class="container card-body ">' . "<strong>Ngày bắt đầu nghỉ phép: </strong>" . strftime('%d-%m-%Y', strtotime($value['day_start'])) . '</div>
                    <div class="container card-body ">' . "<strong>Số ngày nghỉ: </strong>" . $value['days_off']  . '</div>
                    <div class="container card-body ">' . "<strong>Ngày làm lại: </strong>" . strftime('%d-%m-%Y', strtotime($value['day_finish'])) . '</div>
                    <div class="container card-body ">' . "<strong>Trạng thái: </strong>" . ($value['letter_status'] == 0 ? 'Chưa duyệt' : ($value['letter_status'] == 1 ? 'Đã duyệt' : 'Đã từ chối')) . '</div>';

        if ($value['letter_status'] == 0) {
            echo '                    
                    <div class="row">
                        <div class="card-body col-sm-6 text-center">
                            <a href="?type=absence_letter&action=appoint&decide=approve&id=' . $id_letter . '" class="btn btn-sm btn-success">
                                Phê duyệt
                            </a>
                        </div>
                        <div class="card-body col-sm-6 text-center">
                            <a href="?type=absence_letter&action=appoint&decide=refuse&id=' . $id_letter . '" class="btn btn-sm btn-danger">
                                Từ chối
                            </a>
                        </div>
                    </div>';
        } else {
            echo '
                    </div>';
        }
        echo '
            <div class="card-body">
                <a href="?type=absence_letter&action=view" class="btn btn-sm btn-success">
                    Trở về 
                </a>
            </div>
        ';
    }
    ?>
</table>