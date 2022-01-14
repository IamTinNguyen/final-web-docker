<?php
require_once "db.php";
$id = $_GET['id'];
$conn = open_database();
$sql = "SELECT employee.*,name_department,name_role 
        FROM employee,department,role 
        WHERE id_employee= 1 
        AND employee.id_role = role.id_role
        AND employee.id_department = department.id_department";
$result = $conn->query($sql) or die($conn->error);

while ($row = $result->fetch_assoc()) {
    $output[] = $row;
}

?>

<h3 class="my-3 text-center">THÔNG TIN NHÂN VIÊN</h3>

<table class="table table-hover">
        <?php
        $index = 0;
        foreach ($output as $value) {
            echo '
            <form>
                <div class="form-group">
                    <label for="username">Họ và tên:</label>
                    <input id="username" value="'.$value['full_name'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" value="'.$value['email'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="phone">Điện thoại:</label>
                    <input id="phone" value="+84'.$value['phone_number'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="phone">Địa chỉ:</label>
                    <input id="phone" value="'.$value['address'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="salary">Lương:</label>
                    <input id="salary" value="'.$value['salary'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="department">Phòng ban:</label>
                    <input id="department" value="'.$value['name_department'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <label for="role">Phòng ban:</label>
                    <input id="role" value="'.$value['name_role'].'" class="form-control" disabled>
                </div>

                <div class="form-group">
                    <button class="btn btn-success">                        
                        <a style="color: white;text-decoration:none" href="?type=employee&action=add&id=' . $value['id_employee'] . '">
                            Chỉnh sửa
                        </a>
                    </button>
                    <button type= "button" class="btn btn-danger" data-toggle="modal" data-target="#reset_password">
                        Đặt lại mật khẩu
                    </button>
                </div>
                    
                <div class="modal fade" id="reset_password">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Xác nhận</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
            
                            <div class="modal-body">
                                Xác nhận đặt lại mật khẩu?
                            </div>

                            <div class="modal-footer">
                                <a id="reset_password" href="?type=employee&action=appoint&id='  . $value['id_employee'] . ' "class="btn btn-sm btn-danger">
                                    Đặt lại mật khẩu
                                </a>
                                <a style="color: white" class="btn btn-sm btn-secondary" data-dismiss="modal">
                                    Hủy
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            ';
        }
        ?>
</table>