<?php
require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/../../database/role.php";

$db = new Database();
$role = new Role($db);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['account_login'])) {
    $result = $role->selectRoleById($_SESSION['account_login']['idRole']);
}

?>

<div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
        <a href="http://localhost/webBanGiay/admin/" class="logo">
            <img src="../image/logo/navbar-logo.png" alt="navbar brand" class="navbar-brand" height="20" />
        </a>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
            </button>
        </div>
        <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
        </button>
    </div>
    <!-- End Logo Header -->
</div>
<div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
        <ul class="nav nav-secondary">
            <li class="nav-item active">
                <a href="http://localhost/webBanGiay/admin/">
                    <i class="far fa-chart-bar"></i>
                    <p>Thống kê</p>
                </a>
            </li>
            <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section">Quản lý thông tin</h4>
            </li>

            <?php
            $current = 0;
            foreach ($result as $key => $value) {
            ?>

                <?php
                if ($value['idPermission'] == 1) {
                ?>

                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#manage-customer">
                            <i class="fas fa-users"></i>
                            <p>Quản lý khách hàng</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="manage-customer">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="./gui/infoCustomer.php">
                                        <span class="sub-item">Thông tin khách hàng</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                <?php
                }
                ?>

                <?php
                if ($value['idPermission'] == 2) {
                ?>

                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#manage-staff">
                            <i class="fas fa-user"></i>
                            <p>Quản lý nhân viên</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="manage-staff">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="./gui/infoStaff.php">
                                        <span class="sub-item">Thông tin nhân viên</span>
                                    </a>
                                    <?php
                                    if ($value['idTask'] == 1) {
                                    ?>
                                        <a href="./gui/addStaff.php">
                                            <span class="sub-item">Thêm nhân viên</span>
                                        </a>
                                    <?php
                                    }
                                    ?>

                                </li>
                            </ul>
                        </div>
                    </li>

                <?php
                }
                ?>

                <?php
                if ($value['idPermission'] == 7) {
                ?>

                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#manage-collection">
                            <i class="fas fa-shopping-bag"></i>
                            <p>Quản lý danh mục </p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="manage-collection">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="./gui/infoCollection.php">
                                        <span class="sub-item">Quản lí danh mục sản phẩm</span>
                                    </a>
                                    <?php
                                    if ($value['idTask'] == 1) {
                                    ?>
                                        <a href="./gui/addCollection.php">
                                            <span class="sub-item">Thêm danh mục</span>
                                        </a>
                                    <?php
                                    }
                                    ?>

                                </li>
                            </ul>
                        </div>
                    </li>


                <?php
                }
                ?>
                <?php
                if ($value['idPermission'] == 3) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#manage-product">
                            <i class="fas fa-shopping-bag"></i>
                            <p>Quản lý sản phẩm</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="manage-product">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="./gui/infoProduct.php">
                                        <span class="sub-item">Thông tin sản phẩm</span>
                                    </a>
                                </li>
                                <?php
                                if ($value['idTask'] == 1) {
                                ?>
                                    <li>
                                        <a href="./gui/addProduct.php">
                                            <span class="sub-item">Thêm sản phẩm</span>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </li>

                <?php
                }
                ?>

                <?php
                if ($value['idPermission'] == 4) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#manage-order">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Quản lý đơn hàng</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="manage-order">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="./gui/orderApproval.php">
                                        <span class="sub-item">Duyệt đơn hàng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="./gui/orderDelivery.php">
                                        <span class="sub-item">Giao hàng</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="./gui/orderDeliveried.php">
                                        <span class="sub-item">Đơn hàng đã hoàn thành</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                <?php
                }
                ?>

                <?php
                if ($value['idPermission'] == 5) {
                ?>
                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#manage-receipt">
                            <i class="fas fa-copy"></i>
                            <p>Nhập hàng</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="manage-receipt">
                            <ul class="nav nav-collapse">
                                <?php
                                if ($value['idTask'] == 1) {
                                ?>
                                    <li>
                                        <a href="maps/googlemaps.html">
                                            <span class="sub-item">Nhập hàng</span>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                                <li>
                                    <a href="maps/jsvectormap.html">
                                        <span class="sub-item">Thông tin nhập hàng</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                <?php
                }
                ?>

                <?php
                if ($value['idPermission'] == 6) {
                ?>

                    <li class="nav-item">
                        <a data-bs-toggle="collapse" href="#manage-authorize">
                            <i class="fas fa-credit-card"></i>
                            <p>Quản lý phân quyền</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse" id="manage-authorize">
                            <ul class="nav nav-collapse">
                                <li>
                                    <a href="./gui/infoRole.php">
                                        <span class="sub-item">Xem các quyền</span>
                                    </a>
                                </li>
                                <?php
                                if ($value['idTask'] == 1) {
                                ?>
                                    <li>
                                        <a href="./gui/addRole.php">
                                            <span class="sub-item">Thêm quyền</span>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </li>

                <?php
                }
                ?>
            <?php
            }
            ?>
        </ul>
    </div>
</div>

<!-- 
Fatal error: Uncaught TypeError: Cannot access offset of type string on string in D:\xampp\htdocs\webBanGiay\admin\gui\sidebar.php:54 Stack trace: #0 D:\xampp\htdocs\webBanGiay\admin\index.php(63): include() #1 {main} thrown in D:\xampp\htdocs\webBanGiay\admin\gui\sidebar.php on line 54
-->