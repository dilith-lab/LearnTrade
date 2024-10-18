<?php
# Login required
include "./includes/auth_check.inc.php";
include "../models/db.model.php";
include "../controllers/common.contr.php";
# Page Information
$title = "User Profile";

if (isset($_POST['submit'])) {
    $subjects = $_POST['subject'];
    foreach ($subjects as $subject) {
        #echo $subject . "<br>";
    }
}
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
        include("./pages/profile.inc.php")
        ?>
        <!-- /.content-wrapper -->

        <!-- footer -->
        <?php
        include("./includes/footer.inc.php")
        ?>
        <!-- /.footer -->

    </div>
    <!-- ./wrapper -->

</body>
<!-- Scripts -->
<?php
include("./includes/scripts.inc.php")
?>
<script>
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    function goBack() {
        window.history.back();
    }
</script>

</html>