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

<!-- <div class="sidebar close" style="opacity: inherit;">
    <div class="logo-details">
        <i class='bx bxl-c-plus-plus'></i>
        <span class="logo_name">E Manager</span>
    </div>
    <ul class="nav-links">
        <li>
            <a href="?type=employee&action=view">
                <i class='bx bx-grid-alt'></i>
                <span class="link_name">Tài khoản</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Category</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-collection'></i>
                    <span class="link_name">Category</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Category</a></li>
                <li><a href="#">HTML & CSS</a></li>
                <li><a href="#">JavaScript</a></li>
                <li><a href="#">PHP & MySQL</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-book-alt'></i>
                    <span class="link_name">Posts</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Posts</a></li>
                <li><a href="#">Web Design</a></li>
                <li><a href="#">Login Form</a></li>
                <li><a href="#">Card Design</a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-pie-chart-alt-2'></i>
                <span class="link_name">Analytics</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Analytics</a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-line-chart'></i>
                <span class="link_name">Chart</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Chart</a></li>
            </ul>
        </li>
        <li>
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-plug'></i>
                    <span class="link_name">Plugins</span>
                </a>
                <i class='bx bxs-chevron-down arrow'></i>
            </div>
            <ul class="sub-menu">
                <li><a class="link_name" href="#">Plugins</a></li>
                <li><a href="#">UI Face</a></li>
                <li><a href="#">Pigments</a></li>
                <li><a href="#">Box Icons</a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-compass'></i>
                <span class="link_name">Explore</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Explore</a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-history'></i>
                <span class="link_name">History</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">History</a></li>
            </ul>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-cog'></i>
                <span class="link_name">Setting</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="#">Setting</a></li>
            </ul>
        </li>
        <li>
            <div class="profile-details">
                <div class="profile-content">
                    <img src="image/profile.jpg" alt="profileImg">
                </div>
                <div class="name-job">
                    <div class="profile_name">Prem Shahi</div>
                    <div class="job">Web Desginer</div>
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
</section> -->