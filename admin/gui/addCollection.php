<?php
// add collection 
if (isset($_POST["add-collection"])) {
    $image = $_FILES['image'];
    $count = $_POST['count'];
    $dir = __DIR__ . "/../imageTmp/";
    $target_file = $dir . "image-" . $count . "." . pathinfo($image["name"], PATHINFO_EXTENSION);

    move_uploaded_file($image["tmp_name"], $target_file);

    echo "./imageTmp/image-" . $count . "." . pathinfo($image["name"], PATHINFO_EXTENSION);
}
// add image
if (isset($_POST['add-image'])) {

    exit();
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