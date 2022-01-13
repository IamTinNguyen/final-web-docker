<?php
require_once "db.php";

$sql = $error = $username = '';
$conn = open_database();

/* Get Department */
$sql = "SELECT * FROM department";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $department[] = $row;
}

/* Get role */
$sql = "SELECT * FROM role";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $role[] = $row;
}

/* Get amount of account for insert to the last */
$sql = "SELECT * FROM account";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $amount[] = $row;
}
$id_account = count($amount);

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT employee.*,account.username,name_department,name_role
            FROM employee,account,department,role 
            WHERE id_employee= $id and account.id_account=$id and employee.id_department = department.id_department and employee.id_role=role.id_role";

    $result = $conn->query($sql) or die($conn->error);
    while ($row = $result->fetch_assoc()) {
        $output[] = $row;
    }

    $username = $output[0]['username'];
    $full_name = $output[0]['full_name'];
    $phone = $output[0]['phone_number'];
    $email = $output[0]['email'];
    $salary = $output[0]['salary'];
    $address = $output[0]['address'];
    $name_department = $output[0]['name_department'];
    $name_role = $output[0]['name_role'];
}

/* Insert to database */
if (isset($_POST['full_name']) && isset($_POST['username']) && isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['email']) && isset($_POST['salary'])) {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $name_department = $_POST['name_department'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $salary = $_POST['salary'];
    $hash_password = password_hash($username,PASSWORD_BCRYPT);
    foreach ($department as $department) {
        if($name_department == $department['name_department']) {
            $id_department = $department['id_department'];
        }
    }
}

if (isset($_POST['btn-submit'])) {
    if (isset($_GET['id'])) {
        $sql = "                
                UPDATE  employee
                SET     phone_number = '$phone', 
                        address = '$address', 
                        email = '$email',
                        salary = '$salary'
                WHERE   id_employee = $id
        ";

        $conn->query($sql) or die($conn->error);
    }
    else {
        {   
            $sql = "
                    INSERT INTO account(username,password)
                    VALUES('$username','$hash_password');   
                ";
            $conn->query($sql) or die($conn->error);
        }

        {
            $sql = "
                    INSERT INTO employee(full_name,id_account,id_department,id_role,phone_number,address,email,salary) 
                    VALUES('$full_name',$id_account+1,$id_department,2,$phone,'$address','$email',$salary);   
                ";
            $conn->query($sql) or die($conn->error);
        }
        header("Location: ?type=employee&action=view");
    }
}

?>
<script type="text/javascript">var employee =<?php echo json_encode($amount); ?>;</script>
<!-- Input form -->
<form method="POST" name="employee" id="employee">
    <div class="alert alert-danger text-center  " style="display: none;" id="errorMessage">
    </div>
    <div class="form-group">
        <label for="username">Tên người dùng</label>
        <input id="username" value="<?= !empty($username) ? $username : '' ?>" <?php if (!empty($username)) echo 'readonly'; else echo '' ?> name="username" type="text" class="form-control" placeholder="Nhập tên người dùng" required>
    </div>

    <div class="form-group">
        <label for="full_name">Họ tên</label>
        <input value="<?= !empty($full_name) ? $full_name : '' ?>" <?php if (!empty($full_name)) echo 'readonly'; else echo '' ?> name="full_name" type="text" class="form-control" placeholder="Nhập họ tên" required>
    </div>

    <div class="form-group">
        <label for="full_name">Phone</label>
        <input value="<?= !empty($phone) ? $phone : '' ?>" name="phone" type="text" class="form-control" placeholder="Nhập số điện thoại" required>
    </div>

    <div class="form-group">
        <label for="full_name">Dia Chi</label>
        <input value="<?= !empty($address) ? $address : '' ?>" name="address" type="text" class="form-control" placeholder="Nhập địa chỉ" required>
    </div>

    <div class="form-group">
        <label for="full_name">Email</label>
        <input value="<?= !empty($email) ? $email : '' ?>" name="email" type="email" class="form-control" placeholder="Nhập email" required>
    </div>

    <div class="form-group">
        <label for="full_name">Salary</label>
        <input value="<?= !empty($salary) ? $salary : '' ?>" name="salary" type="number" class="form-control" placeholder="Nhập mức lương"required>
    </div>

    <div class="form-group">
        <label for="id_department">Phòng ban</label>
        <select name="name_department" id="department" <?php if (!empty($name_department)) echo 'disabled'; else echo '' ?>>
            <?php
                foreach($department as $department) {
                    if ($department['name_department'] == $name_department) {
                        echo "<option selected >".$department['name_department']."</option>";
                    } 
                    else {
                        echo "<option>".$department['name_department']."</option>";
                    }
                } 
            ?>
        </select>
    </div>
    <button id="submit" name="btn-submit" type="submit" class="btn btn-success">Tạo</button>
</form>

