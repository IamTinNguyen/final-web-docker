<?php
require_once "db.php";
date_default_timezone_set("Asia/Bangkok");
$conn = open_database();

if (!isset($_GET['id_task'])) {
    header("Location: ?type=task_management&action=view");
}

$id_task = $_GET['id_task'];

$sql = "
    SELECT      * 
    FROM        task 
    INNER JOIN  task_progress 
    ON          task.id_task = task_progress.id_task 
    WHERE       task.id_task = $id_task
    ORDER BY    task_progress.id_task_progress ASC
";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $task_detail[] = $row;
}

$sql = "
    SELECT      id_status 
    FROM        `task_progress` 
    WHERE       id_task = $id_task 
    ORDER BY    id_task_progress DESC 
    LIMIT       1
";
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

$sql = "
    SELECT          * 
    FROM            task_progress 
    WHERE           time_progress = (
        SELECT      time_progress 
        FROM        `task_progress` 
        WHERE       id_task = $id_task AND 
                    id_status = 3 
        ORDER BY    id_task_progress DESC LIMIT 1
    )
;";

$result = $conn->query($sql);
$submission_files = [];

while ($row = $result->fetch_assoc()) {
    $submission_files[] = $row;
}

if (isset($_POST['reject-task-btn']) && isset($_POST['feedback'])) {
    $feedback = $_POST['feedback'];
    $time_progress = date("Y-m-d H:i:s");

    if (!empty($_FILES['uploaded_files']['name'][0])) {
        $count_files = count($_FILES['uploaded_files']['name']);

        for ($i = 0; $i < $count_files; $i++) {
            $file_name = $_FILES['uploaded_files']['name'][$i];
            move_uploaded_file($_FILES['uploaded_files']['tmp_name'][$i], 'uploads/' . $file_name);

            $sql = "
                INSERT INTO task_progress(id_task, file, id_status, time_progress, feedback)
                VALUES($id_task, '$file_name', 4, '$time_progress', '$feedback')
            ";

            $conn->query($sql);
        }
    } else {
        $sql = "
            INSERT INTO task_progress(id_task, id_status, time_progress, feedback)
            VALUES($id_task, 4, '$time_progress', '$feedback')
        ";
        $conn->query($sql);
    }

    if (isset($_POST['deadline_extension'])) {
        $deadline_extension = $_POST['deadline_extension'];

        $sql = "
            UPDATE  task
            SET     deadline = '$deadline_extension'
            WHERE   id_task = $id_task
        ";

        $conn->query($sql);
    }

    header("Location: ?type=task_management&action=detail&id_task=" . $id_task);
}
?>

<h3 class="my-4 text-center text-uppercase">CHI TI???T NHI???M V??? "<?= $task_detail[0]['title_task'] ?>"</h3>

<div class="form-group">
    <h5 class="mt-1">Tr???ng th??i hi???n t???i:</h5>
    <input disabled value="<?= $name_status[0]['name_status'] ?>" type="text" class="form-control">
</div>

<div class="form-group">
    <h5 class="mt-1">M?? t??? chi ti???t nhi???m v???:</h5>
    <textarea disabled rows="5" class="form-control"><?= $task_detail[0]['content_task'] ?></textarea>
</div>

<?php
    $deadline_arr = explode(" ", $task_detail[0]['deadline']);
    $day = date("d/m/Y", strtotime($deadline_arr[0]));
?>

<div class="form-group">
    <h5 class="mt-1">Th???i gian deadline:</h5>
    <input disabled value="<?= $day.' '.$deadline_arr[1] ?>" type="text" class="form-control">
</div>

<?php
$submission_content = '';

foreach (array_reverse($task_detail) as $task_detail_value) {
    $submission_content = $task_detail_value['submission_content'];
    if (!empty($submission_content)) {
        break;
    }
}

if ($id_status > 2) {
    echo '
        <div class="form-group">
            <h5>N???i dung k???t qu??? b??o c??o c???a nh??n vi??n:</h5>
            <textarea disabled rows="5" class="form-control">' . $submission_content . '</textarea>
        </div>
    ';
}
?>

<?php
if ($id_status  > 2) {
    echo '
        <h5 class="mt-4 mb-2">Danh s??ch t???p ????nh k??m m?? nh??n vi??n g???i:</h5>
        <table class="mt-2 table table-hover">
            <thead>
                <tr>
                    <th scope="col">STT</th>
                    <th scope="col">T??n t???p ????nh k??m</th>
                    <th scope="col" class="text-center">N???i dung t???p</th>
                </tr>
            </thead>
            <tbody>
        ';
    if (isset($submission_files[0]['file'])) {
        $index = 0;
        foreach ($submission_files as $submission_file) {
            echo '
                <tr>
                    <th scope="row">' . ++$index . '</th>
                    <td>' . $submission_file['file'] . '</td>
                    <td class="text-center">
                        <a href="uploads/' . $submission_file['file'] . '" download="' . $submission_file['file'] . '" class="btn btn-sm btn-danger">Download</a>
                    </td>
                </tr>
            ';
        }
    } else {
        echo '
            <tr>
                <td class="text-center" colspan="3">Ch??a c?? t???p ????nh k??m</td>
            </tr>
        ';
    }

    echo '
        </tbody>
    </table>
    ';
}
?>

<?php
if ($id_status == 0) {
    echo '
        <div class="text-right">
            <button type="button" data-toggle="modal" data-target="#confirm-delete" name="cancel-btn" class="btn btn-danger">H???y nhi???m v???</button>
        </div>
    ';
}

if ($id_status == 3) {
    $sql = "
        SELECT IF (
            (  
                SELECT      time_progress 
                FROM        task_progress 
                WHERE       id_task = 12 AND 
                            id_status = 3 
                ORDER BY    id_task_progress DESC 
                LIMIT       1) < (
                    SELECT  deadline 
                    FROM    task 
                    WHERE   id_task = 12
                ), 0, 1);
    ";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $turn_in_result_arr[] = $row;
    }

    $turn_in_result = array_values($turn_in_result_arr[0])[0];
    $rate_flag = '';
    if($turn_in_result == 1) {
        $rate_flag = 'disabled';
    }

    echo '
        <h3 class="mt-5 mb-3 text-center text-uppercase">TH??NG TIN PH???N H???I CHO NH??N VI??N</h3>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group" id="wrapper-feedback">
                <h5>Nh???n x??t</h5>
                <textarea name="feedback" id="feedback" rows="5" class="form-control"></textarea>
            </div>

            <div class="form-group mb-4">
                <h5>C??c t???p tin ????nh k??m</h5>
                <div class="custom-file">
                    <input name="uploaded_files[]" multiple type="file" class="custom-file-input">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>

            <div class="form-group">
                <h5>Gia h???n deadline</h5>
                <input name="deadline_extension" type="datetime-local" class="form-control">
            </div>

            <div class="form-group" id="wrapper-rate-field">
                <h5>M???c ????? ????nh gi??</h5>
                <select id="rate-select-box" class="form-select">
                    <option value=0 selected>Vui l??ng ????nh gi?? nh??n vi??n n??y</option>
                    <option value=1>Bad</option>
                    <option value=2>Ok</option>
                    <option '.$rate_flag.' value=3>Good</option>
                </select>
            </div>

            <div class="form-group text-right">
                <button type="button" data-target="#confirm-reject" id="reject-task-btn" class="btn btn-danger">B??c b???</button>
                <button type="button" data-id=' . $id_task . ' id="approve-task-btn" class="btn btn-success">Ch???p thu???n</button>
            </div>

            <div class="modal fade" id="confirm-reject">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">B??c b??? nhi???m v???</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <div class="modal-body">
                            B???n c?? ch???c r???ng mu???n b??c b??? nhi???m v??? <strong>"' . $task_detail[0]['title_task'] . '"</strong> kh??ng?
                        </div>
                        <div class="modal-footer">
                            <button name="reject-task-btn" type="submit" id="reject-task-confirm-btn" class="btn btn-danger">?????ng ?? b??c b???</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">H???y b??c b???</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    ';
}
?>

<div class="modal fade" id="confirm-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">H???y nhi???m v???</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                B???n c?? ch???c r???ng mu???n h???y nhi???m v??? <strong>"<?= $task_detail[0]['title_task'] ?>"</strong> kh??ng?
            </div>
            <div class="modal-footer">
                <button id="delete-btn" data-id=<?= $task_detail[0]['id_task'] ?> type="button" class="btn btn-danger" data-dismiss="modal">?????ng ?? h???y</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kh??ng</button>
            </div>
        </div>
    </div>
</div>

<h3 class="mt-5 mb-4 text-center text-uppercase">L???CH S??? TI???N TR??NH TH???C HI???N NHI???M V???</h3>
<hr>

<?php
$sql = "
    SELECT      DISTINCT time_progress 
    FROM        task_progress 
    WHERE       id_task = $id_task 
    ORDER BY    time_progress ASC;
";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $time_stamp_arr[] = $row;
}

$current_index = 0;

foreach ($time_stamp_arr as $time_stamp) {
    echo '<h4 class="mt-4"> Ti???n tr??nh ' . ++$current_index . ':</h4>';
    $current_history_time_stamp = $time_stamp['time_progress'];

    $sql = "
        SELECT  * 
        FROM    task_progress 
        WHERE   id_task = $id_task  AND 
                time_progress = '$current_history_time_stamp'
    ";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $history_arr[] = $row;
    }

    $date_arr = explode(" ", $current_history_time_stamp);
    $day = date("d/m/Y", strtotime($date_arr[0]));

    $current_id_status = $history_arr[0]['id_status'];
    $sql = "
        SELECT  name_status
        FROM    status 
        WHERE   id_status = $current_id_status
    ";
    $result = $conn->query($sql);

    $name_status = [];
    while ($row = $result->fetch_assoc()) {
        $name_status[] = $row;
    }

    $current_name_status = $name_status[0]['name_status'];

    if (isset($history_arr[0]['feedback'])) {
        $current_feedback = $history_arr[0]['feedback'];
    }
    
    $current_submission_content = $history_arr[0]['submission_content'];

    $file_is_uploaded = false;
    if (isset($history_arr[0]['file'])) {
        $file_is_uploaded = true;
    }

    echo '
        <div class="mb-4">
            <div> <span class="text-decoration-underline">Th???i gian ghi nh???n:</span> ' . $day . ' ' . $date_arr[1] . '</div>
            <div class="my-1"><span class="text-decoration-underline">Tr???ng th??i th???c hi???n:</span> ' . $current_name_status . '</div>
        ';
    switch ($current_id_status) {
        case 0:
            echo '<div class="my-1 text-decoration-underline">C??c t???p ????nh k??m t??? tr?????ng ph??ng: </div>';
            break;
        case 3:
            echo '
                <div><span class="my-1 text-decoration-underline">N???i dung k???t qu??? b??o c??o c???a nh??n vi??n:</span> ' . $current_submission_content . '</div>
            ';

            if ($file_is_uploaded) {
                echo '
                    <div class="my-1 text-decoration-underline">C??c t???p ????nh k??m t??? nh??n vi??n: </div>
                ';
            } else {
                echo '<hr>';
            }

            break;
        case 4:
            echo '
                <div><span class="my-1 text-decoration-underline">Ph???n h???i t??? tr?????ng ph??ng:</span> ' . $current_feedback . '</div>
            ';

            if ($file_is_uploaded) {
                echo '
                    <div class="my-1 text-decoration-underline">C??c t???p ????nh k??m t??? tr?????ng ph??ng: </div>
                ';
            } else {
                echo '<hr>';
            }
            break;
        case 5:
            echo '
                <div class="my-1">M???c ????? ????nh gi??: </div>
                <div class="my-1">Tr???ng th??i ho??n th??nh: </div>
            ';
            break;
    }

    if ($file_is_uploaded) {
        echo '
            <table class="mt-2 table table-hover">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">T??n t???p ????nh k??m</th>
                        <th scope="col" class="text-center">Thao t??c</th>
                    </tr>
                </thead>
            <tbody>
        ';

        $index = 0;

        foreach ($history_arr as $history_value) {
            echo '
                <tr>
                    <th scope="row">' . ++$index . '</th>
                    <td>' . $history_value['file'] . '</td>
                    <td class="text-center">
                        <a href="uploads/' . $history_value['file'] . '" download="' . $history_value['file'] . '" class="btn btn-sm btn-danger">Download</a>
                    </td>
                </tr>
            ';
        }

        echo '
                </tbody>
            </table>
        ';
    }

    echo '
        </div>
    ';

    unset($history_arr);
    unset($name_status);
}
?>