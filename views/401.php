<?php
# Login required
include "./includes/auth_check.inc.php";

include "../models/db.model.php";

# Page Information
$title = "500 Error Page";

?>
<!DOCTYPE html>
<html lang="en">
<!-- Header -->
<?php
include("./includes/header.inc.php")
?>
<!-- ./Header -->

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php
        include("./includes/navbar.inc.php")
        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
        include("./includes/sidebar.inc.php")
        ?>
        <!-- /.Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <?php
        include("./pages/401.inc.php")
        ?>
        <!-- /.content-wrapper -->

        <!-- footer -->
        <?php
        include("./includes/footer.inc.php")
        ?>
        <!-- /.footer -->

    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/adminlte.min.js"></script>
</body>

</html>