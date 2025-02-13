<?php
require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/../../database/supplier.php";

$db = new database();
$supplier = new supplier($db);

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];

    echo $supplier->updateSupplier($id, $name, $phone, $email, $address);
    exit();
}

if (isset($_POST['edit-supplier'])) {
    $id = $_POST['id'];
    $staff = $supplier->selectById($id);
    // echo json_encode($staff);
    // exit();
}
?>

<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Sửa thông tin nhà cung cấp</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <form action="" class="container-fluid row">
            <div class="mb-3 col-12">
                <label for="full-name" class="form-label">Tên nhà cung cấp</label>
                <input type="text" class="form-control" id="supplier-name-edit" placeholder="Nhập tên nhà cung cấp"
                    value="<?php echo $staff['nameSupplier']; ?>">
                <span class="text-danger"></span>
            </div>
            <div class="mb-3 col-12">
                <label for="full-name" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="supplier-phone-edit" placeholder="Nhập số điện thoại"
                    value="<?php echo $staff['phoneNumber']; ?>">
                <span class="text-danger"></span>
            </div>
            <div class="mb-3 col-12">
                <label for="full-name" class="form-label">Email</label>
                <input type="text" class="form-control" id="supplier-email-edit" placeholder="Nhập email"
                    value="<?php echo $staff['email']; ?>">
                <span class="text-danger"></span>
            </div>
            <div class="mb-3 col-12">
                <label for="full-name" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="supplier-address-edit" placeholder="Nhập địa chỉ"
                    value="<?php echo $staff['addressSupplier']; ?>">
                <span class="text-danger"></span>
            </div>
        </form>
    </div>
    <div class="modal-footer d-flex justify-content-center">
        <button type="button" class="btn btn-primary" id="save-btn" data-id="<?php echo $staff['idSupplier']; ?>">Lưu
            thay
            đổi</button>
    </div>
</div>