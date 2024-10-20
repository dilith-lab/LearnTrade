<?php
# Login required
include "./includes/auth_check.inc.php";
include "../models/db.model.php";
include "../controllers/wallet.contr.php";
# Page Information
$title = "User Profile";

if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];
    $walletModel = new Wallet();  // Instantiate the Wallet model
    $walletContr = new WalletContr($walletModel);  // Pass the model instance to the controller

    $fetch = $walletContr->viewWalletBalance($user_id);

    if($fetch){
        $cash_wallet = number_format($fetch['cash'], 2);
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