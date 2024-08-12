<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/brand.php";

    $db = new database();
    $brand = new brand($db);

    // get sub brand
    if (isset($_POST['get-sub-brand'])) {
        $id = $_POST['idBrand'];
        $result = $brand->selectSubBrandById($id);
        $arr = [];
        while ($row = $result->fetch_assoc()) {
            $arr[] = $row;
        }
        echo json_encode($arr);
        exit();
    }

    // add image
    if (isset($_POST['add-image'])) {
        $image = $_FILES['image'];
        $count = $_POST['count'];
        $dir = __DIR__ . "/../imageTmp/";
        $target_file = $dir . "image-" . $count . "." . pathinfo($image["name"], PATHINFO_EXTENSION);

        move_uploaded_file($image["tmp_name"], $target_file);

        echo "./imageTmp/image-" . $count . "." . pathinfo($image["name"], PATHINFO_EXTENSION);

        exit();
    }

    if (isset($_POST['add-product'])) {
        require_once __DIR__ . "/../../database/product.php";
        $name = $_POST['name'];
        $price = $_POST['price'];
        $idBrand = $_POST['idBrand'];
        $designType = $_POST['designType'];
        $size = json_decode($_POST['size']);
        $image = json_decode($_POST['image']);

        $product = new product($db);
        echo $product->insertProduct($idBrand, $designType, $name, $price, $size, $image);
        exit();
    }

?>

<div class="add-product container">
    <div class="title">
        <h1>Thêm sản phẩm</h1>
    </div>

    <div class="content">
        <form action="" method="post" class="row" id="formAddProduct" enctype="multipart/form-data">

            <div class="form-floating col-6 mb-3">
                <select class="form-select" id="brand" aria-label="Floating label select example">
                    <?php
                        $result = $brand->selectAll();
                        $id = 0;
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                            if ($i == 0) {
                                $id = $row['idBrand'];
                                $i++;
                    ?>
                    <option value="<?= $row['idBrand']; ?>" selected><?= $row['brandName']; ?></option>

                    <?php
                            }
                            else {
                    ?>
                    <option value="<?= $row['idBrand']; ?>"><?= $row['brandName']; ?></option>

                    <?php
                        }}
                    ?>
                </select>
                <label for="brand">Hãng</label>
            </div>

            <div class="form-floating col-6 mb-3">
                <select class="form-select" id="design-type" aria-label="Floating label select example">
                    <?php
                        $result = $brand->selectSubBrandById($id);
                        $i = 0;
                        while ($row = $result->fetch_assoc()) {
                            if ($i == 0) {
                                $i++;
                    ?>
                    <option value="<?= $row['subBrandName']; ?>" selected><?= $row['subBrandName']; ?></option>

                    <?php
                            }
                            else {
                    ?>
                    <option value="<?= $row['subBrandName']; ?>"><?= $row['subBrandName']; ?></option>

                    <?php
                        }}
                    ?>
                </select>
                <label for="design-type">Thiết kế</label>
            </div>

            <div class="form-floating mb-3 col-12">
                <input type="text" class="form-control" id="product-name" placeholder="Tên sản phẩm">
                <label for="product-name">Tên sản phẩm</label>
            </div>

            <div class="form-floating mb-3 col-6">
                <select class="form-select" id="product-size" aria-label="Floating label select example">

                </select>
                <label for="product-size">Size</label>
            </div>

            <div
                class="form-floating mb-3 col-6 d-flex justify-content-center align-items-center flex-column btn-add-size">
                <label for="" style="visibility: hidden;">Xóa size</label>
                <button type="button" class="btn btn-danger" id="delete-size">Xóa size</button>
            </div>

            <div class="form-floating mb-3 col-4">
                <input type="text" class="form-control" id="size-input" placeholder="Nhập size muốn thêm">
                <label for="size-input">Nhập size muốn thêm</label>
            </div>

            <div
                class="form-floating mb-3 col-2 d-flex justify-content-end align-items-center flex-column btn-add-size">
                <label for="" style="visibility: hidden;">Thêm size</label>
                <button type="button" class="btn btn-primary" id="add-size">Thêm size</button>
            </div>

            <div class="form-floating col-6 mb-3">
                <input type="text" class="form-control" id="product-price" placeholder="Giá">
                <label for="product-price">Giá</label>
            </div>

            <div class="image col-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">

                </div>
            </div>

            <div class="form-group mt-3 d-flex justify-content-center align-items-center col-12">
                <button class="btn btn-success" id="add-image">Thêm ảnh</button>
                <input type="file" name="image" id="image-input" accept="image/*" style="display: none;">
                <button class="btn btn-primary" id="save-product">Lưu</button>
            </div>

        </form>
    </div>
</div>