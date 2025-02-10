<link rel="stylesheet" href="styles.css">
<script src="script.js" defer></script>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<aside class="sidebar">
    <div class="logo-details">
        <div class="logo_name">constGenius</div>
        <i class='bx bx-menu' id="btn"></i>
    </div>
    <ul class="nav-list">
        <li>
            <i class='bx bx-search'></i>
            <input type="text" placeholder="Search...">
            <span class="tooltip">Search</span>
        </li>
        <li>
            <a href="#">
                <i class='bx bx-grid-alt'></i>
                <span class="links_name">Dashboard</span>
            </a>
            <span class="tooltip">Dashboard</span>
        </li>
        <li>
            <a href="sidebarManageemployee.php">
                <i class='bx bx-user'></i>
                <span class="links_name">List of Employees</span>
            </a>
            <span class="tooltip">Employees</span>
        </li>
        <li>
            <a href="manage_contributions.php">
                <i class='bx bx-donate-heart'></i>
                <span class="links_name">Contributions</span>
            </a>
            <span class="tooltip">Contributions</span>
        </li>
        <li>
            <a href="sidebar.php">
                <i class='bx bx-calculator'></i>
                <span class="links_name">Computation 1-15</span>
            </a>
            <span class="tooltip">Computation1</span>
        </li>

        <li>
            <a href="computation2.php">
                <i class='bx bx-calculator'></i>
                <span class="links_name">Computation 16-30</span>
            </a>
            <span class="tooltip">Computation2</span>
        </li>
        <li>
            <a href="manage_overload.php">
                <i class='bx bx-time'></i>
                <span class="links_name">Manage Overload</span>
            </a>
            <span class="tooltip">Overload</span>
        </li>
        <li>
            <a href="">
                <i class='bx bx-cog'></i>
                <span class="links_name">Settings</span>
            </a>
            <span class="tooltip">Settings</span>
        </li>
        <li class="profile">
            <div class="profile-details">
                <img src="./images/profile.png" alt="profileImg">
            </div>
            <i class='bx bx-log-out' id="log_out"></i>
        </li>
    </ul>
</aside>

<!-- hggh -->