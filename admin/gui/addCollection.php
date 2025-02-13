<?php
require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/../../database/brand.php";

$db = new database();
$brand = new brand($db);
// add collection 

if (isset($_POST["add-collection"])) {

    $date = date_create();
    $img = $_FILES["image"];
    $nameCollection = $_POST["nameCollection"];
    $dir = __DIR__ . "/../logoCollection/";
    $target_file = $dir . "image"  . strval(date_timestamp_get($date)) . "." . pathinfo($img["name"], PATHINFO_EXTENSION);
    move_uploaded_file($img["tmp_name"], $target_file);

    $result = $brand->insertBrand($nameCollection, $img);
    echo $result;
}


?>
<div class="add-collection container">
    <div class="title">
        <h1>Thêm hãng</h1>
    </div>
    <div class="content">
        <form action="" method="post" class="row" id="formAddCollection" enctype="multipart/form-data">

            <div class="form-floating mb-3 col-12">
                <input type="text" class="form-control" id="collection-name" placeholder="Tên hãng">
                <label for="collection-name">Tên hãng</label>
            </div>

            <div class="image col-12">
                <div class="accordion accordion-flush" id="accordionFlushExample">

                </div>
            </div>

            <div class="form-group mt-3 d-flex justify-content-center align-items-center col-12">
                <button class="btn btn-success" id="add-image">Thêm ảnh</button>
                <input type="file" name="image" id="image-logo-input" accept="image/*" style="display: none;">
                <button class="btn btn-primary" id="save-collection" type="button">Lưu</button>
            </div>

        </form>
    </div>
</div>