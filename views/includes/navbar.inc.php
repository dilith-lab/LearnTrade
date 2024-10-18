<!-- Navbar -->
<nav class="main-header navbar navbar-expand">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button" data-enable-remember="true"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="./index.php" class="nav-link">Home</a>
        </li>
    </ul>
    
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <?php if(ALERTS_OPTION): ?>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li>
        <?php endif; ?>
        <?php if(FULL_SCREEN_OPTION): ?>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <?php endif; ?>
        <?php if(DARK_MODE_OPTION): ?>
        <li class="nav-item">
            <a class="nav-link" id="dark-mode-toggle" href="#" role="button">
                <i class="fas fa-moon"></i>
            </a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link d-sm-none" href="./logout.php" role="button">
                <i class="fa fa-power-off"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="./logout.php" class="nav-link bg-danger">Logout</a>
        </li>
    </ul>
</nav>
<!-- /.navbar -->