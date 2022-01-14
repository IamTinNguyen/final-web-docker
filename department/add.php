<?php
require_once "db.php";

$name_department = $description = $room = $sql = '';
$conn = open_database();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM department WHERE id_department=" . $id;

    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $output[] = $row;
    }

    $name_department = $output[0]['name_department'];
    $description = $output[0]['description'];
    $room = $output[0]['room'];
}

if (isset($_POST['name-department']) && isset($_POST['description']) && isset($_POST['room'])) {
    $name_department = $_POST['name-department'];
    $description = $_POST['description'];
    $room = $_POST['room'];
}

if (isset($_POST['btn-submit'])) {
    if (isset($_GET['id'])) {
        $sql = "
                UPDATE  `department`
                SET     `name_department` = '$name_department', 
                        `description` = '$description', 
                        `room` = '$room'
                WHERE   `id_department` = $id
            ";
        $conn->query($sql);
    } else {
        $sql = "
                INSERT INTO department(name_department, description, room) 
                VALUES('$name_department', '$description', '$room')
            ";
        $conn->query($sql);
    }

    header("Location: ?type=department&action=view");
}

?>

<h3 class="my-3 text-center"><?= !isset($_GET['id']) ? 'THÊM MỘT PHÒNG BAN MỚI' : 'CHỈNH SỬA PHÒNG BAN' ?></h3>

<form method="POST">
    <div class="form-group">
        <label for="name-department">Tên phòng ban</label>
        <input required value="<?= !empty($name_department) ? $name_department : '' ?>" name="name-department" type="text" class="form-control" placeholder="Nhập tên phòng ban">
    </div>

    <div class="form-group">
        <label for="description">Mô tả</label>
        <textarea required name="description" class="form-control" rows="3"><?= !empty($description) ? $description : '' ?></textarea>
    </div>

    <div class="form-group">
        <label for="room">Số phòng</label>
        <input required value="<?= !empty($room) ? $room : '' ?>" name="room" type="text" class="form-control" placeholder="Nhập số phòng">
    </div>

    <button name="btn-submit" type="submit" class="btn btn-primary">Submit</button>
</form>