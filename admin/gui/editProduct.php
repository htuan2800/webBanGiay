<?php
    require_once __DIR__ . "/../../database/database.php";
    require_once __DIR__ . "/../../database/product.php";
    require_once __DIR__ . "/../../database/brand.php";

    $db = new database();

    $product = new product($db);
    $brand = new brand($db);

    // select all subbrands
    if (isset ($_POST['get-sub-brand'])) {
        $idBrand = $_POST['idBrand'];
        $subBrands = $brand->selectSubBrandById($idBrand);
        $arr = [];
        while ($row = $subBrands->fetch_assoc()) {
            $arr[] = $row;
        }
        echo json_encode ($arr);
        exit();
    }

    // update brand and design type
    if (isset ($_POST['update-brand'])){
        $idProduct = $_POST['idProduct'];
        $idBrand = $_POST['idBrand'];
        $designType = $_POST['designType'];
        echo $product->updateBrandAndDesignType($idBrand,$designType,$idProduct);
        exit ();
    }

    // delete image
    if (isset ($_POST['delete-image'])) {
        $idImage = $_POST['id-image'];
        echo $product->deleteImageProduct($idImage);
        exit ();
    }

    // update image
    if (isset ($_POST['update-image'])) {
        $idImage = $_POST['id-image'];
        $image = $_FILES['image'];
        echo $product->updateImageProduct($idImage, $image);
        exit ();
    }

    // add image
    if (isset ($_POST['add-image'])) {
        $idProduct = $_POST['id-product'];
        $image = $_FILES['image'];
        echo json_encode($product->addImageProduct($idProduct, $image));
        exit ();
    }

    // update name and price
    if (isset ($_POST['update-name-and-price'])) {
        $id = $_POST['idProduct'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        echo $product->updateNameAndPrice($id, $name, $price);
        exit ();
    }

    // add size
    if (isset ($_POST['add-size'])) {
        $idProduct = $_POST['idProduct'];
        $size = $_POST['size'];
        echo $product->addSizeProduct($idProduct, $size);
        exit ();
    }

    // delete size
    if (isset ($_POST['delete-size'])) {
        $idProduct = $_POST['idProduct'];
        $size = $_POST['size'];
        echo $product->deleteSizeProduct($idProduct, $size);
        exit ();
    }

    // show edit modal
    if (isset ($_POST['edit-product'])) {
        $id = $_POST['id'];
        $products = $product->selectProductById($id);
        $images = $product->selectImageById($id);
        $sizes = $product->selectSizeById($id);
        $brands = $brand->selectAll();
        $subBrands = $brand->selectSubBrandById($products['idBrand']);
    }
?>

<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Sửa sản phẩm</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        <div class="container-fluid row">
            <div class="form-group col-6">
                <label for="brand">Hãng sản phẩm</label>
                <select name="brand" id="brand" class="form-control">
                    <?php
                        foreach ($brands as $brand) {
                            if ($brand['idBrand'] == $products['idBrand']) {
                                echo '<option value="' . $brand['idBrand'] . '" selected>' . $brand['brandName'] . '</option>';
                            } else {
                                echo '<option value="' . $brand['idBrand'] . '">' . $brand['brandName'] . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="form-group col-6">
                <label for="type">Thiết kế</label>
                <select name="type" id="type" class="form-control">
                    <?php
                        foreach ($subBrands as $subBrand) {
                            if ($subBrand['subBrandName'] == $products['designType']) {
                                echo '<option value="' . $subBrand['subBrandName'] . '" selected>' . $subBrand['subBrandName'] . '</option>';
                            } else {
                                echo '<option value="' . $subBrand['subBrandName'] . '">' . $subBrand['subBrandName'] . '</option>';
                            }
                        }
                    ?>
                </select>
            </div>

            <div class="form-group col-12">
                <label for="product-name">Tên sản phẩm</label>
                <input type="text" name="product-name" id="product-name" class="form-control"
                    value="<?= $products['productName'] ?>" />
            </div>

            <div class="form-group col-3">
                <label for="description">Size</label>
                <select name="size" id="select-size" class="form-control">
                    <?php
                        $quantity = 0;
                        $i = 0;
                        foreach ($sizes as $size) {
                            if ($i == 0) {
                                $quantity = $size['quantityRemain'];
                                $i++;
                            }
                    ?>

                    <option value="<?= $size['size'] ?>" data-quantity="<?= $size['quantityRemain'] ?>">
                        <?= $size['size'] ?>
                    </option>

                    <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group col-3 d-flex justify-content-center align-items-center"
                style="flex-direction: column;">
                <label for="" style="visibility: hidden">Xóa</label>
                <button class="btn btn-danger" id="delete-size" style="font-size: 12px;">Xóa size</button>
            </div>


            <div class=" form-group col-6">
                <label for="quantity">Số lượng còn</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="<?= $quantity ?>"
                    readonly />
            </div>

            <div class="form-group col-6">
                <label for="price">Giá</label>
                <input type="text" name="price" id="price" class="form-control"
                    value="<?= $products['currentPrice'] ?>" />
            </div>

            <div class="form-group col-6 d-flex justify-content-center align-items-center"
                style="flex-direction: column;">
                <label for="" style="visibility: hidden">Lưu giá</label>
                <button class="btn btn-success" id="save-price" style="font-size: 12px;">Lưu giá</button>
            </div>

            <div class="form-group col-12">
                <label for="quantity">Số lượng bán</label>
                <input type="number" name="quantity" id="quantity-sold" class="form-control"
                    value="<?= $products['quantitySold'] ?>" readonly data-id-product="<?= $products['idProduct'];?>" />
            </div>

            <div class="image col-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <?php
                        $i = 1;
                        foreach ($images as $image) {
                            $collapseId = "flush-collapse" . $i;
                            $headingId = "flush-heading" . $i;
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="<?= $headingId ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#<?= $collapseId ?>" aria-expanded="false"
                                aria-controls="<?= $collapseId ?>">
                                Ảnh <?= $i ?>
                            </button>
                        </h2>
                        <div id="<?= $collapseId ?>" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <?php
                                    $imagePath = '.' . $image['image'];
                                ?>
                                <img src="<?php echo $imagePath ?>" alt="" class="img-fluid" />
                                <div class="btn-tools">
                                    <button class="btn btn-danger btn-delete-image"
                                        data-id=" <?= $image['idImage'] ?>">Xóa ảnh</button>
                                    <button class="btn btn-warning btn-update-image">Sửa ảnh</button>
                                    <input type="file" class="input-image" accept="image/*" name="image" id=""
                                        style="display: none;" data-id=" <?= $image['idImage'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                            $i++;
                        }
                    ?>
                </div>

            </div>
        </div>
    </div>

    <div class="modal-footer justify-content-center">
        <div>
            <button type="button" class="btn btn-secondary add-size" style="display: block;">Thêm size</button>
            <input type="text" name="size" id="add-size" placeholder="Nhập size cần thêm" class="form-control"
                style="display: none;">
        </div>
        <button type="button" class="btn btn-primary add-image">Thêm ảnh</button>
        <input type="file" name="image" accept="image/*" style="display: none;">
    </div>
</div>