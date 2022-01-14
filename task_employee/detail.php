<?php
error_reporting(E_ERROR | E_PARSE);

require_once "db.php";
$isDisabled = '';
$title = $content = $description = $manager = $status = '';
$conn = open_database();

if (isset($_GET['id_task'])) {
    $id_task = $_GET['id_task'];

    $sql = "
    SELECT      title_task, content_task, id_manager, deadline, rate, file
    FROM        task 
    INNER JOIN  task_progress 
    ON          task.id_task = task_progress.id_task 
    WHERE       task.id_task = $id_task
    ";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $output[] = $row;
    }
    $title = $output[0]['title_task'];
    $content = $output[0]['content_task'];
    $manager = $output[0]['id_manager'];
    // $status = (int) $output[0]['id_status'];
    $deadline = $output[0]['deadline'];
    $rate = $output[0]['rate'];

    $rateSaver = $rate;
    if ((int)$rate == 0) {
        $rate = "Chưa đánh giá";
    } elseif ((int)$rate == 1) {
        $rate = "Tốt";
    } elseif ((int)$rate == 1) {
        $rate = "Trung bình";
    } elseif ((int)$rate == 1) {
        $rate = "Chưa hoàn thành";
    }
    // GET status
    $sql = "
    SELECT id_status, feedback FROM task_progress 
    WHERE id_task_progress=
        (SELECT MAX(id_task_progress) FROM task_progress 
        WHERE id_task= $id_task);
    ";

    $result_status = $conn->query($sql);
    while ($row = $result_status->fetch_assoc()) {
        $output_status[] = $row;
    }
    $feedback = $output_status[0]['feedback'];
    $status = (int)$output_status[0]['id_status'];
    $status_saver = $status;

    $sql = "
    SELECT file FROM task_progress WHERE id_task='$id_task' and id_status = '$status_saver'; 
    ";
    $result_files = $conn->query($sql);
    while ($row = $result_files->fetch_assoc()) {
        $output_files[] = $row;
    }
    // var_dump($output_status[0]['id_status']);
    // var_dump($manager);
    if ($status == 0) {
        $status = 'New';
        $button_style_status = 'success';
        $status_button = 'Start';
    }
    if ($status == 2) {
        $status = 'In progress';
        $button_style_status = 'success';
        $status_button = 'Submit';
    }
    if ($status == 3) {
        $status = 'Waiting';
        $button_style_status = 'success';
        $status_button = 'Waiting';
        $isDisabled = "disabled";
    }
    if ($status == 4) {
        $status = 'Rejected';
        $button_style_status = 'primary';
        $status_button = 'Submit';
    }
    if ($status == 5) {
        $status = 'Completed';
        $button_style_status = 'success';
        $status_button = 'Completed';
        $isDisabled = "disabled";
    } else if ($status == 1) {
        $status = 'Cancelled';
        $button_style_status = 'danger';
        $status_button = 'Cancelled';
        $isDisabled = "disabled";
    }
    $sql = "SELECT full_name FROM employee WHERE id_employee=" . $manager;

    $truongphong = $conn->query($sql);
    while ($row2 = $truongphong->fetch_assoc()) {
        $output2[] = $row2;
    }
    $name_manager = $output2[0]['full_name'];
}

?>


<div class="page-wrapper bg-gra-03 p-t-45 p-b-50 ml-4 mr-5 pr-5 mb-5 mt-3" style="font-family:sans-serif;">
    <div class="wrapper wrapper--w790">
        <div class="card card-5">
            <div class="card-heading mt-5">
                <h2 class="title text-center">CHI TIẾT NHIỆM VỤ</h2>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <label for="name-department">Tên Nhiệm vụ</label>
                    <input value="<?= !empty($title) ? $title : '' ?>" name="name-department" type="text" class="form-control" placeholder="<?= $title ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea name="content" class="form-control" rows="3" disabled><?= !empty($content) ? $content : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label for="name-department">Người giao nhiệm vụ</label>
                    <input value="<?= !empty($name_manager) ? $name_manager : '' ?>" name="name" type="text" class="form-control" placeholder="<?= $name_manager ?>" disabled>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="name-department"> Hạn nộp</label>
                        <input value="<?= !empty($deadline) ? $deadline : '' ?>" name="name" type="text" class="form-control" placeholder="<?= $deadline ?>" disabled>
                    </div>

                    <div class="col">
                        <label for="name-department">Trạng thái</label>
                        <input value="<?= !empty($status) ? $status : '' ?>" name="name" type="text" class="form-control" placeholder="<?= $status ?>" disabled>
                    </div>
                </div>


                <?php
                if ($status_saver == 5) {
                    echo "
                    <div class='row'>
                    <div class='col'>
                        <div class='form-group mt-3'>
                            <label for='content'>Phản hồi của trưởng phòng</label>
                            <textarea class='form-control' rows='3' disabled>$feedback</textarea>
                        </div>
                    </div>
                    
                    <div class='col'>";
                    echo "
                        <div class='form-group mt-3'>
                            <label for='content'>Điểm đánh giá</label>
                            <textarea name='reate' class='form-control' rows='3' disabled>$rate</textarea>
                        </div>
                    </div>
                ";

                    echo "
                        </div>
                        ";
                }
                if ($status_saver == 0 || $status_saver == 4) {


                    echo '
                        <h6 class="mt-4 mb-2">Danh sách tệp đính kèm mà trưởng phòng gửi:</h6>
                        <table class="mt-2 table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên tệp đính kèm</th>
                                    <th scope="col" class="text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                        ';
                    if (isset($output_files[0]['file'])) {
                        $index = 0;
                        foreach ($output_files as $submission_file) {
                            echo '
                                <tr>
                                    <th scope="row">' . ++$index . '</th>
                                    <td>' . $submission_file['file'] . '</td>
                                    <td class="text-center">
                                    <a href="uploads/' . $submission_file['file'] . '" download="' . $submission_file['file'] . '" class="btn btn-sm btn-danger">Download</a>
                                </tr>
                            ';
                        }
                    } else {
                        echo '
                            <tr>
                                <td class="text-center" colspan="3">Chưa có tệp đính kèm</td>
                            </tr>
                        ';
                    }

                    echo '
                        </tbody>
                    </table>
                    <hr>
                    ';
                }
                if (isset($_POST['btn-task-submit-ok'])) {
                    if ($status_saver != 2 && $status_saver != 4) {
                        if ($status_saver == 0) {
                            $status_saver = $status_saver + 2;
                        } else {
                            $status_saver = $status_saver + 1;
                        }

                        $currentDate = new DateTime();
                        $currentDate = $currentDate->format('Y-m-d H:i:s');
                        $sql = "
                                INSERT INTO `task_progress` (`id_task_progress`, `id_task`, `file`, `id_status`, `time_progress`, `submission_content`, `feedback`) 
                                VALUES (NULL, '$id_task', 'sd', '$status_saver', '$currentDate', NULL, NULL);
                            ";
                        $result = $conn->query($sql);
                        var_dump($sql);
                        header('Location: index.php?type=task_employee&action=view');
                    }
                }
                if (isset($_POST['content-submit']) && isset($_FILES['upload-file-submit']) && isset($_POST['btn-task-submit-ok'])) {
                    $status_saver = 3;
                    $submission_content = $_POST['content-submit'];
                    $time_progress = date("Y-m-d");
                    $count_files = count($_FILES['upload-file-submit']['name']);
                    var_dump($count_files);
                    for ($i = 0; $i < $count_files; $i++) {
                        $file_name = $_FILES['upload-file-submit']['name'][$i];
                        move_uploaded_file($_FILES['upload-file-submit']['tmp_name'][$i], 'uploads/' . $file_name);
                        $sql = "
                                INSERT INTO task_progress(id_task, file, id_status, time_progress, submission_content)
                                VALUES($id_task, '$file_name', 3, '$time_progress', '$submission_content')
                            ";
                        $conn->query($sql);
                    }

                    header("Location: ?type=task_employee&action=view");
                }
                $print_button_nonsubmit_html = "
                    <form method='POST' >
                        <div class='text-right mt-3'>
                            <a class='btn btn-primary' href='?type=task_employee&action=view' role='button'>Trở về</a>
                            <input id='btn_status' data-toggle='modal' data-target='#confirm-employee-nonsubmit' class='btn btn-outline-$button_style_status' type='button' value='$status_button' $isDisabled>
                        </div>
                        <div class='modal fade show' id='confirm-employee-nonsubmit'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h4 class='modal-title'>Submit nhiệm vụ</h4>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                </div>

                                <div class='modal-body'>
                                    Bạn có chắc rằng muốn submit nhiệm vụ không?
                                </div>
                                <div class='modal-footer'>
                                    <button type='submit' name='btn-task-submit-ok' class='btn btn-danger'  name='btn-task-status'>Đồng ý</button>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Hủy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>";
                $print_feeback = "
                    <div class='form-group'>
                        <label for='content'>Phản hồi của trưởng phòng</label>
                        <textarea class='form-control' rows='3' disabled>$feedback</textarea>
                    </div>
                ";
                $status_saver = (int)$status_saver;
                $print_button_submit_html = "
                    
                <form id='form_employee_submit'  method='POST' enctype='multipart/form-data'>
                    <hr>
                    <h3 class='text-center'>Submit</h3>

                    <div class='form-group' id = 'content_employee_submit_wrapper'>
                        <label for='content'>Nội dung submit</label>
                        <textarea id='content_employee_submit' name='content-submit' class='form-control' rows='3' rules='required'></textarea>
                        <span class='form-message'></span>
                    </div>
                    <div class='form-group' id = 'file_employee_submit_wrapper'>
                        <label for='upload-files'>Các tập tin đính kèm</label>
                        <div class='custom-file'>
                            <input onchange='Filevalidation()' rules='required' id='file_employee_submit' name='upload-file-submit[]' multiple type='file' class='custom-file-input'>
                            <label class='custom-file-label' for='customFile'>Choose file</label>
                            
                        </div>
                        <span id = 'size' style = 'color: #f33a58;' class='form-message'></span>
                        
                    </div>
                    <div class='text-right'>
                        <button id='btn-employee-submit' data-target='#confirm-employee-submit' name='btn-task-submit' type='button' class='btn btn-primary mt-2'>Submit</button>
                    </div>
                    <div class='modal fade' id='confirm-employee-submit'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h4 class='modal-title'>Submit nhiệm vụ</h4>
                                    <button type='button' class='close' data-dismiss='modal'>&times;</button>
                                </div>

                                <div class='modal-body'>
                                    Bạn có chắc rằng muốn submit nhiệm vụ không?
                                </div>
                                <div class='modal-footer'>
                                    <button type='submit' name='btn-task-submit-ok' class='btn btn-danger'>Đồng ý</button>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Hủy</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                    ";
                if ($status_saver != 2 && $status_saver != 4) {
                    echo $print_button_nonsubmit_html;
                } elseif ($status_saver == 2) {
                    echo $print_button_submit_html;
                } elseif ($status_saver == 4) {
                    echo $print_feeback;
                    echo $print_button_submit_html;
                }

                ?>
            </div>

        </div>
    </div>
</div>
</div>