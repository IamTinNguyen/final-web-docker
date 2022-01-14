<!-- <nav class="bg-light border-0 sidebar card" style='font-size:16px'>
    <ul class="nav flex-column" id="nav_accordion">
        <li class="nav-item">
            <a class="nav-link text-dark" href="#"> Dashboard </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" data-bs-toggle="collapse" data-bs-target="#menu_item1" href="#"> Quản lý tài khoản nhân viên <i class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item1" class="submenu collapse" data-bs-parent="#nav_accordion">
                <li><a class="nav-link text-dark" href="?type=employee&action=view">Xem danh sách nhân viên</a></li>
                <li><a class="nav-link text-dark" href="?type=employee&action=add">Thêm một nhân viên mới</a></li>
            </ul>

        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" href="?type=account&action=view"> Quản lý tài khoản cá nhân </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" data-bs-toggle="collapse" data-bs-target="#menu_item3" href="#"> Quản lý phòng ban <i class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item3" class="submenu collapse" data-bs-parent="#nav_accordion">
                <li><a class="nav-link text-dark" href="?type=department&action=view">Xem danh sách phòng ban</a></li>
                <li><a class="nav-link text-dark" href="?type=department&action=add">Thêm một phòng ban mới</a></li>
                <li><a class="nav-link text-dark" href="?type=department&action=appoint">Bổ nhiệm trưởng phòng</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link  text-dark" data-bs-toggle="collapse" data-bs-target="#menu_item4" href="#"> Quản lý nhiệm vụ phía trưởng phòng <i class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item4" class="submenu collapse" data-bs-parent="#nav_accordion">
                <li><a class="nav-link text-dark" href="?type=task_management&action=view">Xem danh sách nhiệm vụ</a></li>
                <li><a class="nav-link text-dark" href="?type=task_management&action=add">Thêm một nhiệm vụ mới</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" href="?type=task_employee&action=view"> Quản lý nhiệm vụ phía nhân viên </a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" data-bs-toggle="collapse" data-bs-target="#menu_item6" href="#"> Quản lý nghỉ phép <i class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item6" class="submenu collapse" data-bs-parent="#nav_accordion">
                <li><a class="nav-link text-dark" href="?type=absence_letter&action=view">Xem danh sách đơn nghỉ phép</a></li>
                <li><a class="nav-link text-dark" href="?type=absence_letter&action=add">Thêm đơn nghỉ phép</a></li>
            </ul>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" href="?type=reset_password"> Đổi mật khẩu</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-dark" href="?type=logout">Đăng xuất</a>
        </li>
    </ul>
</nav> -->
<?php
error_reporting(E_ERROR | E_PARSE);
if (!empty($_SESSION['user'][0]['employee_avatar'])) {
    $avatar = $_SESSION['user'][0]['employee_avatar'];
    $role = $_SESSION['user'][0]['id_role'];
    $fullname = $_SESSION['user'][0]['full_name'];
    if ((int) $role == 0) {
        $roleName = "Quản lý";
    } elseif ((int) $role == 1) {
        $roleName = "Trưởng phòng";
    } elseif ((int) $role == 2) {
        $roleName = "Nhân viên";
    }
} else {
    $avatar = "unknown_avatar.jpeg";
    $role = "";
    $fullname = "";
}
?>
<div class="sidebar" style="opacity: inherit;">
    <div class="logo-details">
        <i class='bx bxl-dev-to'></i>
        <span class="logo_name">E Manager</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="?type=account&action=view">
                <i class='bx bx-user-circle'></i>
                <span class="link_name">Tài khoản</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#"></a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="?type=employee&action=view">
                    <i class='bx bx-group'></i>
                    <span class="link_name">Nhân viên</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="?type=employee&action=view">Nhân viên</a></li>
                <li><a href="?type=employee&action=view">Danh sách</a></li>
                <li><a href="?type=employee&action=add">Thêm nhân viên</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="?type=department&action=view">
                    <i class='bx bx-briefcase'></i>
                    <span class="link_name">Phòng ban</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="?type=department&action=view">Phòng ban</a></li>
                <li><a href="?type=department&action=view">Danh sách</a></li>
                <li><a href="?type=department&action=add">Thêm phòng ban</a></li>
                <li><a href="?type=department&action=appoint">Bổ nhiệm</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="?type=task_management&action=view">
                    <i class='bx bx-calendar'></i>
                    <span class="link_name">Nhiệm vụ</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="?type=task_management&action=view">Nhiệm vụ</a></li>
                <li><a href="?type=task_management&action=view">Danh sách</a></li>
                <li><a href="?type=task_management&action=add">Thêm nhiệm vụ</a></li>
            </ul>
        </li>
        <li>
            <a href="?type=task_employee&action=view">
                <i class='bx bx-layer'></i>
                <span class="link_name">Nhiệm vụ</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="?type=task_employee&action=view">Nhiệm vụ</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="?type=absence_letter&action=add">
                    <i class='bx bx-mail-send'></i>
                    <span class="link_name">Nghỉ phép</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="?type=absence_letter&action=add">Nghỉ phép</a></li>
                <li><a href="?type=absence_letter&action=view">Danh sách</a></li>
                <li><a href="?type=absence_letter&action=add">Viết đơn</a></li>
            </ul>
        </li>
        <li>
            <a href="?type=reset_password">
                <i class='bx bx-cog'></i>
                <span class="link_name">Mật khẩu</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="?type=reset_password">Mật khẩu</a></li>
            </ul>
        </li>
        <li>
            <a href="?type=logout">
                <i class='bx bx-log-out'></i>
                <span class="link_name">Đăng xuất</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="?type=logout">Đăng xuất</a></li>
            </ul>
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <img src="uploads/<?= $avatar ?>" alt="profileImg">
                </div>
                <div class="name-job">
                    <div class="profile_name"><?= $roleName ?></div>
                    <div class="job"><?= $fullname ?></div>
                </div>
                <i class='bx bx-log-out'></i>
            </div>
        </li>
    </ul>
</div>
<section class="home-section">
    <div class="home-content">
        <i class='bx bx-menu'></i>
    </div>
</section>