<?php
# Login required
include "./includes/auth_check.inc.php";
include "../models/db.model.php";
# Page Information
$title = "Dashboard";

?>
<!DOCTYPE html>
<html lang="en">
<!-- Header -->
<?php
include("./includes/header.inc.php")
?>
<!-- ./Header -->

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="<?php echo APP_LOGO ?>" alt="<?php echo APP_NAME ?>" height="60" width="60">
    </div>

    <!-- Navbar -->
    <?php
    include("./includes/navbar.inc.php");
    ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php
    $active_page = "dashboard";
    include("./includes/sidebar.inc.php");
    ?>
    <!-- /.Main Sidebar Container -->

    <!-- Content Wrapper. Contains page content -->
    <?php
    include("./pages/dashboard.inc.php");
    ?>
    <!-- /.content-wrapper -->

    <!-- footer -->
    <?php
    include("./includes/footer.inc.php");
    ?>
    <!-- /.footer -->

  </div>
  <!-- ./wrapper -->

  <!-- Scripts -->
  <?php
  // Define your parameters in PHP
  $widgetWidth = "50%";  // You can set this dynamically based on your needs
  $widgetHeight = "700"; // You can set this dynamically based on your needs
  $widgetSymbol = "CSELK:ASI"; // You can set this dynamically based on your needs

  include("./includes/tradingview.inc.php");
  include("./includes/scripts.inc.php");
  ?>
</body>

</html>