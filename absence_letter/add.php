<?php
error_reporting(E_ERROR | E_PARSE);

require_once "db.php";
date_default_timezone_set('Asia/Ho_Chi_Minh');
$id_employee = $_SESSION['user'][0]['id_employee'];
$id_role = $_SESSION['user'][0]['id_role'];
$display = 'hidden';
$error = '';
$output = [];
$sql = $day_sent = $day_start = '';
$used_days = 0;
if ($id_role == 1) {
    $default_day_off = $days_left = 15;
} else {
    $default_day_off = $days_left = 12;
}
$content_letter = $description_letter = $day_off = $sql = '';
$conn = open_database();
$sql = "SELECT letter.*,full_name 
        FROM letter,employee 
        WHERE letter.id_employee = $id_employee 
        AND letter.id_employee = employee.id_employee
        ORDER BY day_sent DESC";

$result = $conn->query($sql) or die($conn->error);

while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}
foreach ($output as $day_off) {
    if ($day_off['letter_status'] == 1) {
        $used_days += $day_off['days_off'];
        $days_left -= $day_off['days_off'];
    }
    if ($days_left == 0) {
        $error = "Bạn đã dùng hết ngày off";
    }
}
if ($output != null) {
    $last_day = $output[0]['day_sent'];
} else {
    $last_day = null;
}
$last_day = strtotime($last_day);
$day_sent = date('Y-m-d');
$date2 = strtotime($day_sent);
$hourDiff = round(abs($date2 - $last_day) / (60 * 60 * 24), 0);
if ($hourDiff < 7) {
    $error = "Chưa đủ 7 ngày để gửi yêu cầu mới";
}
if (isset($_POST['btn-submit'])) {
    if (isset($_POST['tittle_letter']) && isset($_POST['content_letter']) && isset($_POST['description']) && isset($_POST['day_start']) && isset($_POST['day_off'])) {
        $tittle_letter = $_POST['tittle_letter'];
        $content_letter = $_POST['content_letter'];
        $description = $_POST['description'];
        $day_start = $_POST['day_start'];
        $day_off = $_POST['day_off'];
        $day_finish = date('Y-m-d', strtotime($day_start . '+ ' . $day_off . ' days'));

        $sql = "INSERT INTO letter(id_employee,tittle_letter,content_letter,description_letter,day_sent,day_start,days_off,day_finish,letter_status)
                VALUES($id_employee,'$tittle_letter','$content_letter','$description','$day_sent','$day_start',$day_off,'$day_finish',0) ";

        $conn->query($sql) or die($conn->error);
    }
    $sql = "SELECT * FROM letter";

    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $amount[] = $row;
    }
    $id_letter = count($amount);
    $count_files = count($_FILES['upload-file-submit']['name']);
    for ($i = 0; $i < $count_files; $i++) {
        $file_name = $_FILES['upload-file-submit']['name'][$i];
        move_uploaded_file($_FILES['upload-file-submit']['tmp_name'][$i], 'uploads/' . $file_name);
        $sql = "
            INSERT into letter_file(id_letter,file_name)
            VALUES($id_letter,'$file_name')
        ";
        $conn->query($sql) or die($conn->error);;
    } /* var_dump($_FILES); */
    header("Refresh:0");
}
?>
<h2 class="title text-center text-uppercase mt-5 mb-5 pr-5" style="font-family:sans-serif;"><b>ĐƠN NGHỈ PHÉP</b></h2>


<div class="pl-5 pr-5 mr-5 ml-5">
    <div class="alert alert-secondary text-center" role="alert">
        Số ngày nghỉ phép của bạn: <?= $default_day_off ?>
    </div>
    <div class="alert alert-secondary text-center" role="alert">
        Số ngày nghỉ phép đã dùng: <?= $used_days ?>
    </div>
    <div class="alert alert-secondary text-center" role="alert">
        Số ngày nghỉ phép còn lại: <?= $days_left ?>
    </div>
</div>


<table id="letter_list" class="table table-hover">
    <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên nhân viên</th>
            <th scope="col">Tiêu đề</th>
            <th scope="col">Ngày gửi</th>
            <th scope="col">Trạng thái</th>
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
                        <td>' . ($value['letter_status'] == 0 ? "Chưa duyệt" : ($value['letter_status'] == 1 ? "Đã duyệt" : "Đã từ chối")) . '</td>
                    </tr>
                ';
        }
        ?>
    </tbody>
</table>

<h5 class="my-3 text-danger"><?= $error ?></h5>
<div class="text-center">
    <button id="btn-add" name="btn-add" type="button" <?php if (($default_day_off == 0) || ($hourDiff < 7)) echo 'disabled';
                                                        else echo '' ?> class="btn btn-dark">Tạo đơn mới</button>
</div>

<form id="absence_letter" method="POST" hidden enctype="multipart/form-data">
    <hr>
    <div class="page-wrapper bg-gra-03 p-t-45 p-b-50 ml-4 mr-5 pr-5 mb-5 mt-3" style="font-family:sans-serif;">
        <div class="card-heading mt-5 mb-5">
            <h3 class="title text-center text-uppercase"><b>Tạo đơn nghỉ phép</b></h3>
        </div>
        <div class="wrapper wrapper--w790">
            <div class="card card-5 p-5">
                <div class="form-group">
                    <label for="tittle_letter">Tiêu đề</label>
                    <input name="tittle_letter" type="text" class="form-control" placeholder="Tiêu đề" required>
                </div>

                <div class="form-group">
                    <label for="content_letter">Nội dung</label>
                    <input name="content_letter" type="text" class="form-control" placeholder="Nội dung" required>
                </div>

                <div class="form-group">
                    <label for="description">Chi tiết</label>
                    <textarea name="description" type="text" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="day_start">Ngày bắt đầu nghỉ</label>
                    <input name="day_start" type="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="day_off">Số ngày nghỉ</label>
                    <select name="day_off" id="day_off" class="form-select">
                        <?php
                        for ($i = 1; $i <= $default_day_off; $i++) {
                            echo "<option>$i</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class='form-group' id='file_letter_submit_wrapper'>
                    <label for='upload-files'>Các tập tin đính kèm</label>
                    <div class='custom-file'>
                        <input onchange='FilevalidationLetter()' rules='required' id='file_letter_submit' name='upload-file-submit[]' multiple type='file' class='custom-file-input'>
                        <label class='custom-file-label' for='customFile'>Choose file</label>
                    </div>
                    <span id='size2' style='color: #f33a58;' class='form-message'></span>
                </div>
                <div class="text-right mt-3">
                    <button id="btn-back" name="btn-back" type="button" class="btn btn-outline-dark">Quay lại</button>
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#send_letter">Gửi</button>

                </div>

                <div class="modal fade" id="send_letter">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Xác nhận</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <div class="modal-body">
                                Xác nhận gửi đơn
                            </div>

                            <div class="modal-footer">
                                <button id="btn_letter_submit" name="btn-submit" type="submit" class="btn btn-primary" data-toggle="modal" data-target="#send_letter">Gửi</button>
                                <button class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>