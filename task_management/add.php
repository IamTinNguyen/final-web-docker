<?php
require_once "db.php";
date_default_timezone_set("Asia/Bangkok");

$id_employee = $title_task = $content_task = $deadline_task = '';
$id_manager = $_SESSION['user'][0]['id_employee'];
$conn = open_database();

if (isset($_GET['id_task'])) {
    $id_old_task = $_GET['id_task'];
    $sql = "
        SELECT      * 
        FROM        `task` 
        INNER JOIN  task_progress 
        ON          task.id_task = task_progress.id_task 
        WHERE       task.id_task = $id_old_task;
    ";

    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $task_detail[] = $row;
    }

    if ($task_detail[0]['id_status'] > 0) {
        header("Location: ?type=task_management&action=view");
    }

    $id_employee = $task_detail[0]['id_employee'];
    $title_task = $task_detail[0]['title_task'];
    $content_task = $task_detail[0]['content_task'];
    $deadline = $task_detail[0]['deadline'];
    $deadline = date("Y-m-d\TH:i:s", strtotime($deadline));
}

$current_department = $_SESSION['user'][0]['id_department'];
$sql = "
    SELECT  id_employee, full_name
    FROM    employee 
    WHERE   id_department = $current_department AND
            id_role = 2";

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

if (isset($_POST['id_employee']) && isset($_POST['title_task']) && isset($_POST['content_task']) && isset($_POST['deadline_task'])) {
    $id_employee = $_POST['id_employee'];
    $title_task = $_POST['title_task'];
    $content_task = $_POST['content_task'];
    $deadline_task = $_POST['deadline_task'];
    $deadline_task = date("Y-m-d H:i:s", strtotime($deadline_task));
    $time_progress = date("Y-m-d H:i:s");
}

$is_validated = true;
if (isset($_POST['btn-submit'])) {
    if (!empty($_FILES['uploaded_files']['name'][0])) {
        $count_files = count($_FILES['uploaded_files']['name']);
        for ($i = 0; $i < $count_files; $i++) {
            $file_name = $_FILES['uploaded_files']['name'][$i];
            $file_size = $_FILES['uploaded_files']['size'][$i];
            if ($file_size > 50000) {
                $is_validated = false;
            }
        }
    }

    if ($is_validated) {
        if (isset($_GET['id_task'])) {
            $sql = "
                UPDATE  `task`
                SET     `title_task` = '$title_task', 
                        `content_task` = '$content_task', 
                        `id_employee` = $id_employee,
                        `deadline` = '$deadline_task'
                WHERE   `id_task` = $id_old_task
            ";
            $conn->query($sql);

            $sql = "DELETE FROM task_progress WHERE `id_task` = $id_old_task";
            $conn->query($sql);

            if (!empty($_FILES['uploaded_files']['name'][0])) {
                $time_progress = date("Y-m-d H:i:s");
                $count_files = count($_FILES['uploaded_files']['name']);
                for ($i = 0; $i < $count_files; $i++) {
                    $file_name = $_FILES['uploaded_files']['name'][$i];
                    move_uploaded_file($_FILES['uploaded_files']['tmp_name'][$i], 'uploads/' . $file_name);
                    $sql = "
                        INSERT INTO task_progress(id_task, file, id_status, time_progress)
                        VALUES($id_old_task, '$file_name', 0, '$time_progress')
                    ";
                    $conn->query($sql);
                }
            } else {
                $sql = "
                    INSERT INTO task_progress(id_task, id_status, time_progress)
                    VALUES($id_old_task, 0, '$time_progress')
                ";
                $conn->query($sql);
            }
        } else {
            $sql = "
                INSERT INTO task(title_task, content_task, id_manager, id_employee, deadline) 
                VALUES('$title_task', '$content_task', $id_manager, $id_employee, '$deadline_task')
            ";
            // die($sql);
            $conn->query($sql);
            $id_task = $conn->insert_id;
            $time_progress = date("Y-m-d H:i:s");

            $count_files = count($_FILES['uploaded_files']['name']);
            for ($i = 0; $i < $count_files; $i++) {
                $file_name = $_FILES['uploaded_files']['name'][$i];
                move_uploaded_file($_FILES['uploaded_files']['tmp_name'][$i], 'uploads/' . $file_name);
                $sql = "
                    INSERT INTO task_progress(id_task, file, id_status, time_progress)
                    VALUES($id_task, '$file_name', 0, '$time_progress')
                ";
                $conn->query($sql);
            }
        }
        header("Location: ?type=task_management&action=view");
    } 
}
?>

<h3 class="my-3 text-center text-uppercase"><?= empty($id_old_task) ? 'THÊM MỘT NHIỆM VỤ MỚI' : 'CHỈNH SỬA NHIỆM VỤ "' . $task_detail[0]['title_task'] . '"' ?></h3>
<form id="add-task" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="name-employee">Tên nhân viên</label>
        <select name="id_employee" class="form-select">
            <option selected>Chọn nhân viên sẽ nhận nhiệm vụ</option>
            <?php
            foreach ($employees as $employee) {
                if (isset($id_employee) && ($id_employee == $employee['id_employee'])) {
                    echo '<option selected value=' . $employee['id_employee'] . '>' . $employee['full_name'] . '</option>';
                } else {
                    echo '<option value=' . $employee['id_employee'] . '>' . $employee['full_name'] . '</option>';
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="tittle-task">Tiêu đề nhiệm vụ</label>
        <input value="<?= !empty($title_task) ? $title_task : '' ?>" name="title_task" type="text" class="form-control" placeholder="Nhập tên nhiệm vụ">
    </div>

    <div class="form-group">
        <label for="content-task">Mô tả chi tiết</label>
        <textarea name="content_task" class="form-control" rows="3"><?= !empty($content_task) ? $content_task : '' ?></textarea>
    </div>

    <div class="form-group">
        <label for="deadline-task">Thời gian deadline</label>
        <input value="<?= !empty($deadline) ? date("Y-m-d\TH:i:s", strtotime($deadline)) : '' ?>" name="deadline_task" type="datetime-local" class="form-control">
    </div>

    <div class="form-group">
        <label for="upload-files">Các tập tin đính kèm</label>
        <div class="custom-file">
            <input id="uploaded-files" name="uploaded_files[]" multiple type="file" class="<?= (!$is_validated) ? 'is-invalid' : '' ?> custom-file-input">
            <?= (!$is_validated) ? '<div class="invalid-feedback">Vui lòng nhập file có kích thước nhỏ hơn 5MB!</div>' : '' ?>
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>

    <button name="btn-submit" type="submit" class="btn btn-primary">Submit</button>
</form>