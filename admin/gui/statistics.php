<?php
    require_once __DIR__ . '\\..\\..\\database\\database.php';
    require_once __DIR__ . '\\..\\..\\database\\user.php';
    require_once __DIR__ . '\\..\\..\\database\\product.php';
    require_once __DIR__ . '\\..\\..\\database\\bill.php';

    $db = new database();
    $user = new user($db);
    $product = new product($db);
    $bill = new bill($db);

    if (isset ($_POST['getCustomer'])) {
        echo json_encode($user->getQuantityCustomerByMonth());
        exit();
    }
?>

<div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Khách hàng</p>
                                <h4 class="card-title"><?php echo $user->getQuantityCustomer();?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-luggage-cart"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Số sản phẩm</p>
                                <h4 class="card-title"><?php echo $product->getQuantityProduct(); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                <i class="far fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Đơn hàng cần duyệt</p>
                                <h4 class="card-title"><?php echo $bill->getQuantityBillNeedApproval(); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Thống kê người dùng</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="min-height: 375px">
                        <canvas id="statisticsChart"></canvas>
                    </div>
                    <div id="myChartLegend"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Thống kê hôm nay</div>

                    </div>
                    <div class="card-category"><?php echo date("d/m/Y"); ?></div>
                </div>
                <div class="card-body pb-0">
                    <div class="mb-4 mt-2">
                        <h1><?php echo $bill->getRevenueToday(); ?></h1>
                    </div>
                    <div class="pull-in">
                        <canvas id="dailySalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>