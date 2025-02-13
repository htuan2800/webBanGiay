<?php
require_once __DIR__ . "/../../database/database.php";
require_once __DIR__ . "/../../database/brand.php";

$db = new database();
$brand = new brand($db);
$brands = $brand->selectAll();
// show edit modal
if (isset($_POST['addSubBrand'])) {
    $idCollection = $_POST['idCollection'];
    $subBrandName = $_POST["subName"];
    $brand->insertSubBrand($idCollection, $subBrandName);
    exit();
}

?>
<div class="add-collection container">
    <div class="title">
        <h1>Thêm thiết kế</h1>
    </div>
    <div class="content">
        <form action="" method="post" class="row" id="formAddCollection" enctype="multipart/form-data">


            <div class="form-group col-12">
                <label for="type">Tên hãng</label>
                <select name="type" id="type" class="form-control">
                    <?php
                    foreach ($brands as $Brand) {

                        echo '<option value="' . $Brand['idBrand'] . '">' . $Brand['brandName'] . '</option>';
                    }

                    ?>
                </select>

                <div class="form-floating mt-3 col-12">
                    <input type="text" class="form-control" id="sub_collection-name" placeholder="Tên thiết kế">
                    <label for="collection-name">Tên thiết kế</label>
                </div>

            </div>


            <button class="btn btn-primary" id="add-subCollection" type="button">Thêm</button>
        </form>
    </div>
</div>