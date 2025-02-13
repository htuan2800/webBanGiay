<?php
require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/../../database/supplier.php";

$db = new database();
$supplier = new supplier($db);

if (isset($_POST['add-supplier'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    echo $supplier->insertSupplier($name, $phone, $email, $address);
    exit();
}

?>

<div class="add-supplier container">
    <div class="title">
        <h1>Thêm nhà cung cấp</h1>
    </div>

    <div class="content">
        <form action="" method="post" class="row" id="formAddProduct" enctype="multipart/form-data">

            <div class="form-floating mb-3 col-12">
                <input type="text" class="form-control" id="supplier-name" placeholder="Tên sản phẩm">
                <label for="product-name">Tên nhà cung cấp</label>
            </div>
            <div class="form-floating mb-3 col-12">
                <input type="text" class="form-control" id="supplier-phone" placeholder="Tên sản phẩm">
                <label for="product-name">Số điện thoại</label>
            </div>
            <div class="form-floating mb-3 col-12">
                <input type="text" class="form-control" id="supplier-email" placeholder="Tên sản phẩm">
                <label for="product-name">Email</label>
            </div>
            <div class="form-floating mb-3 col-12">
                <input type="text" class="form-control" id="supplier-address" placeholder="Tên sản phẩm">
                <label for="product-name">Địa chỉ</label>
            </div>
            <div class="image col-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">

                </div>
            </div>

            <div class="form-group mt-3 d-flex justify-content-center align-items-center col-12">
                <button class="btn btn-primary" id="save-supplier">Thêm nhà cung cấp</button>
            </div>

        </form>
    </div>
</div>