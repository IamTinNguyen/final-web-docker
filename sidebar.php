<nav class="bg-light border-0 sidebar card" style='font-size:16px'>
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
</nav>

