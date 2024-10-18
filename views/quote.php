<?php
# Login required
include "./includes/auth_check.inc.php";
include "../models/db.model.php";
include "../controllers/cse.contr.php";
# Page Information
$title = "Quote";

// Initialize the CSEContr controller (no need to pass the model explicitly)
$cseContr = new CSEContr();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['symbol'])) {
    $symbol = $_POST['symbol'];

    // Fetch stock data
    $stockData = $cseContr->fetchStockData($symbol);

    // Check if valid stock data was fetched
    if (!$stockData) {
        $status_code = 400;
        $message = "Invalid symbol";
    }else{
        $symbol = $stockData['symbol'];
        $company_name = $stockData['company_name']; 
        $last_trade_price = sprintf('%0.2f', $stockData['last_trade_price']);
        $closing_price = sprintf('%0.2f', $stockData['closing_price']);
        $previous_close = sprintf('%0.2f', $stockData['previous_close']);
        $high_price = sprintf('%0.2f', $stockData['high_price']);
        $low_price= sprintf('%0.2f', $stockData['low_price']);
        $change = sprintf('%0.2f', $stockData['change']);
        $changePercentage = sprintf('%0.2f', $stockData['change_percentage']);

        $company_logo = $stockData['company_logo'];

        // Define your parameters in PHP
        $widgetWidth = "100%";  // You can set this dynamically based on your needs
        $widgetHeight = "500"; // You can set this dynamically based on your needs
        $widgetSymbol = "CSELK:". $symbol; // You can set this dynamically based on your needs
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

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <?php
        include("./includes/navbar.inc.php");
        ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php
        $active_page = "quote";
        include("./includes/sidebar.inc.php");
        ?>
        <!-- /.Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <?php
        include("./pages/quote.inc.php");
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
    include("./includes/tradingview.inc.php");
    include("./includes/scripts.inc.php");
    ?>
</body>

</html>