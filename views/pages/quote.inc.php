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
    <section class="content">
        <?php if (isset($status_code) && $status_code == 400) : ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                <?php echo $message; ?>
            </div>
        <?php elseif (isset($status_code) && $status_code == 100) : ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Alert!</h5>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Quote</h3>
                        </div>
                        <form method="POST" action="quote.php">
                            <div class="card-body mb-5">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Symbol</label>
                                    <input type="text" class="form-control" id="symbol" name="symbol" placeholder="Enter CSE Symbol" value="<?php if (isset($symbol)) echo $symbol; ?>">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary float-right">Quote</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo isset($company_name) ? $company_name : "Company Summary"; ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="description-block border-right">
                                        <?php if (isset($change) && $change < 0): ?>
                                            <span class="description-percentage text-danger"><i class="fas fa-caret-down"></i></span>
                                            <span class="badge badge-danger"><?php echo isset($change) ? $change : "0.00"; ?></span>
                                            <span class="badge badge-danger"><?php echo isset($changePercentage) ? '(' . $changePercentage . '%)' : "(-0.00%)"; ?></span>
                                        <?php else: ?>
                                            <span class="description-percentage text-success"><i class="fas fa-caret-up"></i></span>
                                            <span class="badge badge-success"><?php echo isset($change) ? $change : "0.00"; ?></span>
                                            <span class="badge badge-success"><?php echo isset($changePercentage) ? '(' . $changePercentage . '%)' : "(0.00%)"; ?></span>
                                        <?php endif; ?>
                                        <h1><?php echo isset($last_trade_price) ? $last_trade_price : "0.00"; ?></h1>
                                        <span class="description-text">Last Traded Price (Rs)</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <h3><?php echo isset($closing_price) ? $closing_price : "0.00"; ?></h3>
                                        <span class="description-text">Close Price (Rs)</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <h3><?php echo isset($previous_close) ? $previous_close : "0.00"; ?></h3>
                                        <span class="description-text">Previous Close (Rs.)</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <?php if (isset($company_logo)): ?>
                                        <img src="https://cdn.cse.lk/cmt/<?php echo $company_logo ?>" alt="company-logo" class="img-fluid">
                                    <?php endif; ?>
                                </div>
                                <div class="col-sm-3 col-6">
                                    <div class="description-block border-right">
                                        <h3><?php echo isset($high_price) ? $high_price : "0.00"; ?></h3>
                                        <span class="description-text">High Price (Rs)</span>
                                    </div>
                                </div>

                                <div class="col-sm-3 col-6">
                                    <div class="description-block">
                                        <h3><?php echo isset($low_price) ? $low_price : "0.00"; ?></h3>
                                        <span class="description-text">Low Close (Rs.)</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5 class="card-title">Technical Chart </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="tradingview-widget"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>
<!-- /.content-wrapper -->