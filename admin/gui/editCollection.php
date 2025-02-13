<?php
require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/../../database/brand.php";

$db = new database();
$brand = new brand($db);

// select all subbrands
if (isset($_POST['get-sub-brand'])) {
    $idBrand = $_POST['idBrand'];
    $subBrands = $brand->selectSubBrandById($idBrand);
    $arr = [];
    while ($row = $subBrands->fetch_assoc()) {
        $arr[] = $row;
    }
    echo json_encode($arr);
    exit();
}

// update brand 
if (isset($_POST['update-brand'])) {

    $idBrand = $_POST['idBrand'];
    $brandName = $_POST["brandName"];
    if (isset($_FILES["img"])) {
        $img = $_FILES["img"];
        echo $brand->updateBrand($idBrand, $brandName, $img);
        exit();
    }

    echo $brand->updateBrand($idBrand, $brandName, null);
    exit();
}


// update image
if (isset($_POST['update-image'])) {
    $idImage = $_POST['id-image'];
    $image = $_FILES['image'];
    echo $product->updateImageProduct($idImage, $image);
    exit();
}

// add image
if (isset($_POST['add-image'])) {
    $idProduct = $_POST['id-product'];
    $image = $_FILES['image'];
    echo json_encode($product->addImageProduct($idProduct, $image));
    exit();
}



// show edit modal
if (isset($_POST['edit-collection'])) {
    $id = $_POST['id'];
    $brands = $brand->selectById($id);
    $subBrands = $brand->selectSubBrandById($id);
}
?>

<div class="modal-content">
    <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Sửa danh mục</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="container-fluid row">
            <!-- name brand -->
            <div class="form-group col-12">
                <label for="product-name">Tên hãng</label>
                <input type="text" name="product-name" id="collection-name" class="form-control" data-name="<?= $brands['brandName'] ?>"
                    value="<?= $brands['brandName'] ?>" />
            </div>
            <!-- design -->
            <div class="form-group col-12">
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
            <!-- image -->
            <div class="image col-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <?php
                    $i = 1;
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
                                $imagePath = '.' . $brands['imageLogo'];
                                ?>
                                <img src="<?php echo $imagePath ?>" alt="" class="img-fluid" />
                                <div class="btn-tools">

                                    <button class="btn btn-warning btn-update-logoImage">Sửa ảnh</button>
                                    <input type="file" class="input-image" accept="image/*" name="image" id=""
                                        style="display: none;" data-id=" <?= $image['idImage'] ?>">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <!-- save btn -->
            <div class="col-12 d-flex justify-content-center align-items-center">
                <button data-id="<?php echo $id ?>" class="btn btn-info w-50 mt-5 btn-save">Lưu</button>
            </div>

        </div>
    </div>


</div>