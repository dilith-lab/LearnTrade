<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quote</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
                        <li class="breadcrumb-item active">Quote</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->

    <h1>LearnTrade - Get Stock Data</h1>

    <form method="POST" action="quote.php">
        <label for="symbol">Stock Symbol:</label>
        <input type="text" id="symbol" name="symbol" required>
        <button type="submit">Get Stock Data</button>
    </form>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php elseif (isset($stockData)): ?>
        <h2>Stock Data for <?= htmlspecialchars($stockData['symbol']) ?></h2>
        <p>Company Name: <?= htmlspecialchars($stockData['company_name']) ?></p>
        <p>Last Trade Price: <?= htmlspecialchars($stockData['last_trade_price']) ?></p>
        <p>High Price: <?= htmlspecialchars($stockData['high_price']) ?></p>
        <p>Low Price: <?= htmlspecialchars($stockData['low_price']) ?></p>
    <?php endif; ?>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->