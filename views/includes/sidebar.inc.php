<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-primary">
    <!-- Brand Logo -->
    <a href="../index.php" class="brand-link">
        <img src="<?php echo APP_LOGO_INVERT ?>" alt="<?php echo APP_NAME ?>" class="brand-image" style="opacity: 1">
        <span class="brand-text font-weight-light"><?php echo APP_NAME; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../dist/img/default-user.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="./profile.php" class="d-block">
                    <?php if (isset($_SESSION['first_name']))
                        echo $_SESSION['first_name'] . " " . $_SESSION['last_name'] ?>
                </a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon classwith font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="./index.php" class="nav-link <?php if ($active_page == 'dashboard') echo 'active';  ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">CLASS</li>
                <li class="nav-item">
                    <a href="#" class="nav-link <?php if ($active_page == 'class') echo 'active';  ?>">
                        <i class="nav-icon fas fa-school"></i>
                        <p>View Class</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>